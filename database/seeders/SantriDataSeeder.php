<?php

namespace Database\Seeders;

use App\Models\Santri;
use Illuminate\Database\Seeder;

class SantriDataSeeder extends Seeder
{
    /**
     * Seed data santri dari data tabel yang diberikan.
     */
    public function run(): void
    {
        $dataSantri = [
            ['nama' => 'Adam Alfarizi', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2016-09-16', 'alamat' => 'Tanah Datar', 'nama_wali' => 'Mulyadedi'],
            ['nama' => 'Adinda Putri Kaffa', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2014-08-01', 'alamat' => 'Tanah Datar', 'nama_wali' => 'Khairul Amri'],
            ['nama' => 'Muhammad Adrian', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2019-01-29', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Khairul Amri'],
            ['nama' => 'Aisha Alifa', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2020-01-01', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Aldo Pratama'],
            ['nama' => 'Aisha Farhana', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2018-01-13', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Rizal Boyce'],
            ['nama' => 'Akthar Qabeel Alfarezi Siregar', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2021-02-10', 'alamat' => 'Bukittinggi', 'nama_wali' => 'Sungaib Hanapi Siregar'],
            ['nama' => 'Arkan Efendi', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2015-07-01', 'alamat' => 'Tanah Datar', 'nama_wali' => 'Loger Efendi'],
            ['nama' => 'Azzam Alfatih', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2016-07-12', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Mulyadi'],
            ['nama' => 'Cantika Afnia Putri', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2016-05-21', 'alamat' => 'Tanah Datar', 'nama_wali' => 'Roni'],
            ['nama' => 'Dafi Arsil', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2012-12-24', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Doni'],
            ['nama' => 'Dani Rivaldi Harison', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2014-09-22', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Riko Harison'],
            ['nama' => 'Delaira Rosi Indrato', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2014-06-10', 'alamat' => 'Batam', 'nama_wali' => 'Robert Indrato'],
            ['nama' => 'Dina Andriana', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2017-02-22', 'alamat' => 'Bengkulu', 'nama_wali' => 'Arie Bambros'],
            ['nama' => 'Hilma Qoriah', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2016-11-14', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Lillah'],
            ['nama' => 'Iffatul Ulya Safitri', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2010-10-10', 'alamat' => 'Padang', 'nama_wali' => 'Arie Bambros'],
            ['nama' => 'Hammam Lutfan Haidar Siregar', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2019-04-27', 'alamat' => 'Bukittinggi', 'nama_wali' => 'Sungaib Hanapi Siregar'],
            ['nama' => 'Jefri Azka Sakya', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2016-05-27', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Syahrul Ramadhan'],
            ['nama' => 'Jihan Almeera Ani', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2019-08-14', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Abdul Gani'],
            ['nama' => 'Maulana Aziz', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2014-05-07', 'alamat' => 'Rokan Hulu', 'nama_wali' => 'Agusri'],
            ['nama' => 'Muhammad Nadhif', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2019-03-23', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Ahmad Efendi'],
            ['nama' => 'Muhammad Zafran', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2019-05-04', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Abdul Gafur'],
            ['nama' => 'Mutia Sari Dewi', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2017-09-21', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Debi Haldi'],
            ['nama' => 'Najwa Assifa Manalu', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2018-08-21', 'alamat' => 'Jakarta', 'nama_wali' => 'Andi Fernandes'],
            ['nama' => 'Nayla Azizah Manalu', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2019-12-05', 'alamat' => 'Jakarta', 'nama_wali' => 'Andi Fernandes'],
            ['nama' => 'Neysa Husna Dya', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2012-06-02', 'alamat' => 'Tanah Datar', 'nama_wali' => 'Roni'],
            ['nama' => 'Nur Aini', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2011-10-01', 'alamat' => 'Tanah Datar', 'nama_wali' => 'alm (Jupriadi)'],
            ['nama' => 'Rafasya Hidayat', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2019-08-30', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Doni'],
            ['nama' => 'Shafaina Marwah Indrato', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2019-06-20', 'alamat' => 'Batam', 'nama_wali' => 'Robert Indrato'],
            ['nama' => 'Sakira Putri', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2015-05-29', 'alamat' => 'Padang Panjang', 'nama_wali' => 'alm (khairunnas)'],
            ['nama' => 'Hanif Tristan Kashafa', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2019-10-30', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Nici Febrian'],
            ['nama' => 'Zafira Alesha Putri', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2016-08-24', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Zaharudin'],
            ['nama' => 'Nania Ramadhani', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2015-06-24', 'alamat' => 'Balai Gadang', 'nama_wali' => 'Dedi Elizar'],
            ['nama' => 'Arsen Arsenaf', 'jenis_kelamin' => 'L', 'tgl_lahir' => '2018-04-15', 'alamat' => 'Padang Panjang', 'nama_wali' => 'Man Buololo'],
            ['nama' => 'Aisyah Ayla Varisha', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2019-04-28', 'alamat' => 'Tanah Datar', 'nama_wali' => 'Roby Surya Anwar'],
            ['nama' => 'Ghibran Arfan Alhusyn', 'jenis_kelamin' => 'L', 'tgl_lahir' => null, 'alamat' => 'Tanah Datar', 'nama_wali' => 'Nofrizal'],
            ['nama' => 'Farzana', 'jenis_kelamin' => 'P', 'tgl_lahir' => null, 'alamat' => 'Balai Gadang', 'nama_wali' => 'Dedi Elizar'],
        ];

        foreach ($dataSantri as $data) {
            Santri::create(array_merge($data, [
                'no_hp_wali' => '-',
                'id_kelas' => 1,
                'status' => 'aktif',
            ]));
        }
    }
}
