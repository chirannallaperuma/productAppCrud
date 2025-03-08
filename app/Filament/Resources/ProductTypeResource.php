<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTypeResource\Pages;
use App\Models\ProductType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $label = 'Types';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->rules(['required', 'max:255'])->markAsRequired(),
                TextInput::make('api_unique_number'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProductTypes::route('/'),
            'create' => Pages\CreateProductType::route('/create'),
            'edit' => Pages\EditProductType::route('/{record}/edit'),
        ];
    }
}