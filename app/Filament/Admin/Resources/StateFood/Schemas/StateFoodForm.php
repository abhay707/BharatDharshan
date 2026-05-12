<?php

namespace App\Filament\Admin\Resources\StateFood\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StateFoodForm
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
                    Select::make('state_id')
                        ->relationship('state', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('State'),
                    Select::make('meal_type')
                        ->options([
                            'Breakfast' => 'Breakfast',
                            'Lunch'     => 'Lunch',
                            'Dinner'    => 'Dinner',
                            'Snack'     => 'Snack',
                            'Dessert'   => 'Dessert',
                            'Drink'     => 'Drink',
                        ])
                        ->required(),
                    Toggle::make('is_vegetarian')
                        ->default(true)
                        ->label('Vegetarian'),
                ])
                ->columns(2),

            Section::make('Details')
                ->schema([
                    Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                    Textarea::make('ingredients')
                        ->rows(3)
                        ->columnSpanFull(),
                    Textarea::make('origin_story')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                        ->collection('food_image')
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
