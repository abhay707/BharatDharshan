<?php

namespace App\Filament\Admin\Resources\Monuments\Pages;

use App\Filament\Admin\Resources\Monuments\MonumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMonument extends EditRecord
{
    protected static string $resource = MonumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
