<?php

namespace App\Filament\Admin\Resources\StateTraditions;

use App\Filament\Admin\Resources\StateTraditions\Pages\CreateStateTradition;
use App\Filament\Admin\Resources\StateTraditions\Pages\EditStateTradition;
use App\Filament\Admin\Resources\StateTraditions\Pages\ListStateTraditions;
use App\Filament\Admin\Resources\StateTraditions\Schemas\StateTraditionForm;
use App\Filament\Admin\Resources\StateTraditions\Tables\StateTraditionsTable;
use App\Models\StateTradition;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StateTraditionResource extends Resource
{
    protected static ?string $model = StateTradition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'States Explorer';

    protected static ?string $navigationLabel = 'Traditions';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StateTraditionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StateTraditionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStateTraditions::route('/'),
            'create' => CreateStateTradition::route('/create'),
            'edit'   => EditStateTradition::route('/{record}/edit'),
        ];
    }
}
