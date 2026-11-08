<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\ProductImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Product photos';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('path')
                ->label('Photo')
                ->image()
                ->disk(ProductImage::uploadDisk())
                ->directory('products')
                ->maxSize(4096)
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('alt_text')
                ->label('Short description')
                ->maxLength(255),
            Forms\Components\TextInput::make('sort_order')
                ->label('Order')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_primary')
                ->label('Use as the main photo')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt_text')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Photo')
                    ->disk(ProductImage::uploadDisk())
                    ->height(60),
                Tables\Columns\TextColumn::make('alt_text')->label('Description'),
                Tables\Columns\IconColumn::make('is_primary')->label('Main')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Order')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
