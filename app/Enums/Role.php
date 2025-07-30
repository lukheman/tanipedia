<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case PETANI = 'petani';
    case AHLIPERTANIAN = 'ahli_pertanian';
    case KEPALADINAS = 'kepala_dinas';

    public static function values(): array {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
