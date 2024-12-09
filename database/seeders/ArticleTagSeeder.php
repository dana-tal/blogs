<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($article_id=1; $article_id<=500; $article_id++)
        {
            $tags_num =0;
            $tags = array();
            while ($tags_num < 10)
            {
                $tag_id = rand(1,50);
                if ( !in_array($tag_id,$tags))
                {
                    $tags[] = $tag_id;
                    $tags_num++;
                }
            }
            foreach($tags as $tag_id)
            {
                DB::table('article_tag')->insert(['article_id'=>$article_id, 'tag_id'=>$tag_id]);
            }
        }
    }

}
