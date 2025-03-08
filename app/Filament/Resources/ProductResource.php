<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Jobs\ValidateAddressJob;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->rules(['required', 'max:255'])->markAsRequired(),
                Textarea::make('description')->columnSpan('full')
                    ->rules(['required'])->markAsRequired(),
                Select::make('product_category_id')
                    ->label('Category')
                    ->options(ProductCategory::all()->pluck('name', 'id'))
                    ->rules(['required'])->markAsRequired(),
                Select::make('product_color_id')
                    ->label('Color')
                    ->options(ProductColor::all()->pluck('name', 'id'))
                    ->rules(['required'])->markAsRequired(),
                TextInput::make('address')
                    ->label('Address')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set) => $set('status', 'Pending')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('description'),
                TextColumn::make('category.name')->sortable(),
                TextColumn::make('color.name')->sortable(),
                TextColumn::make('address'),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('created_at'),
                Filter::make('updated_at'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('validate_address')
                ->label('Validate Address')
                ->action(function ($record) {
                    $address = $record->address;
                    if ($address) {
                        ValidateAddressJob::dispatch($record, $address);
                    }
                })
                ->color('secondary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }


}