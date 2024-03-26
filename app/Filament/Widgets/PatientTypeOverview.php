<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Patient;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Dogs', Patient::query()->where('type', 'dog')->count()),
            Stat::make('Cats', Patient::query()->where('type', 'cat')->count()),
        ];
    }
}