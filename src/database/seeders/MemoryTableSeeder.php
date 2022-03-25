<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Memory;

class MemoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Memory::truncate();  //一括削除

        Memory::factory()->count(100)->create();
    }
}
