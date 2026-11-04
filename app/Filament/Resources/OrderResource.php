<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'E-Commerce';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->disabled()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'    => 'Pending',
                                'confirmed'  => 'Confirmed',
                                'processing' => 'Processing',
                                'shipped'    => 'Shipped',
                                'delivered'  => 'Delivered',
                                'cancelled'  => 'Cancelled',
                                'refunded'   => 'Refunded',
                            ])
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending'  => 'Pending',
                                'paid'     => 'Paid',
                                'failed'   => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->prefix('NGN')
                            ->disabled(),
                    ])->columns(4),

                Forms\Components\Section::make('Customer & Delivery Information')
                    ->schema([
                        Forms\Components\TextInput::make('guest_name')
                            ->label('Customer / Contact Name')
                            ->required(),

                        Forms\Components\TextInput::make('guest_email')
                            ->label('Email Address')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('guest_phone')
                            ->label('Telephone')
                            ->required(),

                        Forms\Components\Select::make('shipping_method_id')
                            ->relationship('shippingMethod', 'name')
                            ->nullable(),

                        Forms\Components\Textarea::make('customer_note')
                            ->label('Customer Note / Special Delivery Request')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('admin_note')
                            ->label('Internal Dispatch / Biomedical Notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Equipment Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('product_sku')
                                    ->label('SKU'),

                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->required(),

                                Forms\Components\TextInput::make('unit_price')
                                    ->numeric()
                                    ->prefix('NGN')
                                    ->required(),

                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->prefix('NGN')
                                    ->required(),
                            ])
                            ->columns(6)
                            ->addable(false)
                            ->deletable(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Customer / Facility')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('guest_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('total')
                    ->money('NGN')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'    => 'warning',
                        'confirmed'  => 'info',
                        'processing' => 'info',
                        'shipped'    => 'primary',
                        'delivered'  => 'success',
                        'cancelled'  => 'danger',
                        'refunded'   => 'gray',
                        default      => 'gray',
                    }),

                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid'     => 'success',
                        'pending'  => 'warning',
                        'failed'   => 'danger',
                        'refunded' => 'gray',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'confirmed'  => 'Confirmed',
                        'processing' => 'Processing',
                        'shipped'    => 'Shipped',
                        'delivered'  => 'Delivered',
                        'cancelled'  => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid'    => 'Paid',
                        'failed'  => 'Failed',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

