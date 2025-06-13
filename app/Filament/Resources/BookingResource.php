<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Lapangan;
use App\Models\SlotWaktu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Booking';
    protected static ?string $pluralLabel = 'Bookings';
    protected static ?string $slug = 'bookings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Customer')
                    ->schema([
                        Forms\Components\Select::make('kd_customer')
                            ->label('Customer')
                            ->options(Customer::where('status', 'aktif')->pluck('nm_customer', 'kd_customer'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih Customer')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('kd_customer')
                                    ->label('Kode Customer')
                                    ->required(),
                                Forms\Components\TextInput::make('nm_customer')
                                    ->label('Nama Customer')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('no_hp')
                                    ->label('No. HP')
                                    ->required(),
                                Forms\Components\Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->required(),
                                Forms\Components\TextInput::make('username')
                                    ->label('Username')
                                    ->required(),
                                Forms\Components\TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return Customer::create([
                                    'kd_customer' => $data['kd_customer'],
                                    'nm_customer' => $data['nm_customer'],
                                    'email' => $data['email'],
                                    'no_hp' => $data['no_hp'],
                                    'alamat' => $data['alamat'],
                                    'username' => $data['username'],
                                    'password' => bcrypt($data['password']),
                                    'status' => 'aktif',
                                ])->kd_customer;
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Detail Reservasi')
                    ->schema([
                        Forms\Components\Select::make('kd_lapangan')
                            ->label('Lapangan')
                            ->options(Lapangan::where('status', 'tersedia')->pluck('nm_lapangan', 'kd_lapangan'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih Lapangan')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $lapangan = Lapangan::find($state);
                                    if ($lapangan) {
                                        $set('total_harga', $lapangan->harga_per_jam);
                                    }
                                }
                            }),
                        
                        Forms\Components\Select::make('kd_slot')
                            ->label('Slot Waktu')
                            ->options(SlotWaktu::where('status', 'aktif')->pluck('display_waktu', 'kd_slot'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih Slot Waktu'),
                        
                        Forms\Components\DatePicker::make('tgl_booking')
                            ->label('Tanggal Booking')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y'),
                        
                        Forms\Components\DatePicker::make('tgl_main')
                            ->label('Tanggal Main')
                            ->required()
                            ->minDate(now())
                            ->displayFormat('d/m/Y'),
                        
                        Forms\Components\TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('45000'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status & Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('status_booking')
                            ->label('Status Booking')
                            ->options([
                                'pending' => 'Menunggu Verifikasi',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                'main_hari_ini' => 'Main Hari Ini'
                            ])
                            ->default('pending')
                            ->required(),
                        
                        Forms\Components\Select::make('metode_bayar')
                            ->label('Metode Bayar')
                            ->options([
                                'transfer_bank' => 'Transfer Bank',
                                'e_wallet' => 'E-Wallet',
                                'cash' => 'Cash'
                            ])
                            ->placeholder('Pilih Metode Bayar'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Bukti & Catatan')
                    ->schema([
                        Forms\Components\FileUpload::make('bukti_bayar')
                            ->label('Bukti Bayar')
                            ->image()
                            ->disk('public')
                            ->directory('bukti-bayar')
                            ->imagePreviewHeight('250')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('500')
                            ->imageResizeTargetHeight('500')
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Catatan tambahan...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('customer.nm_customer')
                    ->label('Customer')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('lapangan.nm_lapangan')
                    ->label('Lapangan')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('slotWaktu.display_waktu')
                    ->label('Slot Waktu')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('tgl_main')
                    ->label('Tanggal Main')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status_booking')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                        'info' => 'menunggu_pembayaran',
                        'primary' => 'main_hari_ini',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'pending' => 'Menunggu Verifikasi',
                            'disetujui' => 'Disetujui',
                            'ditolak' => 'Ditolak',
                            'menunggu_pembayaran' => 'Menunggu Pembayaran',
                            'main_hari_ini' => 'Main Hari Ini',
                            default => $state
                        };
                    }),
                
                    Tables\Columns\ImageColumn::make('bukti_bayar')
    ->label('Bukti Bayar')
    ->size(60)
    ->square()
    ->extraAttributes([
        'class' => 'cursor-pointer border rounded-lg shadow-sm hover:shadow-md transition-shadow'
    ])
    ->url(fn ($record) => $record->bukti_bayar ? asset('storage/' . $record->bukti_bayar) : null)
    ->openUrlInNewTab()
    ->tooltip('Klik untuk melihat gambar penuh'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status_booking')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'main_hari_ini' => 'Main Hari Ini'
                    ])
                    ->multiple(),
                
                SelectFilter::make('kd_lapangan')
                    ->label('Lapangan')
                    ->options(Lapangan::pluck('nm_lapangan', 'kd_lapangan'))
                    ->multiple(),
                
                Tables\Filters\Filter::make('tgl_main')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($query, $date) => $query->whereDate('tgl_main', '>=', $date))
                            ->when($data['sampai_tanggal'], fn ($query, $date) => $query->whereDate('tgl_main', '<=', $date));
                    }),

                Tables\Filters\Filter::make('today')
                    ->label('Main Hari Ini')
                    ->query(fn ($query) => $query->whereDate('tgl_main', today())),

                Tables\Filters\Filter::make('this_week')
                    ->label('Minggu Ini')
                    ->query(fn ($query) => $query->whereBetween('tgl_main', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ])),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                
                // Action Approve
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->size('sm')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Booking')
                    ->modalDescription(fn (Booking $record) => "Apakah Anda yakin ingin menyetujui booking {$record->customer->nm_customer} untuk {$record->lapangan->nm_lapangan}?")
                    ->modalSubmitActionLabel('Ya, Approve')
                    ->action(function (Booking $record) {
                        $record->update(['status_booking' => 'disetujui']);
                        
                        Notification::make()
                            ->title('Booking Berhasil Diapprove')
                            ->body("Booking #{$record->id} telah disetujui")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Booking $record) => $record->status_booking === 'pending'),
                
                // Action Reject
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->size('sm')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Booking')
                    ->modalDescription(fn (Booking $record) => "Apakah Anda yakin ingin menolak booking {$record->customer->nm_customer}?")
                    ->modalSubmitActionLabel('Ya, Reject')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Masukkan alasan penolakan...')
                            ->rows(3)
                    ])
                    ->action(function (Booking $record, array $data) {
                        $record->update([
                            'status_booking' => 'ditolak',
                            'catatan' => ($record->catatan ? $record->catatan . "\n\n" : '') . 'Ditolak: ' . $data['reason']
                        ]);
                        
                        Notification::make()
                            ->title('Booking Berhasil Ditolak')
                            ->body("Booking #{$record->id} telah ditolak")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Booking $record) => $record->status_booking === 'pending'),
                
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Bulk Approve
                    Tables\Actions\BulkAction::make('bulk_approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Multiple Bookings')
                        ->modalDescription('Apakah Anda yakin ingin menyetujui semua booking yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Approve Semua')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status_booking === 'pending') {
                                    $record->update(['status_booking' => 'disetujui']);
                                    $count++;
                                }
                            }
                            
                            Notification::make()
                                ->title('Bulk Approve Berhasil')
                                ->body("$count booking berhasil diapprove")
                                ->success()
                                ->send();
                        }),
                    
                    // Bulk Reject
                    Tables\Actions\BulkAction::make('bulk_reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Reject Multiple Bookings')
                        ->modalDescription('Apakah Anda yakin ingin menolak semua booking yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Reject Semua')
                        ->form([
                            Forms\Components\Textarea::make('reason')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->placeholder('Masukkan alasan penolakan untuk semua booking...')
                                ->rows(3)
                        ])
                        ->action(function ($records, array $data) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status_booking === 'pending') {
                                    $record->update([
                                        'status_booking' => 'ditolak',
                                        'catatan' => ($record->catatan ? $record->catatan . "\n\n" : '') . 'Ditolak: ' . $data['reason']
                                    ]);
                                    $count++;
                                }
                            }
                            
                            Notification::make()
                                ->title('Bulk Reject Berhasil')
                                ->body("$count booking berhasil ditolak")
                                ->success()
                                ->send();
                        }),
                    
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto refresh every 30 seconds
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_booking', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendingCount = static::getModel()::where('status_booking', 'pending')->count();
        
        if ($pendingCount > 5) {
            return 'danger';
        } elseif ($pendingCount > 0) {
            return 'warning';
        }
        
        return 'success';
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['customer', 'lapangan', 'slotWaktu']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['customer.nm_customer', 'customer.email', 'lapangan.nm_lapangan', 'id'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Customer' => $record->customer->nm_customer,
            'Lapangan' => $record->lapangan->nm_lapangan,
            'Tanggal' => $record->tgl_main->format('d/m/Y'),
            'Status' => $record->status_booking,
        ];
    }
}