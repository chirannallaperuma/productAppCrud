<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductColorResource\Pages;
use App\Models\ProductColor;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductColorResource extends Resource
{
    protected static ?string $model = ProductColor::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $label = 'Colors';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    TextInput::make('name')
                        ->rules(['required', 'max:255'])->markAsRequired(),
                ]),
                Grid::make(1)->schema([
                    Textarea::make('description'),
                ]),
                Grid::make(1)->schema([
                    TextInput::make('hex_code'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('hex_code'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProductColors::route('/'),
            'create' => Pages\CreateProductColor::route('/create'),
            'edit' => Pages\EditProductColor::route('/{record}/edit'),
        ];
    }
}