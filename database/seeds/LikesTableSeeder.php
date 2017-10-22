<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \App\Interfaces\UserRepositoryInterface $userRepository
     * @param \App\Interfaces\PostRepositoryInterface $postRepository
     * @return void
     */
    public function run(\App\Interfaces\UserRepositoryInterface $userRepository, \App\Interfaces\PostRepositoryInterface $postRepository)
    {
        $usersIds = $userRepository->all()->pluck('id');
        $postsIds = $postRepository->all()->pluck('id');

        foreach ($postsIds as $postId){
            foreach ($usersIds as $usersId){
                if (rand(0, 1) == 1){
                    factory(\App\Models\Like::class)->create([
                        'post_id' => $postId,
                        'user_id' => $usersId,
                    ]);
                }
            }
        }
    }
}
