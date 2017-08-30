<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \App\Interfaces\UserRepositoryInterface $userRepository
     * @return void
     */
    public function run(\App\Interfaces\UserRepositoryInterface $userRepository)
    {
        foreach ($userRepository->all() as $user){
            factory(\App\Models\Post::class, 3)->create(['user_id' => $user->id]);
        }
    }
}
