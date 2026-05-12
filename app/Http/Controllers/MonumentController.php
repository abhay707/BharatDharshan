<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use App\Models\Monument;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonumentController extends Controller
{
    private const TYPES = [
        'Fort', 'Temple', 'Stepwell', 'Cave', 'Palace',
        'Mosque', 'Church', 'Stupa', 'Lake', 'Park', 'Memorial', 'Other',
    ];

    private const CATEGORIES = [
        'UNESCO'          => 'UNESCO World Heritage',
        'ASI'             => 'ASI Protected',
        'Religious'       => 'Religious',
        'Natural'         => 'Natural',
        'State_Protected' => 'State Protected',
    ];

    public function index(Request $request): View
    {
        $featured = Monument::active()
            ->featured()
            ->with(['state', 'media'])
            ->limit(8)
            ->get();

        $monuments = Monument::active()
            ->with(['state', 'media'])
            ->when($request->state, function ($q, $stateSlug) {
                $q->whereHas('state', fn ($s) => $s->where('slug', $stateSlug));
            })
            ->when($request->type, fn ($q, $type) => $q->where('type', $type))
            ->when($request->category, fn ($q, $cat) => $q->where('category', $cat))
            ->orderBy('is_featured', 'desc')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $states = State::active()->orderBy('name')->get(['id', 'name', 'slug']);

        $currentMonth = Carbon::now()->month;
        $upcomingFestivals = Festival::active()
            ->with('state')
            ->orderByRaw('CASE WHEN month >= ? THEN 0 ELSE 1 END, month, COALESCE(start_day, 0)', [$currentMonth])
            ->limit(3)
            ->get();

        return view('monuments.index', [
            'monuments'         => $monuments,
            'featured'          => $featured,
            'states'            => $states,
            'types'             => self::TYPES,
            'categories'        => self::CATEGORIES,
            'upcomingFestivals' => $upcomingFestivals,
        ]);
    }

    public function show(string $slug): View
    {
        $monument = Monument::where('slug', $slug)
            ->where('is_active', true)
            ->with(['state', 'highlights', 'tips'])
            ->firstOrFail();

        $monument->load('media');

        $tipsByType = $monument->tips->groupBy('tip_type');

        $related = Monument::active()
            ->where('state_id', $monument->state_id)
            ->where('id', '!=', $monument->id)
            ->with('media')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('monuments.show', compact('monument', 'tipsByType', 'related'));
    }

    public function byState(string $stateSlug): View
    {
        $state = State::where('slug', $stateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $monumentsByType = Monument::active()
            ->where('state_id', $state->id)
            ->with(['highlights', 'media'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('name')
            ->get()
            ->groupBy('type');

        return view('monuments.by-state', compact('state', 'monumentsByType'));
    }
}
