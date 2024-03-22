<?php

namespace App\Enums;
 
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
 
enum PatientSex: string implements HasLabel, HasColor
{
    case M = 'M';
    case F = 'F';
 
    public function getLabel(): ?string
    {
        return match ($this) {
            self::M => 'M',
            self::F => 'F',
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::M => 'blue',
            self::F => 'pink',
        };
    }
 
    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::IN_STOCK => 'heroicon-m-pencil',
    //         self::SOLD_OUT => 'heroicon-m-eye',
    //         self::COMING_SOON => 'heroicon-m-check',
    //     };
    // }
}