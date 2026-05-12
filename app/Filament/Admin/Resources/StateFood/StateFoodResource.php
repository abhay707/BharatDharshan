<?php

namespace App\Filament\Admin\Resources\StateFood;

use App\Filament\Admin\Resources\StateFood\Pages\CreateStateFood;
use App\Filament\Admin\Resources\StateFood\Pages\EditStateFood;
use App\Filament\Admin\Resources\StateFood\Pages\ListStateFood;
use App\Filament\Admin\Resources\StateFood\Schemas\StateFoodForm;
use App\Filament\Admin\Resources\StateFood\Tables\StateFoodTable;
use App\Models\StateFood;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StateFoodResource extends Resource
{
    protected static ?string $model = StateFood::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCake;

    protected static string|UnitEnum|null $navigationGroup = 'States Explorer';

    protected static ?string $navigationLabel = 'Foods';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StateFoodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StateFoodTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStateFood::route('/'),
            'create' => CreateStateFood::route('/create'),
            'edit'   => EditStateFood::route('/{record}/edit'),
        ];
    }
}
