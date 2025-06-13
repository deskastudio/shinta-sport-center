<?php
namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Lapangan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBookings = Booking::count();
        $todayBookings = Booking::whereDate('tgl_main', today())->count();
        $pendingBookings = Booking::where('status_booking', 'pending')->count();
        $totalRevenue = Booking::whereIn('status_booking', ['disetujui', 'main_hari_ini'])->sum('total_harga');

        return [
            Stat::make('Total Booking', $totalBookings)
                ->description('Semua booking')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
            
            Stat::make('Booking Hari Ini', $todayBookings)
                ->description('Booking untuk hari ini')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
            
            Stat::make('Pending Booking', $pendingBookings)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari booking terkonfirmasi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}