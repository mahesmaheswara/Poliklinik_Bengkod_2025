<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

// Import Models
use App\Models\User;
use App\Models\Poli;
use App\Models\Obat;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use App\Models\DetailPeriksa;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Pakai locale Indonesia biar namanya relevan

        // =================================================================
        // 1. MASTER DATA: POLI (4 Poli Dasar)
        // =================================================================
        $poliNames = ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Kandungan'];
        foreach ($poliNames as $name) {
            Poli::create([
                'nama_poli' => $name,
                'keterangan' => 'Pelayanan ' . $name . ' Terpadu'
            ]);
        }
        $this->command->info('✅ 4 Poli Berhasil Dibuat');

// =================================================================
        // 2. MASTER DATA: OBAT (500 Data Realistis)
        // =================================================================
        $obatPrefixes = ['Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Metformin', 'Omeprazole', 'Cefadroxil', 'Antangin', 'Panadol', 'Bodrex', 'Mixagrip', 'Vitamin C', 'Amlodipine'];
        $obatTypes = ['Tablet', 'Sirup', 'Kapsul', 'Salep', 'Injeksi', 'Botol'];
        
        for ($i = 0; $i < 500; $i++) {
            $namaObat = $faker->randomElement($obatPrefixes) . ' ' . $faker->randomElement(['500mg', '250mg', '100ml', 'Generik', 'Forte', 'Plus']);
            
            // --- LOGIKA STOK REALISTIS (GACHA) ---
            $gacha = rand(1, 100);
            
            if ($gacha <= 10) { 
                // 10% Kemungkinan HABIS (Stok 0) -> Badge Merah
                $stok = 0; 
            } elseif ($gacha <= 30) { 
                // 20% Kemungkinan MENIPIS (Stok 1 - 5) -> Badge Merah/Kuning
                $stok = rand(1, 5); 
            } else { 
                // 70% Kemungkinan AMAN (Stok 50 - 200) -> Badge Hijau
                $stok = rand(50, 200); 
            }

            Obat::create([
                'nama_obat' => $namaObat . ' - ' . $faker->numerify('Batch ###'),
                'kemasan' => $faker->randomElement($obatTypes) . ' @' . $faker->numberBetween(10, 100) . 'pcs',
                'harga' => $faker->numberBetween(5, 500) * 1000, 
                'stok' => $stok, 
            ]);
        }
        $this->command->info('✅ 500 Obat Berhasil Dibuat (Variasi Stok: Habis, Menipis, Aman)');


        // =================================================================
        // 3. USER: ADMIN
        // =================================================================
        User::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'), // Password: admin
            'role' => 'admin',
            'alamat' => 'Jakarta',
            'no_hp' => '081234567890',
        ]);
        $this->command->info('✅ Admin Berhasil Dibuat');


        // =================================================================
        // 4. USER: DOKTER (25 Orang)
        // =================================================================
        
        // --- DOKTER UTAMA (DEMO) ---
        $dokterDemo = User::create([
            'nama' => 'dr. Bimo Junior',
            'email' => 'bimo@gmail.com', // LOGIN PAKE INI
            'password' => Hash::make('dokter'), // Password: dokter
            'role' => 'dokter',
            'alamat' => 'Jl. Kebenaran No. 1',
            'no_hp' => '081299999999',
            'id_poli' => 1, // Masuk Poli Umum
            'no_ktp' => '3201000000000001'
        ]);

        // Buatkan Jadwal untuk dr. Bimo (Senin - Jumat)
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($days as $day) {
            JadwalPeriksa::create([
                'id_dokter' => $dokterDemo->id,
                'hari' => $day,
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '15:00:00',
                'status' => 'aktif'
            ]);
        }

        // --- 24 DOKTER LAINNYA ---
        for ($i = 1; $i <= 24; $i++) {
            $namaDokter = 'dr. ' . $faker->firstName . ' ' . $faker->lastName;
            $emailDokter = strtolower(explode(' ', $namaDokter)[1]) . $faker->numberBetween(1, 99) . '@gmail.com';
            
            $dokter = User::create([
                'nama' => $namaDokter,
                'email' => $emailDokter,
                'password' => Hash::make('dokter'), // Password: dokter
                'role' => 'dokter',
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'id_poli' => $faker->numberBetween(1, 4), // Random Poli
                'no_ktp' => $faker->nik()
            ]);

            // Buat 1 Jadwal Random untuk setiap dokter ini biar "hidup"
            JadwalPeriksa::create([
                'id_dokter' => $dokter->id,
                'hari' => $faker->randomElement($days),
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'aktif'
            ]);
        }
        $this->command->info('✅ 25 Dokter & Jadwal Berhasil Dibuat');


        // =================================================================
        // 5. USER: PASIEN (300 Orang)
        // =================================================================
        for ($i = 1; $i <= 300; $i++) {
            // Format RM: 202601-XXX
            $no_rm = Carbon::now()->format('Ym') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            User::create([
                'nama' => 'Pasien ' . $i . ' (' . $faker->firstName . ')',
                'email' => "pasien{$i}@gmail.com", // pasien1@gmail.com s/d pasien300@gmail.com
                'password' => Hash::make('pasien'), // Password: pasien
                'role' => 'pasien',
                'alamat' => $faker->address,
                'no_hp' => $faker->phoneNumber,
                'no_ktp' => $faker->nik(),
                'no_rm' => $no_rm
            ]);
        }
        $this->command->info('✅ 300 Pasien Berhasil Dibuat');


        // =================================================================
        // 6. TRANSAKSI: RIWAYAT KUNJUNGAN (400 Data)
        // =================================================================
        // Kita sebar datanya dalam 1 tahun terakhir biar grafik bagus
        
        $allJadwals = JadwalPeriksa::pluck('id')->toArray();
        $allObats = Obat::pluck('id')->toArray();
        
        // Ambil ID Pasien (Hanya yang role pasien)
        // Note: ID pasien di User table mungkin mulai dari 27 ke atas (setelah admin & dokter)
        $allPasienIds = User::where('role', 'pasien')->pluck('id')->toArray();

        for ($j = 0; $j < 400; $j++) {
            
            // Random Tanggal (Mundur max 365 hari ke belakang)
            $tglDaftar = Carbon::now()->subDays(rand(0, 365));
            $tglPeriksa = $tglDaftar->copy()->addHours(rand(1, 5)); // Periksa beberapa jam setelah daftar

            // 1. DAFTAR POLI
            $daftarPoli = DaftarPoli::create([
                'id_pasien' => $faker->randomElement($allPasienIds),
                'id_jadwal' => $faker->randomElement($allJadwals),
                'keluhan' => $faker->sentence(3),
                'no_antrian' => $faker->numberBetween(1, 20),
                'status_periksa' => 'selesai', // Status SELESAI biar jadi riwayat
                'created_at' => $tglDaftar,
                'updated_at' => $tglPeriksa,
            ]);

            // 2. PERIKSA (Hasil Dokter)
            $biayaPeriksa = 150000;
            $periksa = Periksa::create([
                'id_daftar_poli' => $daftarPoli->id,
                'tgl_periksa' => $tglPeriksa,
                'catatan' => 'Diagnosa: ' . $faker->sentence(4) . '. Istirahat cukup.',
                'biaya_periksa' => $biayaPeriksa,
            ]);

            // 3. DETAIL PERIKSA (Obat) - Random 1 s/d 3 obat per pasien
            $jumlahObat = rand(1, 3);
            $totalBiayaObat = 0;

            for ($k = 0; $k < $jumlahObat; $k++) {
                $obatId = $faker->randomElement($allObats);
                $obat = Obat::find($obatId);
                
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId
                ]);
                $totalBiayaObat += $obat->harga;
            }

            // Update Total Biaya di tabel Periksa
            $periksa->update([
                'biaya_periksa' => $biayaPeriksa + $totalBiayaObat
            ]);
        }
        $this->command->info('✅ 400 Riwayat Medis (Backdated) Berhasil Dibuat');
    }
}