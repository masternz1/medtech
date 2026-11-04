<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Quotations';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('RFQ Proposal Information')
                    ->schema([
                        Forms\Components\TextInput::make('quotation_number')
                            ->disabled()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'draft'        => 'Draft',
                                'submitted'    => 'Submitted (New)',
                                'under_review' => 'Under Review',
                                'quoted'       => 'Quoted (Priced)',
                                'accepted'     => 'Accepted by Client',
                                'rejected'     => 'Rejected',
                                'converted'    => 'Converted to Order',
                                'expired'      => 'Expired',
                            ])
                            ->default('submitted')
                            ->required(),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Quoted Subtotal')
                            ->numeric()
                            ->prefix('NGN')
                            ->nullable(),

                        Forms\Components\DatePicker::make('valid_until')
                            ->label('Proposal Valid Until')
                            ->nullable(),
                    ])->columns(4),

                Forms\Components\Section::make('Client & Facility Information')
                    ->schema([
                        Forms\Components\TextInput::make('organization_name')
                            ->label('Healthcare Facility')
                            ->required(),

                        Forms\Components\TextInput::make('contact_name')
                            ->label('Contact Person')
                            ->required(),

                        Forms\Components\TextInput::make('contact_email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('contact_phone')
                            ->required(),

                        Forms\Components\TextInput::make('country')
                            ->default('Nigeria')
                            ->required(),

                        Forms\Components\DateTimePicker::make('submitted_at')
                            ->disabled(),
                    ])->columns(3),

                Forms\Components\Section::make('Requested Equipment & Pricing Breakdown')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->label('Equipment Item')
                                    ->required()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->required(),

                                Forms\Components\TextInput::make('unit_price')
                                    ->numeric()
                                    ->prefix('NGN')
                                    ->label('Unit Price Quoted'),

                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->prefix('NGN')
                                    ->label('Subtotal'),

                                Forms\Components\TextInput::make('notes')
                                    ->label('Item Specs / Delivery Notes')
                                    ->columnSpanFull(),
                            ])
                            ->columns(5),
                    ]),

                Forms\Components\Section::make('Clinical Requirements & Biomedical Notes')
                    ->schema([
                        Forms\Components\Textarea::make('requirements')
                            ->label('Client Stated Requirements')
                            ->rows(3)
                            ->disabled(),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Internal Engineering Notes & Terms')
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quotation_number')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('organization_name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('contact_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted'    => 'warning',
                        'under_review' => 'info',
                        'quoted'       => 'primary',
                        'accepted'     => 'success',
                        'converted'    => 'success',
                        'rejected'     => 'danger',
                        default        => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subtotal')
                    ->money('NGN')
                    ->sortable()
                    ->placeholder('Pending Quote'),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted'    => 'Submitted',
                        'under_review' => 'Under Review',
                        'quoted'       => 'Quoted',
                        'accepted'     => 'Accepted',
                        'rejected'     => 'Rejected',
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
            'index' => Pages\ListQuotations::route('/'),
            'edit'  => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}

