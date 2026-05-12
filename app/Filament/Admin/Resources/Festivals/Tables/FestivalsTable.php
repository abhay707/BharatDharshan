<?php

namespace App\Filament\Admin\Resources\Festivals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FestivalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('religion')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Hindu'    => 'warning',
                        'Muslim'   => 'success',
                        'Sikh'     => 'warning',
                        'Christian' => 'primary',
                        'Buddhist' => 'info',
                        'Jain'     => 'info',
                        'Tribal'   => 'gray',
                        'Secular'  => 'primary',
                        default    => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('month')
                    ->label('Month')
                    ->formatStateUsing(
                        fn ($state) => \DateTime::createFromFormat('!m', $state)->format('F')
                    )
                    ->sortable(),

                TextColumn::make('is_national')
                    ->label('Scope')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state ? 'National' : 'Regional')
                    ->color(fn ($state): string => $state ? 'success' : 'gray'),

                ToggleColumn::make('is_featured')
                    ->label('Featured'),

                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->filters([
                SelectFilter::make('month')
                    ->options(
                        collect(range(1, 12))
                            ->mapWithKeys(fn ($m) => [
                                $m => \DateTime::createFromFormat('!m', $m)->format('F'),
                            ])
                            ->all()
                    ),

                SelectFilter::make('religion')
                    ->options([
                        'Hindu'    => 'Hindu',
                        'Muslim'   => 'Muslim',
                        'Sikh'     => 'Sikh',
                        'Christian' => 'Christian',
                        'Buddhist' => 'Buddhist',
                        'Jain'     => 'Jain',
                        'Tribal'   => 'Tribal',
                        'Secular'  => 'Secular',
                        'Other'    => 'Other',
                    ]),

                TernaryFilter::make('is_national')
                    ->label('National'),

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
