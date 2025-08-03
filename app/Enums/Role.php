<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'Admin';
    case PETANI = 'Petani';
    case AHLIPERTANIAN = 'Ahli Pertanian';
    case KEPALADINAS = 'Kepala Dinas';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::ADMIN => 'primary',
            self::PETANI => 'success',
            self::AHLIPERTANIAN => 'danger',
            self::KEPALADINAS => 'warning',
            default => 'default'
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
