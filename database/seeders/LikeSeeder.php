<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maxTries = 300; // 尝试生成的最大数量
        $tries = 0;

        while ($tries < $maxTries) {
            $userId = User::inRandomOrder()->first()->id;
            $ideaId = Idea::inRandomOrder()->first()->id;

            $exists = DB::table('likes')
                ->where('idea_id', $ideaId)
                ->where('user_id', $userId)
                ->exists();
            // make sure it's unique
            if (!$exists) {
                Like::create([
                    'user_id' => $userId,
                    'idea_id' => $ideaId,
                    'like_type' => ['like', 'dislike'][rand(0, 1)],
                ]);

                $tries++;
            }
        }
    }
}
