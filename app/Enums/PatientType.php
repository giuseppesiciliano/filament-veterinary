<?php

namespace App\Enums;
 
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
 
enum PatientType: string implements HasLabel, HasColor, HasIcon
{
    case DOG = 'dog';
    case CAT = 'cat';
 
    public function getLabel(): ?string
    {
        return match ($this) {
            self::DOG => __('Dog'),
            self::CAT => __('Cat'),
        };
    }
 
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DOG => 'white',
            self::CAT => 'white',
        };
    }
 
    public function getIcon(): ?string
    {
        return match ($this) {
            self::DOG => 'fas-dog',
            self::CAT => 'fas-cat',
        };
    }
}