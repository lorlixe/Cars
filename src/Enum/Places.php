<?php

namespace App\Enum;

enum Places: string
{
    case one = 'Un';
    case two = 'Deux';
    case three = 'Trois';
    case four = 'Quatre';
    case five = 'Cinq';
    case six = 'Six';
    case seven = 'Sept';
    case eight = 'Huit';
    case nine = 'Neuf';

    public function getLabel(): string
    {
        return match ($this) {
            self::one => '1',
            self::two => '2',
            self::three => '3',
            self::four => '4',
            self::five => '5',
            self::six => '6',
            self::seven => '7',
            self::eight => '8',
            self::nine => '9',
        };
    }
}
