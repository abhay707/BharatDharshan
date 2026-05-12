<?php

namespace Database\Seeders;

use App\Models\Festival;
use App\Models\Monument;
use App\Models\State;
use Illuminate\Database\Seeder;

class PresentationSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure every state is visible
        // (States have no is_featured column — ensure all are active instead)
        State::query()->update(['is_active' => true]);

        // Mark key monuments as featured
        Monument::whereIn('slug', [
            'amber-fort',
            'golden-temple',
            'brihadeeswarar-temple',
            'victoria-memorial',
            'hawa-mahal',
            'padmanabhapuram-palace',
            'shore-temple-mahabalipuram',
        ])->update(['is_featured' => true]);

        // Mark key festivals as featured
        Festival::whereIn('slug', [
            'diwali',
            'holi',
            'onam',
            'durga-puja',
            'baisakhi',
            'ganesh-chaturthi',
            'navratri',
            'thrissur-pooram',
            'eid-ul-fitr',
            'thrissur-pooram',
            'pushkar-camel-fair',
        ])->update(['is_featured' => true]);

        $this->command->info('PresentationSeeder complete.');
        $this->command->info('  States active  : ' . State::where('is_active', true)->count());
        $this->command->info('  Monuments feat : ' . Monument::where('is_featured', true)->count());
        $this->command->info('  Festivals feat : ' . Festival::where('is_featured', true)->count());
    }
}
