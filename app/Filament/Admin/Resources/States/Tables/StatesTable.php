<?php

namespace App\Filament\Admin\Resources\States\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class StatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('region')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'North'     => 'info',
                        'South'     => 'success',
                        'East'      => 'warning',
                        'West'      => 'danger',
                        'Northeast' => 'primary',
                        'Central'   => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('capital')
                    ->searchable(),
                TextColumn::make('language'),
                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->filters([
                SelectFilter::make('region')
                    ->options([
                        'North'     => 'North',
                        'South'     => 'South',
                        'East'      => 'East',
                        'West'      => 'West',
                        'Northeast' => 'Northeast',
                        'Central'   => 'Central',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active'),
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
