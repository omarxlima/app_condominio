<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('units')->insert([
            'name' => 'APT 100',
            'id_owner' => 1
        ]);

        DB::table('units')->insert([
            'name' => 'APT 101',
            'id_owner' => 1
        ]);

        DB::table('units')->insert([
            'name' => 'APT 200',
            'id_owner' => '0'
        ]);

        DB::table('units')->insert([
            'name' => 'APT 201',
            'id_owner' => '0'
        ]);

        DB::table('areas')->insert([
            'allowed' => '1',
            'title' => 'Academia',
            'cover' => 'gym.jpg',
            'days' => '1,2,4,5',
            'start_time' => '06:00:00',
            'end_time' => '22:00:00',
        ]);

        DB::table('areas')->insert([
            'allowed' => '1',
            'title' => 'Piscina',
            'cover' => 'pool.jpg',
            'days' => '1,2,3,4,5',
            'start_time' => '07:00:00',
            'end_time' => '23:00:00',
        ]);

        DB::table('areas')->insert([
            'allowed' => '1',
            'title' => 'Churrasqueira',
            'cover' => 'barbecue.jpg',
            'days' => '4,5,6',
            'start_time' => '09:00:00',
            'end_time' => '23:00:00',
        ]);

        DB::table('walls')->insert([
            'title' => 'Titulo de aviso  de Teste',
            'body' => 'Lorem Ipsum sajfçlaslasçdfjasldkf teste',
            'datecreated' => '2020-12-20 15:00:00',
        ]);

        DB::table('walls')->insert([
            'title' => 'Alerta Geral para todos',
            'body' => 'Cuidado Danger Cuidado Danger',
            'datecreated' => '2020-12-20 18:00:00',
        ]);
    }
}
