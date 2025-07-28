<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactLocation;

class ContactLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactLocation::create([
            'name' => 'Main Office',
            'address' => 'Business Bay, Dubai',
            'city' => 'Dubai',
            'country' => 'UAE',
            'phone' => '+971 4 123 4567',
            'email' => 'info@tawasullimo.ae',
            'latitude' => 25.1972,
            'longitude' => 55.2744,
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3610.2449265945736!2d55.27153441501401!3d25.194676183895187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f43496ad9c645%3A0xbde66e1147b67d!2sDubai%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2s!4v1642684739123!5m2!1sen!2s',
            'is_active' => true,
            'order' => 1
        ]);

        ContactLocation::create([
            'name' => 'Abu Dhabi Branch',
            'address' => 'Corniche Road, Abu Dhabi',
            'city' => 'Abu Dhabi',
            'country' => 'UAE',
            'phone' => '+971 2 123 4567',
            'email' => 'abudhabi@tawasullimo.ae',
            'latitude' => 24.4539,
            'longitude' => 54.3773,
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3631.859087185058!2d54.37473431501279!3d24.45391598427134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e440f723ef2b9%3A0xc7cc2e9341971108!2sAbu%20Dhabi%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2s!4v1642684739123!5m2!1sen!2s',
            'is_active' => false,
            'order' => 2
        ]);
    }
}
