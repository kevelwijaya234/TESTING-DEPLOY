<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::insert([

            [
                'name' => 'Dashboard',
                'slug' => 'dashboard'
            ],

            [
                'name' => 'Buku',
                'slug' => 'books'
            ],

            [
                'name' => 'Kategori',
                'slug' => 'categories'
            ],

            [
                'name' => 'Peminjaman',
                'slug' => 'loans'
            ],

            [
                'name' => 'Pengembalian',
                'slug' => 'returns'
            ],

            [
                'name' => 'Reservasi',
                'slug' => 'reservations'
            ],

            [
                'name' => 'Laporan',
                'slug' => 'reports'
            ],

            [
                'name' => 'User',
                'slug' => 'users'
            ],

        ]);
    }
}
