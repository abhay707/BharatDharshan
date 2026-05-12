<?php

namespace App\Filament\Admin\Resources\Festivals\Schemas;

use App\Models\State;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FestivalForm
{
    private const RELIGIONS = [
        'Hindu'    => 'Hindu',
        'Muslim'   => 'Muslim',
        'Sikh'     => 'Sikh',
        'Christian' => 'Christian',
        'Buddhist' => 'Buddhist',
        'Jain'     => 'Jain',
        'Tribal'   => 'Tribal',
        'Secular'  => 'Secular',
        'Other'    => 'Other',
    ];

    private const TIP_CATEGORIES = [
        'What_to_Wear'  => 'What to Wear',
        'What_to_Eat'   => 'What to Eat',
        'What_to_Carry' => 'What to Carry',
        'Photography'   => 'Photography',
        'Safety'        => 'Safety',
        'Transport'     => 'Transport',
        'Etiquette'     => 'Etiquette',
        'Best_Spots'    => 'Best Spots',
    ];

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

                    TextInput::make('tagline')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('religion')
                        ->options(self::RELIGIONS)
                        ->required(),

                    Select::make('state_id')
                        ->label('Primary State')
                        ->options(State::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->nullable()
                        ->required(fn (Get $get): bool => ! $get('is_national'))
                        ->helperText('Leave blank for national festivals.'),

                    Toggle::make('is_national')
                        ->label('National Festival')
                        ->live()
                        ->default(false)
                        ->afterStateUpdated(function ($state, $set) {
                            if ($state) {
                                $set('state_id', null);
                            }
                        }),
                ])
                ->columns(2),

            Section::make('Timing')
                ->schema([
                    Select::make('month')
                        ->options(
                            collect(range(1, 12))
                                ->mapWithKeys(fn ($m) => [
                                    $m => \DateTime::createFromFormat('!m', $m)->format('F'),
                                ])
                                ->all()
                        )
                        ->required(),

                    TextInput::make('duration_days')
                        ->label('Duration (days)')
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                    TextInput::make('start_day')
                        ->label('Start Day of Month')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(31),

                    TextInput::make('end_day')
                        ->label('End Day of Month')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(31),
                ])
                ->columns(4),

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

                    Textarea::make('significance')
                        ->label('Cultural / Religious Significance')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('how_celebrated')
                        ->label('How It Is Celebrated')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Media')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('cover_image')
                        ->label('Cover Image')
                        ->collection('festival-cover')
                        ->image()
                        ->imageEditor()
                        ->maxFiles(1),

                    SpatieMediaLibraryFileUpload::make('gallery')
                        ->label('Gallery')
                        ->collection('festival-gallery')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->maxFiles(8)
                        ->reorderable(),
                ])
                ->columns(2),

            Section::make('Celebrating States')
                ->description('Select all states where this festival is widely celebrated.')
                ->schema([
                    CheckboxList::make('celebratingStates')
                        ->label('')
                        ->relationship('celebratingStates', 'name')
                        ->searchable()
                        ->bulkToggleable()
                        ->columns(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Visitor Tips')
                ->schema([
                    Repeater::make('tips')
                        ->relationship()
                        ->schema([
                            Select::make('tip_category')
                                ->options(self::TIP_CATEGORIES)
                                ->required(),

                            TextInput::make('tip_title')
                                ->required()
                                ->maxLength(255),

                            Textarea::make('tip_body')
                                ->required()
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Tip')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

            Section::make('Rituals')
                ->schema([
                    Repeater::make('rituals')
                        ->relationship()
                        ->schema([
                            TextInput::make('ritual_name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('ritual_timing')
                                ->placeholder('e.g. At sunset, Day 1')
                                ->maxLength(255),

                            Textarea::make('ritual_description')
                                ->required()
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Ritual')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

            Section::make('Status')
                ->schema([
                    Toggle::make('is_featured')
                        ->label('Featured Festival')
                        ->default(false),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ])
                ->columns(2),

        ]);
    }
}
