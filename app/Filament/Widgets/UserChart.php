<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'User Register 7 Days';

    protected function getData(): array
    {
        $data = [
            User::whereDate('created_at', now()->subDays(6))->count(),
            User::whereDate('created_at', now()->subDays(5))->count(),
            User::whereDate('created_at', now()->subDays(4))->count(),
            User::whereDate('created_at', now()->subDays(3))->count(),
            User::whereDate('created_at', now()->subDays(2))->count(),
            User::whereDate('created_at', now()->subDays(1))->count(),
            User::whereDate('created_at', now())->count(),
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data,
                ],
            ],
            'labels' => [
                '6 days ago',
                '5 days ago',
                '4 days ago',
                '3 days ago',
                '2 days ago',
                'Yesterday',
                'Today',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
