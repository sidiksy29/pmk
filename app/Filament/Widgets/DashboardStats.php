<?php

namespace App\Filament\Widgets;

use App\Models\DataKaryawan;
use App\Models\PMK;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Total Karyawan', DataKaryawan::count())
                ->description('Data Karyawan')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Card::make('Total PMK', PMK::count())
                ->description('Data PMK')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Card::make('Total User', User::count())
                ->description('Data User')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
        ];
    }
}
