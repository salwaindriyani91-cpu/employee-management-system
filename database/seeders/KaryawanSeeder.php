<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $departemenIds = Departemen::pluck('id')->toArray();

        $jabatanPerDepartemen = [
            'Staff', 'Senior Staff', 'Supervisor', 'Manajer', 'Asisten Manajer', 'Koordinator', 'Analis', 'Kepala Bagian',
        ];
        $statusOptions = ['Aktif', 'Aktif', 'Aktif', 'Aktif', 'Nonaktif', 'Cuti']; // weighted towards Aktif

        $used = [];
        $total = 200;

        for ($i = 1; $i <= $total; $i++) {
            $jenisKelamin = $faker->randomElement(['L', 'P']);
            $nama = $jenisKelamin === 'L' ? $faker->firstNameMale() . ' ' . $faker->lastName() : $faker->firstNameFemale() . ' ' . $faker->lastName();

            $email = Str::slug($nama, '.') . $i . '@hrms-demo.com';
            $nip = 'EMP' . str_pad($i, 5, '0', STR_PAD_LEFT);

            Karyawan::create([
                'nip' => $nip,
                'nama' => $nama,
                'departemen_id' => $faker->randomElement($departemenIds),
                'jabatan' => $faker->randomElement($jabatanPerDepartemen),
                'email' => $email,
                'no_telp' => $faker->numerify('08##########'),
                'alamat' => $faker->address(),
                'tanggal_lahir' => $faker->dateTimeBetween('-55 years', '-20 years')->format('Y-m-d'),
                'jenis_kelamin' => $jenisKelamin,
                'tanggal_masuk' => $faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
                'gaji' => $faker->numberBetween(45, 250) * 100000,
                'status' => $faker->randomElement($statusOptions),
            ]);
        }
    }
}
