<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
        ['key' => 'rental_name',     'value' => 'Elite Rental PS'],
        ['key' => 'bank_name',       'value' => 'BCA'],
        ['key' => 'account_number',  'value' => '1234567890'],
        ['key' => 'account_name',    'value' => 'Elite Rental'],
        ['key' => 'whatsapp',        'value' => '08123456789'],
        ['key' => 'qris_image',      'value' => null],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
