<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //外部キーを設定しているテーブルのseederを呼ぶときは、そのキーの設定元のテーブルのseederを先に書く必要がある
        $this->call('MemoryTableSeeder::class');
    }
}
