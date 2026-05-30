<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\PriceSlot;

class PriceSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
        'PS3' => [
            'hour'   => [1=>3000, 2=>5500, 3=>8000, 4=>10000, 5=>12000],
            'minute' => [10=>500, 20=>900, 30=>1200, 40=>1500, 50=>1700],
        ],
        'PS4' => [
            'hour'   => [1=>5000, 2=>9000, 3=>13000, 4=>16000, 5=>19000],
            'minute' => [10=>800, 20=>1400, 30=>1900, 40=>2300, 50=>2600],
        ],
        'PS5' => [
            'hour'   => [1=>8000, 2=>14000, 3=>20000, 4=>25000, 5=>29000],
            'minute' => [10=>1500, 20=>2500, 30=>3500, 40=>4500, 50=>5000],
        ],
    ];

        foreach ($data as $type => $slots) {
            $unit = Unit::where('console_type', $type)->first();

            foreach ($slots['hour'] as $value => $price) {
                PriceSlot::create([
                    'unit_id' => $unit->id,
                    'type'    => 'hour',
                    'value'   => $value,
                    'price'   => $price,
                ]);
            }

            foreach ($slots['minute'] as $value => $price) {
                PriceSlot::create([
                    'unit_id' => $unit->id,
                    'type'    => 'minute',
                    'value'   => $value,
                    'price'   => $price,
                ]);
            }
        }
    }
}
