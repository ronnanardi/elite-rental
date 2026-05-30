<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;


class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
        [
            'console_type' => 'PS3',
            'image'        => 'https://upload.wikimedia.org/wikipedia/commons/4/4e/PS4-Console-wDS4.png',
            'description'  => 'Gaming klasik yang tetap seru.',
            'total'        => 3,
            'is_open'      => true,
        ],
        [
            'console_type' => 'PS4',
            'image'        => 'https://upload.wikimedia.org/wikipedia/commons/4/4e/PS4-Console-wDS4.png',
            'description'  => 'Gaming stabil dan nyaman.',
            'total'        => 4,
            'is_open'      => true,
        ],
        [
            'console_type' => 'PS5',
            'image'        => 'https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_5_and_DualSense_with_transparent_background.png',
            'description'  => 'Performa tinggi dan grafis terbaik.',
            'total'        => 2,
            'is_open'      => true,
        ],
    ];

    foreach ($units as $unit) {
        Unit::create($unit);
    }
    }
}
