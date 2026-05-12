<?php

namespace App\Filament\Admin\Resources\StateFood\Pages;

use App\Filament\Admin\Resources\StateFood\StateFoodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStateFood extends EditRecord
{
    protected static string $resource = StateFoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
