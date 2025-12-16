<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables\Table;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\Collection;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->money('USD', 100)
                    ->summarize(Sum::make()->money('USD', 100))
                    ->sortable(),
                ToggleColumn::make('is_complete')
                    ->toggleable()
                    ->afterStateUpdated(function ($record, $state) {
                        if (method_exists($record, 'save')) {
                            $record->is_complete = $state;
                            $record->save();
                        }
                        Notification::make()
                            ->title('Order status updated!')
                            ->success()
                            ->body('The order completion status has been updated successfully.')
                            ->send();
                    })
                    ->label('Is Completed'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultGroup('product.name')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('Mark as Complete')
                        ->icon(Heroicon::OutlinedCheckBadge)
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records
                            ->each(function ($record) {
                                $record->is_complete = true;
                                $record->save();

                            }))
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('Mark as Not Complete')
                        ->icon(Heroicon::OutlinedCheckBadge)
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records
                            ->each(function ($record) {
                                $record->is_complete = false;
                                $record->save();
                            }))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
