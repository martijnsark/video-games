<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Category;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // ✅ Make sure we have at least one user
        if (User::count() === 0) {
            User::factory()->create(); // or manually create one if you don’t use factories
        }

        // ✅ Make sure we have at least 1 category
        if (Category::count() === 0) {
            Category::factory()->count(5)->create(); // or manually insert 5 categories
        }

        $userIds = User::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        $soulGames = [
            'Dark Souls III',
            'Elden Ring',
            'Sekiro: Shadows Die Twice'
        ];

        $games = [];
        foreach ($soulGames as $title) {
            $games[] = [
                'user_id' => $faker->randomElement($userIds),
                'title' => $title,
                'image' => strtolower(str_replace([' ', ':'], '_', $title)) . '.jpg',
                'description' => $faker->paragraph(3),
                'category_id' => $faker->randomElement($categoryIds),
                'price' => $faker->numberBetween(40, 90),
                'discount' => $faker->numberBetween(0, 30),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('games')->insert($games);
    }
}
