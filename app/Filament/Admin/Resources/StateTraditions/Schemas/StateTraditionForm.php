<?php

namespace App\Filament\Admin\Resources\StateTraditions\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StateTraditionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Basic Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Select::make('state_id')
                        ->relationship('state', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('State'),
                    Select::make('category')
                        ->options([
                            'Wedding'   => 'Wedding',
                            'Festival'  => 'Festival',
                            'Harvest'   => 'Harvest',
                            'Religious' => 'Religious',
                            'Social'    => 'Social',
                            'Art'       => 'Art',
                        ])
                        ->required(),
                    TextInput::make('region_specific')
                        ->maxLength(255)
                        ->nullable(),
                ])
                ->columns(2),

            Section::make('Details')
                ->schema([
                    Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                    Textarea::make('significance')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Image')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                        ->collection('tradition_image')
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
