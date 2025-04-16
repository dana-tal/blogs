<?php
//test55
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Rules\commaSeparatedRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        $articles = $blog->articles()->with('category')->latest()->paginate(10);
       return view('articles.index',['articles'=>$articles,'blog'=>$blog]);
    }

    public function search()
    {
        $article_q = request('q');
        session(['article_q'=>$article_q]);
        $cat = request('cat');
        session(['cat'=>$cat]);

        $categories =  Category::all();

        if (empty($cat) && !empty($article_q)) // only q supplied
        {
            $articles =  Article::query()->with(['category','blog'])
            ->where('articles.title','LIKE','%'.$article_q.'%')
            ->orWhere('articles.body','LIKE','%'.$article_q.'%')
            ->orWhereHas('tags', function ($rel) use($article_q) {
                $rel->where('tags.name','LIKE','%'.$article_q.'%');
            })
            ->paginate(10);
        }
        else if (!empty($cat) && empty($article_q)) // only cat supplied
        {
            $articles = Article::query()->with('category','blog')
            ->where('category_id','=',$cat)->paginate(10);
        }
        else if (!empty($cat) && !empty($article_q)) // both category and q supplied
        {
            $articles = Article::query()->with('category','blog')
            ->where('category_id','=',$cat)
            ->where(function($query) use ($article_q)
                {
                    $query->where('title','LIKE','%'.$article_q.'%')->orWhere('body','LIKE','%'.$article_q.'%')
                    ->orWhereHas('tags',function ($rel) use($article_q) {
                        $rel->where('tags.name','LIKE','%'.$article_q.'%');
                    });
                })->paginate(10);
        }
        else // no q and no cat , get all articles
        {
           return redirect('/front/articles');
        }

        return view ('articles.show_articles',['articles'=>$articles,'categories'=>$categories]);
    }

    public function show_articles()
    {
        session(['article_q'=>'']);
        session(['cat'=>'']);

        $categories =  Category::all();
        $articles = Article::with('category','blog')->latest()->paginate(10);
        return view ('articles.show_articles',['articles'=>$articles,'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Blog $blog)
    {
        $categories = Category::all();
        return view('articles.create',['blog'=>$blog,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Blog $blog)
    {
        $attributes = $request->validate([
            'title'  => ['required'],
            'category_id'=>['required'],
            'keywords'=>['required',new commaSeparatedRule()],
            'body' =>['required'],
            'image' => ['image','max:2048','unique:articles,image',File::types(['png', 'jpg', 'jpeg','gif','webp'])]
        ]);

        if ($request->image)
        {
            $image_path = $request->image->store('images');
        }
        else
        {
            $image_path = null;
        }

      //  dd($image_path);

       $article = Article::create([
            'blog_id'=> $blog->id,
            'category_id'=>$attributes['category_id'],
            'title'=>$attributes['title'],
            'body'=>$attributes['body'],
            'image'=>$image_path
        ]);

        $added_keywords = $this->get_keywords($attributes['keywords']);
        $this-> add_new_keywords($added_keywords,$article);

        return redirect('/articles/'.$blog->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article,string $page_id,?string $parent='blogs')
    {
        $tags = $article->tags;
        $comments = $article->comments()->latest()->get();
        return view('articles.show',['article'=>$article,'tags'=>$tags, 'comments'=>$comments,'page_id'=>$page_id, 'parent'=>$parent]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $blog = $article->blog;
        $categories = Category::all();
        $tags = $article->tags;
        $tags_arr = array();
        foreach($tags as $tag)
        {
          $tags_arr[] = $tag->name;
        }
        $tags_list = implode(" , " ,$tags_arr);
        return view('articles.edit',['article'=>$article,'blog'=>$blog,'categories'=>$categories,'tags_list'=>$tags_list]);
    }


    protected function add_new_keywords($added_keywords,$article)
    {
        foreach($added_keywords as $new_keyword)
        {
            $found_tags = Tag::where('name','=',$new_keyword)->get();
            if (empty($found_tags[0])) // the keywords does not exist in the tags table
            {
                $tag = Tag::create(['name'=>$new_keyword]);
            }
            else
            {
                $tag = $found_tags[0];
            }
            $tag->articles()->attach($article->id);
        }
    }

    protected function get_keywords($keywords_str)
    {
        $list = explode(',',$keywords_str);
        foreach($list as $item)
        {
            $trimmed = trim($item);
            if (!empty($trimmed))
            {
                $keywords[]= $trimmed;
            }

        }
        return($keywords);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {

        $attributes = $request->validate([
            'title'  => ['required'],
            'category_id'=>['required'],
            'keywords'=>['required',new commaSeparatedRule()],
            'body' =>['required'],
            'image' => ['image','max:2048','unique:articles,image',File::types(['png', 'jpg', 'jpeg','gif','webp'])]
        ]);


        if ($request->image)
        {
            if ( $article->image)
            {
                Storage::delete($article->image);
            }
            $image_path = $request->image->store('images');
            $props = [
                'title' => $attributes['title'],
                'category_id'=>$attributes['category_id'],
                'body' => $attributes['body'],
                'image'=>$image_path
            ];
        }
        else
        {
            $image_path = null;
            $props = [
                'title' => $attributes['title'],
                'category_id'=>$attributes['category_id'],
                'body' => $attributes['body'],
            ];
        }
        $article->update($props);

        $tags = $article->tags;
        $old_keywords = array();
        $new_keywords = array();

        foreach($tags as $tag)
        {
          $old_keywords[] = $tag->name;
        }

        $new_keywords = $this->get_keywords($attributes['keywords']);

        $added_keywords = array_values(array_diff($new_keywords,$old_keywords));
        $removed_keywords = array_values(array_diff($old_keywords,$new_keywords));

       if (!empty($added_keywords))
        {
            $this->add_new_keywords($added_keywords,$article);
        }

        if (!empty($removed_keywords))
        {
            foreach($removed_keywords as $old_keyword)
            {
                $found_tags = Tag::where('name','=',$old_keyword)->get();
                if (!empty($found_tags[0]))
                {
                    $found_tags[0]->articles()->detach($article->id);
                }
            }
        }


        $blog_id = $article->blog->id;
        return redirect('/articles/'.$blog_id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Blog $blog)
    {

        if (is_array( $request->delete_articles) && !empty($request->delete_articles))
        {
            foreach( $request->delete_articles as $article_id)
            {
                Article::remove_article($article_id);
            }
           // Article::whereIn('id', $request->delete_articles)->delete();
        }
        return redirect('/articles/'.$blog->id);
    }
}
