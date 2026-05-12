<?php

namespace App\Filament\Admin\Resources\StateTraditions\Pages;

use App\Filament\Admin\Resources\StateTraditions\StateTraditionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStateTradition extends EditRecord
{
    protected static string $resource = StateTraditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
