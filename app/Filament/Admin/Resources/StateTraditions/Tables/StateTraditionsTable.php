<?php

namespace App\Filament\Admin\Resources\StateTraditions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StateTraditionsTable
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
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Wedding'   => 'primary',
                        'Festival'  => 'warning',
                        'Harvest'   => 'success',
                        'Religious' => 'info',
                        'Social'    => 'gray',
                        'Art'       => 'danger',
                    }),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->relationship('state', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category')
                    ->options([
                        'Wedding'   => 'Wedding',
                        'Festival'  => 'Festival',
                        'Harvest'   => 'Harvest',
                        'Religious' => 'Religious',
                        'Social'    => 'Social',
                        'Art'       => 'Art',
                    ]),
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
