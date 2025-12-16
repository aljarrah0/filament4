<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
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
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    // Action::make('Mark as Complete')
                    //     ->requiresConfirmation()
                    //     ->icon(Heroicon::OutlinedCheckBadge)
                    //     ->hidden(fn(Order $record) => $record->is_complete)
                    //     ->action(function ($record) {
                    //         $record->is_complete = true;
                    //         $record->save();
                    //     }),
                    Action::make('Change is Completed')
                        ->icon(Heroicon::OutlinedCheckBadge)
                        ->fillForm(fn(Order $order) => ['is_completed' => $order->is_complete])
                        ->schema([
                            Toggle::make('is_completed')->label('Is Completed'),
                        ])
                        ->action(function (array $data, Order $order) {
                            $order->is_complete = $data['is_completed'];
                            $order->save();
                        })
                ])
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
