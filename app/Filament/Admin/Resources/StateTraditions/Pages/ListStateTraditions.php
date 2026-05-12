<?php

namespace App\Filament\Admin\Resources\StateTraditions\Pages;

use App\Filament\Admin\Resources\StateTraditions\StateTraditionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStateTraditions extends ListRecords
{
    protected static string $resource = StateTraditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
