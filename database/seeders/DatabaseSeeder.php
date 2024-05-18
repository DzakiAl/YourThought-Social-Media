<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Dzaki Al',
            'email' => 'dzakial@example.com',
            'password' => 'dzakial123.'
        ]);

        User::factory()->create([
            'name' => 'Caelus',
            'email' => 'caelus@example.com',
            'password' => 'caelus123.'
        ]);

        User::factory()->create([
            'name' => 'March 7th',
            'email' => 'march7th@example.com',
            'password' => 'march7th123.'
        ]);

        User::factory()->create([
            'name' => 'Dan Heng',
            'email' => 'danheng@example.com',
            'password' => 'danheng123.'
        ]);

        User::factory()->create([
            'name' => 'Himeko',
            'email' => 'himeko@example.com',
            'password' => 'himeko123.'
        ]);

        User::factory()->create([
            'name' => 'Welt Yang',
            'email' => 'weltyang@example.com',
            'password' => 'weltyang123.'
        ]);

        User::factory()->create([
            'name' => 'Pom-Pom',
            'email' => 'pompom@example.com',
            'password' => 'pompom123.'
        ]);

        User::factory()->create([
            'name' => 'Kafka',
            'email' => 'kafka@example.com',
            'password' => 'kafka123.'
        ]);

        User::factory()->create([
            'name' => 'Blade',
            'email' => 'blade@example.com',
            'password' => 'blade123.'
        ]);

        User::factory()->create([
            'name' => 'Silver Wolf',
            'email' => 'silverwolf@example.com',
            'password' => 'silverwolf123.'
        ]);

        User::factory()->create([
            'name' => 'Aventurine',
            'email' => 'aventurine@example.com',
            'password' => 'aventurine123.'
        ]);

        User::factory()->create([
            'name' => 'Dr. Ratio',
            'email' => 'veritasratio@example.com',
            'password' => '123.'
        ]);

        User::factory()->create([
            'name' => 'Robin',
            'email' => 'robin@example.com',
            'password' => 'robin123.'
        ]);

        User::factory()->create([
            'name' => 'Sunday',
            'email' => 'sunday@example.com',
            'password' => 'sunday123.'
        ]);

        User::factory()->create([
            'name' => 'Sampo Koski',
            'email' => 'koski@example.com',
            'password' => 'koski123.'
        ]);

        User::factory()->create([
            'name' => 'Sparkle',
            'email' => 'sparkle@example.com',
            'password' => 'sparkle123.'
        ]);

        User::factory()->create([
            'name' => 'Boothil',
            'email' => 'boothil@example.com',
            'password' => 'boothil123.'
        ]);

        User::factory()->create([
            'name' => 'Gepard Landau',
            'email' => 'gepardlandau@example.com',
            'password' => 'landau123.'
        ]);

        User::factory()->create([
            'name' => 'Serval Landau',
            'email' => 'servallandau@example.com',
            'password' => 'serval123.'
        ]);

        User::factory()->create([
            'name' => 'Herta',
            'email' => 'herta@example.com',
            'password' => 'herta123.'
        ]);

        User::factory()->create([
            'name' => 'Ruan Mei',
            'email' => 'ruanmei@example.com',
            'password' => 'ruan123.'
        ]);

        User::factory()->create([
            'name' => 'Topaz',
            'email' => 'topaz@example.com',
            'password' => 'topaz123.'
        ]);

        User::factory()->create([
            'name' => 'Jing Yuan',
            'email' => 'jingyuan@example.com',
            'password' => 'jingyuan23.'
        ]);
    }
}
