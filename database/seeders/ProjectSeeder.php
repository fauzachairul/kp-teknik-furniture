<?php

namespace Database\Seeders;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyekList = [
            [
                'project_kode' => 'PRJ-0825-001',
                'name' => 'Lemari Custom Pelanggan A',
                'customer_name' => 'Andi Wijaya',
                'tanggal_mulai' => Carbon::parse('2025-07-01'),
                'tanggal_selesai' => Carbon::parse('2025-07-20'),
                'status' => 'selesai',
            ],
            [
                'project_kode' => 'PRJ-0825-002',
                'name' => 'Meja TV Custom Pelanggan B',
                'customer_name' => 'Sinta Rahma',
                'tanggal_mulai' => Carbon::parse('2025-08-01'),
                'tanggal_selesai' => null,
                'status' => 'on progress',
            ],
            [
                'project_kode' => 'PRJ-0825-003',
                'name' => 'Kitchen Set Pelanggan C',
                'customer_name' => 'Budi Santoso',
                'tanggal_mulai' => Carbon::parse('2025-07-15'),
                'tanggal_selesai' => null,
                'status' => 'on progress',
            ],
        ];

        foreach ($proyekList as $proyek) {
            Project::create($proyek);
        }
    }
}
