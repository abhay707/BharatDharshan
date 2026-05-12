<?php

namespace App\Filament\Admin\Resources\Monuments;

use App\Filament\Admin\Resources\Monuments\Pages\CreateMonument;
use App\Filament\Admin\Resources\Monuments\Pages\EditMonument;
use App\Filament\Admin\Resources\Monuments\Pages\ListMonuments;
use App\Filament\Admin\Resources\Monuments\Schemas\MonumentForm;
use App\Filament\Admin\Resources\Monuments\Tables\MonumentsTable;
use App\Models\Monument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MonumentResource extends Resource
{
    protected static ?string $model = Monument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Heritage';

    protected static ?string $navigationLabel = 'Monuments';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return MonumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMonuments::route('/'),
            'create' => CreateMonument::route('/create'),
            'edit'   => EditMonument::route('/{record}/edit'),
        ];
    }
}
