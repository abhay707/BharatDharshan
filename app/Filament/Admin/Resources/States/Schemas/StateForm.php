<?php

namespace App\Filament\Admin\Resources\States\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Basic Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('capital')
                        ->required()
                        ->maxLength(255),
                    Select::make('region')
                        ->options([
                            'North'     => 'North',
                            'South'     => 'South',
                            'East'      => 'East',
                            'West'      => 'West',
                            'Northeast' => 'Northeast',
                            'Central'   => 'Central',
                        ])
                        ->required(),
                    TextInput::make('language')
                        ->required()
                        ->maxLength(255),
                    DatePicker::make('established_date'),
                ])
                ->columns(2),

            Section::make('Details')
                ->schema([
                    Textarea::make('description')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),
                    TextInput::make('population')
                        ->numeric()
                        ->minValue(0),
                    TextInput::make('area_sq_km')
                        ->numeric()
                        ->minValue(0)
                        ->label('Area (sq km)'),
                ])
                ->columns(2),

            Section::make('Media & Status')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('cover_image')
                        ->collection('cover_image')
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->default(true),
                ]),
        ]);
    }
}
