<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Customer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('kd_customer')
                            ->label('Kode Customer')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->placeholder('CST001'),
                        
                        Forms\Components\TextInput::make('nm_customer')
                            ->label('Nama Customer')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Budi Santoso'),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->placeholder('budi@gmail.com'),
                        
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. HP')
                            ->required()
                            ->maxLength(15)
                            ->placeholder('08123456789'),
                        
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->placeholder('Jl. Merdeka No. 123...')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('username')
                            ->label('Username')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->placeholder('budi123'),
                        
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->placeholder('Password'),
                        
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'aktif' => 'Aktif',
                                'tidak_aktif' => 'Tidak Aktif'
                            ])
                            ->default('aktif'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kd_customer')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('nm_customer')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'danger' => 'tidak_aktif',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif'
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}