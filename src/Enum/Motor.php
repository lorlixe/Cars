<?php

namespace App\Enum;

enum Motor: string
{
    case manual = 'Manuelle';
    case auto = 'Automatique';

    public function getLabel(): string
    {
        return match ($this) {
            self::manual => 'Manuelle',
            self::auto => 'Automatique',
        };
    }
}
