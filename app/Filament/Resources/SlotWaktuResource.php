<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SlotWaktuResource\Pages;
use App\Models\SlotWaktu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SlotWaktuResource extends Resource
{
    protected static ?string $model = SlotWaktu::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Slot Waktu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('kd_slot')
                            ->label('Kode Slot')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->placeholder('S01'),
                        
                        Forms\Components\TimePicker::make('jam_mulai')
                            ->label('Jam Mulai')
                            ->required()
                            ->seconds(false),
                        
                        Forms\Components\TimePicker::make('jam_selesai')
                            ->label('Jam Selesai')
                            ->required()
                            ->seconds(false),
                        
                        Forms\Components\TextInput::make('display_waktu')
                            ->label('Display Waktu')
                            ->required()
                            ->placeholder('10:00 - 11:00'),
                        
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
                Tables\Columns\TextColumn::make('kd_slot')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('display_waktu')
                    ->label('Waktu')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('jam_mulai')
                    ->label('Mulai')
                    ->time('H:i'),
                
                Tables\Columns\TextColumn::make('jam_selesai')
                    ->label('Selesai')
                    ->time('H:i'),
                
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
            ])
            ->defaultSort('jam_mulai', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlotWaktus::route('/'),
            'create' => Pages\CreateSlotWaktu::route('/create'),
            'edit' => Pages\EditSlotWaktu::route('/{record}/edit'),
        ];
    }
}