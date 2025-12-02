<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'title' => 'Umroh Syawal Ceria 1446H',
            'slug' => 'umroh-syawal-ceria-1446h',
            'price_quad' => 29500000,
            'price_triple' => 31000000,
            'price_double' => 33000000,
            'departure_date' => '2025-04-05',
            'duration_days' => 9,
            'hotel_makkah' => 'Emaar Grand',
            'hotel_madinah' => 'Concorde Madinah',
            'airline_name' => 'Saudia Airlines',
            'featured_image' => 'https://i.pinimg.com/1200x/e3/b3/9b/e3b39b92746f66322e2c84ba8050581f.jpg',
            'description' => 'Paket umroh di bulan Syawal dengan fasilitas nyaman dan harga terjangkau.',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Package::create([
            'title' => 'Umroh Akhir Tahun Plus Turki',
            'slug' => 'umroh-akhir-tahun-plus-turki',
            'price_quad' => 42000000,
            'price_triple' => 45000000,
            'price_double' => 48000000,
            'departure_date' => '2025-12-15',
            'duration_days' => 12,
            'hotel_makkah' => 'Anjum Hotel',
            'hotel_madinah' => 'Ruve Al Madinah',
            'airline_name' => 'Turkish Airlines',
            'featured_image' => 'https://i.pinimg.com/736x/15/e0/29/15e029ad11b8348026739eebdf15595e.jpg',
            'description' => 'Menutup tahun dengan perjalanan ibadah ke tanah suci dilanjutkan dengan wisata halal di Turki.',
            'is_featured' => true,
            'is_active' => true,
        ]);
        Package::create([
            'title' => 'Umroh Plus West Eropa',
            'slug' => 'umroh-plus-west-eropa',
            'price_quad' => 40000000,
            'price_triple' => 60000000,
            'price_double' => 90000000,
            'departure_date' => '2025-12-12',
            'duration_days' => 12,
            'hotel_makkah' => 'Swissotel Makkah',
            'hotel_madinah' => 'Anwar Al Madinah Movenpick',
            'airline_name' => 'Garuda Indonesia',
            'featured_image' => 'https://i.pinimg.com/736x/b3/23/cf/b323cfaa6e6045bca19f4a7ebf561cd6.jpg',
            'description' => 'Umroh Plus West Eropa adalah perjalanan umroh yang dilengkapi wisata halal ke kota-kota indah di Eropa Barat.',
            'is_featured' => true,
            'is_active' => true,
        ]);
    }
}