<?php

namespace App\Filament\Admin\Resources\StateFood\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StateFoodTable
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
                TextColumn::make('meal_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Breakfast' => 'info',
                        'Lunch'     => 'success',
                        'Dinner'    => 'warning',
                        'Snack'     => 'gray',
                        'Dessert'   => 'primary',
                        'Drink'     => 'danger',
                    }),
                IconColumn::make('is_vegetarian')
                    ->label('Veg')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->relationship('state', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('meal_type')
                    ->options([
                        'Breakfast' => 'Breakfast',
                        'Lunch'     => 'Lunch',
                        'Dinner'    => 'Dinner',
                        'Snack'     => 'Snack',
                        'Dessert'   => 'Dessert',
                        'Drink'     => 'Drink',
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
