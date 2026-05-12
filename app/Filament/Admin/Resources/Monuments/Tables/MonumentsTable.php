<?php

namespace App\Filament\Admin\Resources\Monuments\Tables;

use App\Models\State;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MonumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('state.name')
                    ->label('State')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fort'     => 'warning',
                        'Temple'   => 'primary',
                        'Stepwell' => 'info',
                        'Cave'     => 'gray',
                        'Palace'   => 'success',
                        'Mosque'   => 'primary',
                        'Church'   => 'info',
                        'Stupa'    => 'warning',
                        'Lake'     => 'info',
                        'Park'     => 'success',
                        'Memorial' => 'danger',
                        default    => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'UNESCO'          => 'warning',
                        'ASI'             => 'primary',
                        'Religious'       => 'danger',
                        'Natural'         => 'success',
                        'State_Protected' => 'info',
                        default           => 'gray',
                    })
                    ->sortable(),

                ToggleColumn::make('is_featured')
                    ->label('Featured'),

                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->filters([
                SelectFilter::make('state_id')
                    ->label('State')
                    ->options(State::orderBy('name')->pluck('name', 'id')),

                SelectFilter::make('type')
                    ->options([
                        'Fort'     => 'Fort',
                        'Temple'   => 'Temple',
                        'Stepwell' => 'Stepwell',
                        'Cave'     => 'Cave',
                        'Palace'   => 'Palace',
                        'Mosque'   => 'Mosque',
                        'Church'   => 'Church',
                        'Stupa'    => 'Stupa',
                        'Lake'     => 'Lake',
                        'Park'     => 'Park',
                        'Memorial' => 'Memorial',
                        'Other'    => 'Other',
                    ]),

                SelectFilter::make('category')
                    ->options([
                        'UNESCO'          => 'UNESCO World Heritage',
                        'ASI'             => 'ASI Protected',
                        'Religious'       => 'Religious',
                        'Natural'         => 'Natural',
                        'State_Protected' => 'State Protected',
                    ]),

                TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
