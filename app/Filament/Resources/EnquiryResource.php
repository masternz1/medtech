<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnquiryResource\Pages;
use App\Models\Enquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EnquiryResource extends Resource
{
    protected static ?string $model = Enquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Customers';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Enquiry Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->disabled()
                            ->required(),

                        Forms\Components\TextInput::make('phone')
                            ->disabled(),

                        Forms\Components\TextInput::make('organization')
                            ->disabled(),

                        Forms\Components\TextInput::make('subject')
                            ->disabled()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('message')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'new'         => 'New',
                                'read'        => 'Read',
                                'in_progress' => 'In Progress',
                                'replied'     => 'Replied',
                                'closed'      => 'Closed',
                            ])
                            ->default('new')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('organization')
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'         => 'danger',
                        'read'        => 'warning',
                        'in_progress' => 'info',
                        'replied'     => 'success',
                        'closed'      => 'gray',
                        default       => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => 'New',
                        'read'        => 'Read',
                        'in_progress' => 'In Progress',
                        'replied'     => 'Replied',
                        'closed'      => 'Closed',
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
            'index' => Pages\ListEnquiries::route('/'),
            'edit'  => Pages\EditEnquiry::route('/{record}/edit'),
        ];
    }
}

