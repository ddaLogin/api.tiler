<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \App\Interfaces\UserRepositoryInterface $userRepository
     * @param \App\Interfaces\CategoryRepositoryInterface $categoryRepository
     * @return void
     */
    public function run(\App\Interfaces\UserRepositoryInterface $userRepository, \App\Interfaces\CategoryRepositoryInterface $categoryRepository)
    {
        $categories = $categoryRepository->getAll();
        if(!$categories){
            $categories = factory(\App\Models\Category::class, 3);
        }
        foreach ($userRepository->all() as $user){
            factory(\App\Models\Post::class, 3)->create(['user_id' => $user->id])->each(function ($post) use($categories, $user) {

                //prepare categories
                $categoriesForPost = [];
                foreach ($categories as $category){
                    $rand = rand(0,10);
                    if($rand >= 5){
                        $categoriesForPost[] = $category->id;
                    }
                }
                $post->categories()->attach($categoriesForPost);

                //prepare collections
                $collections = factory(\App\Models\Collection::class, rand(0, 3))->create(['user_id' => $user->id]);
                $post->collections()->attach($collections->pluck('id'));
            });;
        }
    }
}
