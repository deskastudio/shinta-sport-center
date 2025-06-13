<?php
namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
{
    return [
        Actions\EditAction::make(),
        
        // Quick Approve Action
        Actions\Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Approve Booking')
            ->modalDescription('Apakah Anda yakin ingin menyetujui booking ini?')
            ->action(function () {
                $this->record->update(['status_booking' => 'disetujui']);
                
                \Filament\Notifications\Notification::make()
                    ->title('Booking Berhasil Diapprove')
                    ->success()
                    ->send();
                    
                return redirect()->to(static::getResource()::getUrl('index'));
            })
            ->visible(fn () => $this->record->status_booking === 'pending'),
        
        // Quick Reject Action
        Actions\Action::make('reject')
            ->label('Reject')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->requiresConfirmation()
            ->form([
                \Filament\Forms\Components\Textarea::make('reason')
                    ->label('Alasan Penolakan')
                    ->required()
                    ->placeholder('Masukkan alasan penolakan...')
            ])
            ->action(function (array $data) {
                $this->record->update([
                    'status_booking' => 'ditolak',
                    'catatan' => ($this->record->catatan ? $this->record->catatan . "\n\n" : '') . 'Ditolak: ' . $data['reason']
                ]);
                
                \Filament\Notifications\Notification::make()
                    ->title('Booking Berhasil Ditolak')
                    ->success()
                    ->send();
                    
                return redirect()->to(static::getResource()::getUrl('index'));
            })
            ->visible(fn () => $this->record->status_booking === 'pending'),
    ];
}

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Booking')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('ID Booking'),
                        
                        Infolists\Components\TextEntry::make('customer.nm_customer')
                            ->label('Nama Customer'),
                        
                        Infolists\Components\TextEntry::make('customer.email')
                            ->label('Email Customer'),
                        
                        Infolists\Components\TextEntry::make('customer.no_hp')
                            ->label('No. HP Customer'),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Detail Reservasi')
                    ->schema([
                        Infolists\Components\TextEntry::make('lapangan.nm_lapangan')
                            ->label('Lapangan'),
                        
                        Infolists\Components\TextEntry::make('lapangan.jenis_lapangan')
                            ->label('Jenis Lapangan'),
                        
                        Infolists\Components\TextEntry::make('slotWaktu.display_waktu')
                            ->label('Slot Waktu'),
                        
                        Infolists\Components\TextEntry::make('tgl_main')
                            ->label('Tanggal Main')
                            ->date('d/m/Y'),
                        
                        Infolists\Components\TextEntry::make('total_harga')
                            ->label('Total Harga')
                            ->money('IDR'),
                        
                        Infolists\Components\TextEntry::make('status_booking')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'menunggu_pembayaran' => 'info',
                                'main_hari_ini' => 'primary',
                            })
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
                    ])
                    ->columns(2),
                
                    Infolists\Components\Section::make('Pembayaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('metode_bayar')
                            ->label('Metode Bayar')
                            ->formatStateUsing(function ($state) {
                                return match($state) {
                                    'transfer_bank' => 'Transfer Bank',
                                    'e_wallet' => 'E-Wallet',
                                    'cash' => 'Cash',
                                    default => $state
                                };
                            }),
                        
                        Infolists\Components\ImageEntry::make('bukti_bayar')
                            ->label('Bukti Bayar')
                            ->disk('public')
                            ->height(300)
                            ->width(300)
                            ->defaultImageUrl(asset('images/no-image.svg'))
                            ->extraAttributes(['class' => 'border rounded-lg shadow-lg'])
                            ->visible(fn ($record) => $record->bukti_bayar !== null),
                
                        // Tampilkan pesan jika tidak ada bukti bayar
                        Infolists\Components\TextEntry::make('no_bukti_bayar')
                            ->label('Bukti Bayar')
                            ->state('Belum ada bukti bayar')
                            ->color('danger')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->visible(fn ($record) => $record->bukti_bayar === null),
                        
                        Infolists\Components\TextEntry::make('catatan')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record->catatan !== null),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Informasi Sistem')
                    ->schema([
                        Infolists\Components\TextEntry::make('tgl_booking')
                            ->label('Tanggal Booking')
                            ->date('d/m/Y'),
                        
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d/m/Y H:i:s'),
                        
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Diupdate Pada')
                            ->dateTime('d/m/Y H:i:s'),
                    ])
                    ->columns(3),
            ]);
    }
}