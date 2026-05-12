<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use App\Models\Monument;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 1 — Hero stats
        $stats = [
            'states'    => State::active()->count(),
            'monuments' => Monument::active()->count(),
            'festivals' => Festival::active()->count(),
            'foods'     => DB::table('state_foods')->count(),
        ];

        // 2 — Featured monuments (up to 4, is_featured = true)
        $featuredMonuments = Monument::active()
            ->featured()
            ->with(['state', 'media'])
            ->limit(4)
            ->get();

        // 3 — Featured festivals (up to 6, is_featured = true, ordered by month)
        $featuredFestivals = Festival::active()
            ->featured()
            ->with('state')
            ->orderBy('month')
            ->limit(6)
            ->get();

        // 4 — Featured states: 6 active, culture + all foods (sliced in view) + counts
        $featuredStates = State::active()
            ->with(['culture', 'foods' => fn ($q) => $q->orderBy('name')])
            ->withCount(['monuments', 'allFestivals'])
            ->orderBy('name')
            ->limit(6)
            ->get();

        // 5 — Upcoming festivals: next 3 by month (wraps year-boundary correctly)
        $currentMonth = Carbon::now()->month;

        $upcomingFestivals = Festival::active()
            ->with('state')
            ->orderByRaw(
                'CASE WHEN month >= ? THEN 0 ELSE 1 END, month, COALESCE(start_day, 0)',
                [$currentMonth]
            )
            ->limit(3)
            ->get();

        // 6 — Festival distribution by religion
        $festivalsByReligion = Festival::active()
            ->select('religion', DB::raw('count(*) as total'))
            ->groupBy('religion')
            ->orderByDesc('total')
            ->pluck('total', 'religion');

        // 7 — Monument distribution by type
        $monumentsByType = Monument::active()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderByDesc('total')
            ->pluck('total', 'type');

        return view('home.index', [
            'stats'               => $stats,
            'featured_monuments'  => $featuredMonuments,
            'featured_festivals'  => $featuredFestivals,
            'featured_states'     => $featuredStates,
            'upcoming_festivals'  => $upcomingFestivals,
            'festivals_by_religion' => $festivalsByReligion,
            'monuments_by_type'   => $monumentsByType,
            // camelCase aliases for any views that use them
            'featuredMonuments'   => $featuredMonuments,
            'featuredFestivals'   => $featuredFestivals,
            'featuredStates'      => $featuredStates,
            'upcomingFestivals'   => $upcomingFestivals,
            'festivalsByReligion' => $festivalsByReligion,
            'monumentsByType'     => $monumentsByType,
        ]);
    }
}
