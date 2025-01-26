<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\DataProcessor;
use Database\Factories\CommentFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    private $data_pr;

    public function __construct()
    {
        $this->data_pr = new DataProcessor();

    }

    protected function get_user($name)
    {
        $user = User::where('name', $name)->first();

        if (!$user)
        {
            // Create a new user
            $user = new User();
            $user->name = $name;
            $name_parts = explode(' ',$name);
            $email = implode('_',$name_parts).'.gmail.com';
            $user->email = $email;
            $user->password = bcrypt('123456'); // Always hash passwords
            $user->remember_token =  Str::random(10);
            $user->save();
        }
        return ($user->id);
    }

    protected function get_blog($user_id,$subject,$desc,$image)
    {
        $blog = Blog::where('user_id', $user_id)->first();
        if (!$blog)
        {
           $blog = new Blog();
           $blog->user_id = $user_id;
           $blog->subject = $subject;
           $blog->description = $desc;
           if (!empty($image))
           {
                $blog->image =$image;
           }
           $blog->save();
        }
        return ($blog->id);
    }

    protected function get_tag($name)
    {
        $tag = Tag::where('name',$name)->first();
        if (!$tag)
        {
            $tag = new Tag();
            $tag->name = $name;
            $tag->save();
        }
        return($tag->id);
    }

    protected function create_article($blog_id,$category_id,$title,$body,$article_image)
    {
        $article = new Article();
        $article->blog_id = $blog_id;
        $article->category_id = $category_id;
        $article->title = $title;
        $article->body = $body;
        $article->image = $article_image;
        $article->save();
        return ($article->id);
    }

    public function create_comment($article_id,$owner_id)
    {
         // choose a user who is not the article writer ( to be the comment owner )
        $users_num = User::count();
        if ($users_num ===1)
        {
            $user_id = rand (2,5);
        }
        else
        {
            do
            {
                $user_id = rand(1,$users_num-1);
            } while($user_id === $owner_id);
        }

        $comment_ind = rand(0,39);
        $comment_text = CommentFactory::$comments[$comment_ind];

        $comment = new Comment();
        $comment->article_id = $article_id;
        $comment->user_id = $user_id;
        $comment->comment = $comment_text;
        $comment->save();
        return ($comment->id);
    }

    protected function api_feed()
    {
        $this->call(CategorySeeder::class);
        $categories = Category::all();
        foreach ($categories as $cat)
        {
           $cat_name = strtolower($cat->name);
           $cat_articles =  $this->data_pr->get_articles($cat_name);
           foreach ($cat_articles as $article)
           {
               $user_id = $this->get_user($article->author);
               //echo "user_id=".$user_id."\n";

               $image_name = $this->data_pr->get_unique_image_name($article->image_name);
               if (!empty($image_name))
               {
                    $saved_ok = $this->data_pr->saveImageFromUrl($article->urlToImage, "images/".$image_name);
                    if ($saved_ok)
                    {
                            $last_image = "images/".$image_name;
                    }
                    else
                    {
                        $last_image = null; //'https://picsum.photos/200/300';
                    }
               }
               else
               {
                   $last_image = null;
               }

               $blog_title = $article->author."'s Blog regarding ".$cat_name;
               $blog_id = $this->get_blog($user_id,$blog_title,$article->description,$last_image);
            //   echo "blog_id=".$blog_id."\n";
               $article_id = $this->create_article($blog_id,$cat->id,$article->title,$article->long_content,$last_image);
           //    echo "image_name: ".$article->image_name."\n";
           //    echo "article_id=".$article_id."\n\n";
               $keywords = $this->data_pr->getKeywords($article->title);
               foreach ($keywords as $keyword)
               {
                    $tag_id = $this->get_tag($keyword);
                    DB::table('article_tag')->insert(['article_id'=>$article_id, 'tag_id'=>$tag_id]);
               }
               for ($k=0; $k<3; $k++)
               {
                    $this->create_comment($article_id,$user_id);
               }
           }
        }
    }

    public function run(): void
    {
        $this->api_feed();


       /* $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ArticleTagSeeder::class);
        $this->call(CommentSeeder::class); */
    }




}
