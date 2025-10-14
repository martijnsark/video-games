<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $titles = [
            'The Legend of Zelda', 'Super Mario Odyssey', 'Minecraft',
            'Fortnite', 'Call of Duty', 'FIFA 23', 'Cyberpunk 2077',
            'Elden Ring', 'God of War', 'Among Us', 'Halo Infinite',
            'Animal Crossing', 'Overwatch', 'Genshin Impact', 'Resident Evil Village',
            'Horizon Forbidden West', 'Final Fantasy XIV', 'Assassin’s Creed Valhalla',
            'Mario Kart 8', 'Stardew Valley', 'League of Legends', 'Valorant',
            'The Witcher 3', 'Grand Theft Auto V', 'Minecraft Dungeons', 'Pokemon Sword',
            'Pokemon Shield', 'Splatoon 3', 'Dragon Age Inquisition', 'Dark Souls III',
            'Monster Hunter Rise', 'Fall Guys', 'Doom Eternal', 'Terraria', 'Rocket League',
            'Among Us', 'Dead by Daylight', 'Star Wars Jedi', 'CyberConnect2 Ninja',
            'Little Nightmares', 'F1 2023', 'Forza Horizon 5', 'Ghost of Tsushima',
            'Sekiro', 'Cuphead', 'Ori and the Will of the Wisps', 'It Takes Two', 'Control'
        ];


        $categories = [1, 2, 3, 4, 5]; // Adjust based on your category table

        $games = [];
        for ($i = 1; $i <= 10; $i++) { // generate 50 rows
            $title = $faker->unique()->randomElement($titles);
            $games[] = [
                'user_id' => $faker->numberBetween(1, 10),
                'title' => $title,
                'image' => strtolower(str_replace(' ', '_', $title)) . '.jpg',
                'description' => $faker->paragraph(2),
                'category_id' => $faker->randomElement($categories),
                'price' => $faker->numberBetween(20, 100),
                'discount' => $faker->numberBetween(0, 50),
            ];
        }

        DB::table('games')->insert($games);
    }
}
