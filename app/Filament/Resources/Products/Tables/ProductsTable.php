<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Tables\Table;
use App\Enum\ProductStatusEnum;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\Products\ProductsResource;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->url(fn(Product $record): string => ProductsResource::getUrl('edit', ['record' => $record]))
                    ->label('Product Name'),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('EGP', 100),
                TextColumn::make('status')->badge()
                    ->label('Status'),
                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle'),
                TextColumn::make('category.name'),
                TextColumn::make('tags.name')->badge(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->options(ProductStatusEnum::class),
                SelectFilter::make('category')
                    ->label('Category')
                    ->relationship('category', 'name'),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['created_from'], function (Builder $query, $created_from): Builder {
                            return $query->where('created_at', '>=', $created_from);
                        });
                    }),
                Filter::make('created_until')
                    ->schema([
                        DatePicker::make('created_until')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['created_until'], function (Builder $query, $created_until): Builder {
                            return $query->where('created_at', '<=', $created_until);
                        });
                    }),
                ], layout: FiltersLayout::AboveContentCollapsible)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
