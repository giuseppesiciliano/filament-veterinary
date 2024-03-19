<?php

namespace App\Filament\Resources\DoctorResource\Pages;

use App\Filament\Resources\DoctorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;


class ViewDoctor extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns([
                        'sm' => 2,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('role'),
                        TextEntry::make('email'),
                        TextEntry::make('phone'),
                    ]),

                Tabs::make('Tabs')
                    ->columnSpan('full')
                    ->tabs([
                        Tabs\Tab::make('Treatments')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('treatments')
                                    ->columns(12)
                                    ->schema([
                                        TextEntry::make('description')
                                        ->columnSpan([
                                            'default' => 12,
                                            'lg' => 6
                                        ]),
                                        TextEntry::make('patient.name')
                                        ->columnSpan([
                                            'default' => 12,
                                            'lg' => 3
                                        ]),
                                        TextEntry::make('created_at')
                                            ->date("d/m/Y H:i")
                                            ->columnSpan([
                                                'default' => 12,
                                                'lg' => 3
                                            ]),
                                        Section::make('Notes')
                                            ->schema([
                                                TextEntry::make('notes')
                                                    ->hiddenLabel(),
                                            ])->columnSpanFull()->collapsed()
                                    ]),
                            ]),
                        Tabs\Tab::make('Tasks')
                            ->icon('heroicon-o-calendar-days')
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('tasks')
                                    ->columns([
                                        'sm' => 4,
                                        'xl' => 4,
                                        '2xl' => 4,
                                    ])
                                    ->schema([
                                        TextEntry::make('name'),
                                        TextEntry::make('patient.name'),
                                        TextEntry::make('start')
                                            ->date("d/m/Y H:i"),
                                        TextEntry::make('end')
                                            ->date("d/m/Y H:i"),
                                    ]),
                            ]),
                        Tabs\Tab::make('Tab 3')
                            ->schema([
                                // ...
                            ]),
                    ])

            ]);
    }
}