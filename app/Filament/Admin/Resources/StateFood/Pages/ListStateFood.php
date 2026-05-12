<?php

namespace App\Filament\Admin\Resources\StateFood\Pages;

use App\Filament\Admin\Resources\StateFood\StateFoodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStateFood extends ListRecords
{
    protected static string $resource = StateFoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
