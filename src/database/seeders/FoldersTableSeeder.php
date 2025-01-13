<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = ['プライベート', '仕事', '旅行'];
        foreach ($titles as $title) {
            Folder::factory()->withTitle($title)->create();
        }
    }
}