<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Catalogue';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Product Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General Information')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        Forms\Components\Select::make('brand_id')
                                            ->relationship('brand', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->nullable(),

                                        Forms\Components\Select::make('status')
                                            ->options([
                                                'active'   => 'Active (Visible)',
                                                'draft'    => 'Draft (Hidden)',
                                                'archived' => 'Archived',
                                            ])
                                            ->default('active')
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                    ]),

                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('sku')
                                            ->label('SKU')
                                            ->required()
                                            ->maxLength(100)
                                            ->unique(ignoreRecord: true),

                                        Forms\Components\TextInput::make('model_number')
                                            ->maxLength(100),

                                        Forms\Components\Select::make('pricing_type')
                                            ->options([
                                                'fixed'           => 'Fixed Price (Instant Purchase)',
                                                'quote_preferred' => 'Quote Preferred (ICU/Complex)',
                                                'quote_only'      => 'Quote Only (High Value/Tender)',
                                            ])
                                            ->default('fixed')
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('price')
                                            ->numeric()
                                            ->prefix('NGN')
                                            ->nullable(),

                                        Forms\Components\TextInput::make('compare_price')
                                            ->label('Original / Compare Price')
                                            ->numeric()
                                            ->prefix('NGN')
                                            ->nullable(),
                                    ]),

                                Forms\Components\Textarea::make('short_description')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('description')
                                    ->rows(5)
                                    ->columnSpanFull(),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Featured on Homepage')
                                            ->default(false),

                                        Forms\Components\Toggle::make('is_new')
                                            ->label('New Arrival Badge')
                                            ->default(false),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Features & Warranty')
                            ->schema([
                                Forms\Components\Textarea::make('features')
                                    ->label('Key Clinical Features (One per line)')
                                    ->rows(6)
                                    ->placeholder("SmartCare/PS automated weaning\nAutoFlow pressure regulation\nNeoFlow neonatal monitoring"),

                                Forms\Components\Textarea::make('warranty_info')
                                    ->label('Warranty & Service Details')
                                    ->rows(3)
                                    ->placeholder('2-year manufacturer warranty with optional biomedical service agreement.'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Technical Specifications')
                            ->schema([
                                Forms\Components\Repeater::make('specifications')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('group_name')
                                            ->label('Group (e.g. Technical, Physical, Power)')
                                            ->required(),

                                        Forms\Components\TextInput::make('label')
                                            ->label('Parameter Label (e.g. Tidal Volume)')
                                            ->required(),

                                        Forms\Components\TextInput::make('value')
                                            ->label('Parameter Value (e.g. 20–2000 mL)')
                                            ->required(),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(4)
                                    ->defaultItems(0)
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(35),

                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->fontFamily('mono')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('price')
                    ->money('NGN')
                    ->sortable()
                    ->placeholder('Quote Only'),

                Tables\Columns\TextColumn::make('pricing_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fixed'           => 'success',
                        'quote_preferred' => 'warning',
                        'quote_only'      => 'danger',
                        default           => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active'   => 'success',
                        'draft'    => 'gray',
                        'archived' => 'danger',
                        default    => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active'   => 'Active',
                        'draft'    => 'Draft',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('pricing_type')
                    ->options([
                        'fixed'           => 'Fixed',
                        'quote_preferred' => 'Quote Preferred',
                        'quote_only'      => 'Quote Only',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

