<?php

namespace App\Http\Controllers;

use App\Models\Festival;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FestivalController extends Controller
{
    private const RELIGIONS = [
        'Hindu', 'Muslim', 'Sikh', 'Christian',
        'Buddhist', 'Jain', 'Tribal', 'Secular', 'Other',
    ];

    public function index(Request $request): View
    {
        $festivals = Festival::active()
            ->with(['state', 'celebratingStates', 'tips'])
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->month, fn ($q, $m) => $q->byMonth((int) $m))
            ->when($request->religion, fn ($q, $r) => $q->byReligion($r))
            ->when($request->state, function ($q, $stateSlug) {
                $q->where(function ($inner) use ($stateSlug) {
                    $inner->whereHas('state', fn ($s) => $s->where('slug', $stateSlug))
                          ->orWhereHas('celebratingStates', fn ($s) => $s->where('slug', $stateSlug));
                });
            })
            ->when($request->filled('is_national'), function ($q) use ($request) {
                $q->where('is_national', filter_var($request->is_national, FILTER_VALIDATE_BOOLEAN));
            })
            ->orderBy('month')
            ->orderBy('name')
            ->get();

        $groupedByMonth   = $festivals->groupBy('month');
        $festivalsByReligion = $festivals->groupBy('religion')->map->count();

        $months = collect(range(1, 12))->mapWithKeys(
            fn ($m) => [$m => \DateTime::createFromFormat('!m', $m)->format('F')]
        );

        $states = State::active()->orderBy('name')->get(['id', 'name', 'slug']);

        $activeFilters = array_filter([
            'month'       => $request->month,
            'religion'    => $request->religion,
            'state'       => $request->state,
            'search'      => $request->search,
            'is_national' => $request->filled('is_national') ? $request->is_national : null,
        ]);

        return view('festivals.index', [
            'festivals'            => $festivals,
            'grouped_by_month'     => $groupedByMonth,
            'festivals_by_religion'=> $festivalsByReligion,
            'months'               => $months,
            'religions'            => self::RELIGIONS,
            'states'               => $states,
            'current_month'        => Carbon::now()->month,
            'active_filters'       => $activeFilters,
        ]);
    }

    public function show(string $slug): View
    {
        $festival = Festival::where('slug', $slug)
            ->where('is_active', true)
            ->with(['state', 'celebratingStates', 'rituals'])
            ->firstOrFail();

        $festival->load('tips', 'media');

        $tipsByCategory = $festival->tips->groupBy('tip_category');

        $related = Festival::active()
            ->where('id', '!=', $festival->id)
            ->where(function ($q) use ($festival) {
                $q->where('religion', $festival->religion)
                  ->orWhere('month', $festival->month);
            })
            ->with(['state', 'media'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('festivals.show', compact('festival', 'tipsByCategory', 'related'));
    }

    public function calendar(Request $request): JsonResponse
    {
        $festivals = Festival::active()
            ->with(['state', 'media'])
            ->orderBy('month')
            ->orderBy('start_day')
            ->get()
            ->map(fn ($f) => [
                'id'              => $f->id,
                'name'            => $f->name,
                'slug'            => $f->slug,
                'month'           => $f->month,
                'start_day'       => $f->start_day,
                'religion'        => $f->religion,
                'cover_image_url' => $f->getFirstMediaUrl('festival-cover'),
                'is_national'     => $f->is_national,
                'state_name'      => $f->state?->name,
            ])
            ->groupBy('month');

        return response()->json($festivals);
    }
}
