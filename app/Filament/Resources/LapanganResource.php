<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LapanganResource\Pages;
use App\Models\Lapangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LapanganResource extends Resource
{
    protected static ?string $model = Lapangan::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Lapangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('kd_lapangan')
                            ->label('Kode Lapangan')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->placeholder('LP001'),
                        
                        Forms\Components\TextInput::make('nm_lapangan')
                            ->label('Nama Lapangan')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Lapangan Badminton 1'),
                        
                        Forms\Components\Select::make('jenis_lapangan')
                            ->label('Jenis Lapangan')
                            ->options([
                                'Indoor' => 'Indoor',
                                'Outdoor' => 'Outdoor',
                                'Semi Indoor' => 'Semi Indoor'
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('harga_per_jam')
                            ->label('Harga per Jam')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('45000'),
                        
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'tersedia' => 'Tersedia',
                                'maintenance' => 'Maintenance',
                                'tidak_aktif' => 'Tidak Aktif'
                            ])
                            ->default('tersedia'),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Deskripsi lapangan...')
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Lapangan')
                            ->image()
                            ->directory('lapangan')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kd_lapangan')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('nm_lapangan')
                    ->label('Nama Lapangan')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('jenis_lapangan')
                    ->label('Jenis')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('harga_per_jam')
                    ->label('Harga/Jam')
                    ->money('IDR')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'tersedia',
                        'warning' => 'maintenance',
                        'danger' => 'tidak_aktif',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'maintenance' => 'Maintenance',
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
            'index' => Pages\ListLapangans::route('/'),
            'create' => Pages\CreateLapangan::route('/create'),
            'edit' => Pages\EditLapangan::route('/{record}/edit'),
        ];
    }
}