<?php

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('tags')->truncate();
        \Illuminate\Support\Facades\DB::table('translations')->truncate();
        \Illuminate\Support\Facades\DB::table('articles')->truncate();
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
        \Illuminate\Support\Facades\DB::table('article_category')->truncate();
        \Illuminate\Support\Facades\DB::table('tag_translation')->truncate();

        $articles = factory(\App\Blog\Article::class, 100)->create();
        $categories = factory(\App\Blog\Category::class, 4)->create();
        $tags = factory(\App\Blog\Tag::class, 30)->create();

        $articles->each(function($article) use ($categories, $tags) {
            if(rand(0,100) > 70) {
                $article->categories()->attach($categories[0]->id);
            }

            if(rand(0,100) > 70) {
                $article->categories()->attach($categories[1]->id);
            }

            if(rand(0,100) > 70) {
                $article->categories()->attach($categories[2]->id);
            }

            if(rand(0,100) > 70) {
                $article->categories()->attach($categories[3]->id);
            }

            if(rand(0,100) < 85) {
                $transA = factory(\App\Blog\Translation::class)->state('published')->create([
                    'language' => 'en',
                    'article_id' => $article->id
                ]);
                $transA->tags()->sync($tags->random(3)->pluck('id')->all());
            }

            if(rand(0,100) < 85) {
                $transB = factory(\App\Blog\Translation::class)->state('published')->create([
                    'language' => 'zh',
                    'article_id' => $article->id
                ]);
                $transB->tags()->sync($tags->random(3)->pluck('id')->all());
            }


        });
    }
}
