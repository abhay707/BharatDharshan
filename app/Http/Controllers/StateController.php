<?php

namespace App\Http\Controllers;

use App\Models\Monument;
use App\Models\State;
use App\Models\Festival;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StateController extends Controller
{
    public function index(): View
    {
        $grouped_by_region = State::active()
            ->orderBy('name')
            ->get()
            ->groupBy('region');

        $states = $grouped_by_region->flatten();

        return view('states.index', compact('states', 'grouped_by_region'));
    }

    public function show(string $slug): View
    {
        $state = State::where('slug', $slug)
            ->where('is_active', true)
            ->with(['culture', 'traditions'])
            ->firstOrFail();

        $foods = $state->foods()->orderBy('meal_type')->orderBy('name')->get();

        $monumentCount = Monument::active()->where('state_id', $state->id)->count();

        $stateFestivals = $state->allFestivals()
            ->where('festivals.is_active', true)
            ->orderBy('festivals.month')
            ->limit(6)
            ->get();

        return view('states.show', compact('state', 'foods', 'monumentCount', 'stateFestivals'));
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->string('q')->trim();

        $states = State::active()
            ->when($query, fn ($q) => $q->where('name', 'like', "%{$query}%"))
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'slug', 'region']);

        return response()->json($states);
    }
}
