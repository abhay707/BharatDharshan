<?php

namespace App\Filament\Admin\Resources\Festivals;

use App\Filament\Admin\Resources\Festivals\Pages\CreateFestival;
use App\Filament\Admin\Resources\Festivals\Pages\EditFestival;
use App\Filament\Admin\Resources\Festivals\Pages\ListFestivals;
use App\Filament\Admin\Resources\Festivals\Schemas\FestivalForm;
use App\Filament\Admin\Resources\Festivals\Tables\FestivalsTable;
use App\Models\Festival;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FestivalResource extends Resource
{
    protected static ?string $model = Festival::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Festivals';

    protected static ?string $navigationLabel = 'Festivals';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FestivalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FestivalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFestivals::route('/'),
            'create' => CreateFestival::route('/create'),
            'edit'   => EditFestival::route('/{record}/edit'),
        ];
    }
}
