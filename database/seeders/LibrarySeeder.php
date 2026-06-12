<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // ==================================
        // RESET DATA
        // ==================================

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('reservations')->truncate();
        DB::table('loans')->truncate();
        DB::table('digital_books')->truncate();
        DB::table('members')->truncate();
        DB::table('books')->truncate();
        DB::table('categories')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ==================================
        // CATEGORIES
        // ==================================

        $categories = [
            'Novel',
            'Sastra',
            'Teknologi',
            'Pendidikan',
            'Sejarah'
        ];

        foreach ($categories as $category) {

            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==================================
        // BOOKS
        // ==================================

        for ($i = 1; $i <= 200; $i++) {

            DB::table('books')->insert([

                'category_id' => rand(1, 5),

                'title' => 'Buku Perpustakaan ' . $i,

                'author' => 'Penulis ' . $i,

                'publisher' => 'Penerbit ' . $i,

                'year' => rand(2000, 2026),

                'isbn' =>
                '978602' .
                    str_pad($i, 7, '0', STR_PAD_LEFT),

                'kode_buku' =>
                'BK' .
                    str_pad($i, 4, '0', STR_PAD_LEFT),

                'stock' => rand(1, 15),

                'description' =>
                'Deskripsi singkat buku perpustakaan nomor ' . $i,

                'created_at' => now(),

                'updated_at' => now(),
            ]);
        }

        // ==================================
        // ADMIN
        // ==================================

        DB::table('members')->insert([

            'role_id' => 1,

            'member_code' => 'ADM001',

            'name' => 'Administrator',

            'email' => 'admin@smpd.com',

            'password' => Hash::make('admin123'),

            'phone' => '081111111111',

            'address' => 'Kantor SMPD',

            'status' => 'Aktif',

            'created_at' => now(),

            'updated_at' => now(),
        ]);

        // ==================================
        // PUSTAKAWAN
        // ==================================

        DB::table('members')->insert([

            'role_id' => 2,

            'member_code' => 'PST001',

            'name' => 'Pustakawan',

            'email' => 'pustakawan@smpd.com',

            'password' => Hash::make('pustakawan123'),

            'phone' => '082222222222',

            'address' => 'Perpustakaan SMPD',

            'status' => 'Aktif',

            'created_at' => now(),

            'updated_at' => now(),
        ]);

        // ==================================
        // MEMBERS
        // ==================================

        for ($i = 1; $i <= 50; $i++) {

            DB::table('members')->insert([

                'role_id' => 3,

                'member_code' =>
                'MBR' .
                    str_pad($i, 4, '0', STR_PAD_LEFT),

                'name' => 'Anggota ' . $i,

                'email' => 'anggota' . $i . '@email.com',

                'password' => Hash::make('password123'),

                'phone' =>
                '08' .
                    rand(1000000000, 9999999999),

                'address' =>
                'Alamat anggota ' . $i,

                'status' => 'Aktif',

                'created_at' => now(),

                'updated_at' => now(),
            ]);
        }

        // ==================================
        // DIGITAL BOOKS
        // ==================================

        for ($i = 1; $i <= 10; $i++) {

            DB::table('digital_books')->insert([

                'category_id' => rand(1, 5),

                'title' => 'Digital Book ' . $i,

                'author' => 'Author Digital ' . $i,

                'publisher' => 'Penerbit Digital ' . $i,

                'year' => rand(2020, 2026),

                'isbn' =>
                '978602' .
                    str_pad($i, 7, '0', STR_PAD_LEFT),

                'kode_buku' =>
                'EBK' .
                    str_pad($i, 4, '0', STR_PAD_LEFT),

                'description' =>
                'Deskripsi ebook nomor ' . $i,

                'file' =>
                'digital-book-' . $i . '.pdf',

                'access' =>
                'Anggota',

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==================================
        // LOANS
        // ==================================

        for ($i = 1; $i <= 150; $i++) {

            $loanDate = now()->subDays(rand(1, 365));

            $dueDate = (clone $loanDate)->addDays(7);

            $status = collect([
                'Dipinjam',
                'Dipinjam',
                'Dipinjam',
                'Dikembalikan',
                'Dikembalikan',
                'Terlambat'
            ])->random();

            DB::table('loans')->insert([

                'loan_code' =>
                'LON' .
                    str_pad($i, 5, '0', STR_PAD_LEFT),

                'member_id' => rand(3, 52),

                'book_id' => rand(1, 200),

                'loan_date' => $loanDate,

                'due_date' => $dueDate,

                'status' => $status,

                'created_at' => now(),

                'updated_at' => now(),
            ]);
        }

        // ==================================
        // RESERVATIONS
        // ==================================

        for ($i = 1; $i <= 100; $i++) {

            $reservationDate =
                now()->subDays(rand(1, 365));

            $status = collect([
                'Disetujui',
                'Disetujui',
                'Disetujui',
                'Disetujui',
                'Menunggu',
                'Menunggu',
                'Dibatalkan'
            ])->random();

            DB::table('reservations')->insert([

                'reservation_code' =>
                'RES' .
                    str_pad($i, 5, '0', STR_PAD_LEFT),

                'member_id' => rand(3, 52),

                'book_id' => rand(1, 200),

                'reservation_date' =>
                $reservationDate,

                'status' => $status,

                'created_at' => now(),

                'updated_at' => now(),
            ]);
        }

        $loans = DB::table('loans')->get();

        foreach ($loans->take(100) as $index => $loan) {

            // Tanggal pengembalian bisa lebih cepat,
            // tepat waktu, atau terlambat

            $returnDate = \Carbon\Carbon::parse($loan->due_date)
                ->addDays(rand(-5, 10));

            // Hitung keterlambatan

            $lateDays = max(
                0,
                \Carbon\Carbon::parse($loan->due_date)
                    ->diffInDays($returnDate, false)
            );

            DB::table('return_books')->insert([

                'return_code' =>
                'RTN' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),

                'loan_id' => $loan->id,

                'return_date' => $returnDate,

                'late_days' => $lateDays,

                'fine_amount' => $lateDays * 5000,

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            // Update status loan menjadi dikembalikan

            DB::table('loans')
                ->where('id', $loan->id)
                ->update([
                    'status' => 'Dikembalikan'
                ]);
        }
    }
}
