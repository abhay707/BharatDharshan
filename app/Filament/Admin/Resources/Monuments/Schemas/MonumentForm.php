<?php

namespace App\Filament\Admin\Resources\Monuments\Schemas;

use App\Models\State;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MonumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Basic Information')
                ->schema([
                    Select::make('state_id')
                        ->label('State')
                        ->options(State::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Select::make('type')
                        ->options([
                            'Fort'      => 'Fort',
                            'Temple'    => 'Temple',
                            'Stepwell'  => 'Stepwell',
                            'Cave'      => 'Cave',
                            'Palace'    => 'Palace',
                            'Mosque'    => 'Mosque',
                            'Church'    => 'Church',
                            'Stupa'     => 'Stupa',
                            'Lake'      => 'Lake',
                            'Park'      => 'Park',
                            'Memorial'  => 'Memorial',
                            'Other'     => 'Other',
                        ])
                        ->required(),

                    Select::make('category')
                        ->options([
                            'UNESCO'           => 'UNESCO World Heritage',
                            'ASI'              => 'ASI Protected',
                            'Religious'        => 'Religious',
                            'Natural'          => 'Natural',
                            'State_Protected'  => 'State Protected',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Section::make('Descriptions')
                ->schema([
                    Textarea::make('short_description')
                        ->required()
                        ->maxLength(300)
                        ->rows(3)
                        ->columnSpanFull(),

                    RichEditor::make('full_description')
                        ->required()
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'link', 'bulletList', 'orderedList',
                            'blockquote', 'h2', 'h3', 'redo', 'undo',
                        ]),
                ]),

            Section::make('History & Builder')
                ->schema([
                    TextInput::make('built_by')
                        ->maxLength(255),

                    TextInput::make('built_in_year')
                        ->label('Built In Year')
                        ->numeric()
                        ->minValue(-3000)
                        ->maxValue(2100),

                    TextInput::make('dynasty_or_period')
                        ->maxLength(255),
                ])
                ->columns(3),

            Section::make('Visitor Information')
                ->schema([
                    TextInput::make('entry_fee_indian')
                        ->label('Entry Fee — Indian (₹)')
                        ->numeric()
                        ->minValue(0)
                        ->prefix('₹'),

                    TextInput::make('entry_fee_foreign')
                        ->label('Entry Fee — Foreign (₹)')
                        ->numeric()
                        ->minValue(0)
                        ->prefix('₹'),

                    Textarea::make('best_time_to_visit')
                        ->required()
                        ->rows(2),

                    Textarea::make('visiting_hours')
                        ->required()
                        ->rows(2),

                    Textarea::make('address')
                        ->required()
                        ->rows(2)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Location')
                ->schema([
                    TextInput::make('latitude')
                        ->numeric()
                        ->rules(['nullable', 'between:-90,90']),

                    TextInput::make('longitude')
                        ->numeric()
                        ->rules(['nullable', 'between:-180,180']),
                ])
                ->columns(2),

            Section::make('Gallery')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->maxFiles(10)
                        ->reorderable()
                        ->columnSpanFull(),
                ]),

            Section::make('Highlights')
                ->schema([
                    Repeater::make('highlights')
                        ->relationship()
                        ->schema([
                            TextInput::make('highlight')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. Stunning Mughal architecture'),
                        ])
                        ->addActionLabel('Add Highlight')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

            Section::make('Visitor Tips')
                ->schema([
                    Repeater::make('tips')
                        ->relationship()
                        ->schema([
                            Select::make('tip_type')
                                ->options([
                                    'General'      => 'General',
                                    'Photography'  => 'Photography',
                                    'Transport'    => 'Transport',
                                    'Clothing'     => 'Clothing',
                                    'Food'         => 'Food',
                                    'Timing'       => 'Timing',
                                ])
                                ->required(),

                            Textarea::make('tip')
                                ->required()
                                ->rows(2),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Tip')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

            Section::make('Status')
                ->schema([
                    Toggle::make('is_featured')
                        ->label('Featured Monument')
                        ->default(false),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ])
                ->columns(2),

        ]);
    }
}
