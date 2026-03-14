<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users'),

            Stat::make('Users Today', User::whereDate('created_at', today())->count())
                ->description('New today'),

            Stat::make('Active Users', User::where('status', 1)->count())
                ->description('Currently active'),

            Stat::make('Revenue', '$10,000')
                ->description('Total income'),
        ];
    }
}
