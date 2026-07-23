<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengajar;
use App\Models\Kelas;
use App\Models\Santri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed users (Admin & Guru)
        $this->call(UserSeeder::class);

        // 2. Seed Pengajar (Teacher)
        $pengajar = Pengajar::create([
            'nama' => 'Ustadz H. Ahmad Ridwan, Lc.',
            'no_hp' => '081234567890',
            'alamat' => 'Batipuah Ateh',
        ]);

        // 3. Seed Kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'Tingkat 1',
            'id_pengajar' => $pengajar->id_pengajar,
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'Tingkat 2',
            'id_pengajar' => $pengajar->id_pengajar,
        ]);

        // 4. Seed Santri for Tingkat 1
        $santriTingkat1 = [
            ['nama' => 'Ahmad Faisal', 'jenis_kelamin' => 'L', 'nama_wali' => 'Budi Faisal', 'no_hp_wali' => '081211111111', 'status' => 'aktif'],
            ['nama' => 'Siti Aisyah', 'jenis_kelamin' => 'P', 'nama_wali' => 'Hasan Aisyah', 'no_hp_wali' => '081222222222', 'status' => 'aktif'],
            ['nama' => 'Muhammad Rizky', 'jenis_kelamin' => 'L', 'nama_wali' => 'Ridwan Rizky', 'no_hp_wali' => '081233333333', 'status' => 'aktif'],
            ['nama' => 'Fatimah Zahra', 'jenis_kelamin' => 'P', 'nama_wali' => 'Lukman Zahra', 'no_hp_wali' => '081244444444', 'status' => 'mutasi'],
            ['nama' => 'Ali Imran', 'jenis_kelamin' => 'L', 'nama_wali' => 'Hamzah Imran', 'no_hp_wali' => '081255555555', 'status' => 'aktif'],
            ['nama' => 'Zidan Ramadhan', 'jenis_kelamin' => 'L', 'nama_wali' => 'Syarif Ramadhan', 'no_hp_wali' => '081255551111', 'status' => 'non-aktif'],
            ['nama' => 'Aulia Putri', 'jenis_kelamin' => 'P', 'nama_wali' => 'Rahmat Putri', 'no_hp_wali' => '081255552222', 'status' => 'aktif'],
        ];

        foreach ($santriTingkat1 as $data) {
            Santri::create(array_merge($data, [
                'id_kelas' => $kelas1->id_kelas,
                'alamat' => 'Batipuah Ateh',
                'tgl_lahir' => '2016-05-10',
            ]));
        }

        // 5. Seed Santri for Tingkat 2
        $santriTingkat2 = [
            ['nama' => 'Yusuf Ibrahim', 'jenis_kelamin' => 'L', 'nama_wali' => 'Ismail Ibrahim', 'no_hp_wali' => '081266666666', 'status' => 'aktif'],
            ['nama' => 'Ayla Kayla', 'jenis_kelamin' => 'P', 'nama_wali' => 'Farhan Kayla', 'no_hp_wali' => '081277777777', 'status' => 'mutasi'],
            ['nama' => 'Hasan Basri', 'jenis_kelamin' => 'L', 'nama_wali' => 'Basri Hasan', 'no_hp_wali' => '081288888888', 'status' => 'aktif'],
            ['nama' => 'Khadijah Humaira', 'jenis_kelamin' => 'P', 'nama_wali' => 'Husein Humaira', 'no_hp_wali' => '081299999999', 'status' => 'aktif'],
            ['nama' => 'Zaid Haritsah', 'jenis_kelamin' => 'L', 'nama_wali' => 'Haritsah Zaid', 'no_hp_wali' => '081200000000', 'status' => 'lulus'],
            ['nama' => 'Umar bin Khattab', 'jenis_kelamin' => 'L', 'nama_wali' => 'Khattab Umar', 'no_hp_wali' => '081299991111', 'status' => 'aktif'],
            ['nama' => 'Aisyah Humaira', 'jenis_kelamin' => 'P', 'nama_wali' => 'Sufyan Humaira', 'no_hp_wali' => '081299992222', 'status' => 'aktif'],
        ];

        foreach ($santriTingkat2 as $data) {
            Santri::create(array_merge($data, [
                'id_kelas' => $kelas2->id_kelas,
                'alamat' => 'Batipuah Ateh',
                'tgl_lahir' => '2015-08-15',
            ]));
        }
    }
}
