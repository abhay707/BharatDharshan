<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\StateFood;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuisineController extends Controller
{
    public function index(Request $request): View
    {
        $query = StateFood::with('state')->orderBy('name');

        if ($request->state) {
            $query->whereHas('state', fn($q) => $q->where('slug', $request->state));
        }
        if ($request->meal_type) {
            $query->where('meal_type', $request->meal_type);
        }
        if ($request->filled('vegetarian')) {
            $query->where('is_vegetarian', filter_var($request->vegetarian, FILTER_VALIDATE_BOOLEAN));
        }

        $foods     = $query->paginate(12)->withQueryString();
        $states    = State::active()->orderBy('name')->get(['id', 'name', 'slug']);
        $mealTypes = StateFood::select('meal_type')->distinct()->orderBy('meal_type')->pluck('meal_type');

        return view('cuisine.index', compact('foods', 'states', 'mealTypes'));
    }
}
