<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\DataTables\DataTables;

use App\Models\post;

use App\Helpers\vcms;

class PostPublishedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($_GET['a']))
        {
            switch ($_GET['a']) {
                case 'draft':
                    if (!isset($_GET['id'])) return redirect()->route('admin.post.published');
                    $post = post::find($_GET['id']);
                    $post->draft = true;
                    $post->save();
                    return redirect()->route('admin.post.published');
                    break;
                
                default:
                    return redirect()->route('admin.post.published');
                    break;
            }
        }

    	if ($request->ajax())
    	{
            $data_post = \App\Models\post::select('id', 'category', 'title', 'created_at', 'url');

            $filter_category = "";
            if ($request->has('category')) {
                $filter_category = '"'.$request->input('category').'"';
                if ($request->input('category') == '0') $filter_category = '';
            }

            $filter_author = Auth()->user()->id;
            if ($request->has('author')) {
                if ($request->input('author') == '1') $filter_author = '';
            }

    		return DataTables::of($data_post
                ->where('draft', false)
                ->where('author', 'like','%'.$filter_author.'%')
                ->where('category', 'like', '%'.$filter_category.'%')
                ->orderBy('created_at', 'DESC')
                ->get())
                ->addColumn('no', function(){
                    static $no = 1;
                    return $no++;
                })
                ->addColumn('title', function($post){
                    $max = 50;

                    if (strlen($post->title) > $max) return substr($post->title, 0, $max) . '...';
                    return $post->title;
                })
                ->addColumn('category', function($post){
                    $cat = [];

                    foreach (json_decode($post->category) as $category_id) {
                        $cat[] = \App\Models\category::find($category_id)->name;
                    }

                    $cat = implode(', ', $cat);
                    $max = 10;
                    if (strlen($cat) > $max) return substr($cat, 0, $max) . '...';

                    return $cat;
                })
    			->addColumn('action', function($post){
                    $urlnya = vcms::get_post_url($post->url);
    				return '
    					<a href="'.route('admin.post.edit', ['id' => $post->id]).'" class="btn btn-xs btn-warning">
    						<i class="fa fa-pencil"></i>
    					</a>
    					<a target="_blank" href="'.$urlnya.'" class="btn btn-xs btn-primary">
    						<i class="fa fa-eye"></i>
    					</a>
                        <form style="display:inline;" method="POST" action="'.route('admin.post.destroy', ['id' => $post->id]).'">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

					 	<a title="Pindah Ke Draf" href="'.url()->current().'?a=draft&id='.$post->id.'" class="btn btn-xs btn-success">
					 		<i class="fa fa-pencil-square"></i> 
					 	</a>
    				';
    			})->make(true);
    	}

        $all_category = \App\Models\category::select('name', 'id')->get();

    	return view('admin.post.published', compact('all_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_category = \App\Models\category::select('name', 'id')->get();
        $page = 'create';

        return view('admin.post.create', compact('all_category', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (null == $request->input('category'))
        {
            $category = json_encode(array());
        } else
        {
            $category = json_encode($request->input('category'));
        }
        
        $save_type = false;
        if ($request->input('save_type') == 'draft') $save_type = true;

        $post = new post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->article = $request->input('article');
        $post->category = $category;
        $post->author = Auth()->user()->id;
        $post->cover = '';
        $post->url = $this->safe_url($post->title);
        $post->draft = $save_type;

        $post->save();

        if ($save_type) return redirect()->route('admin.post.draft');
        return redirect()->route('admin.post.published');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = post::findOrFail($id);
        $all_category = \App\Models\category::select('name', 'id')->get();
        $page = 'edit';

        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'draft') $page = 'draft';
        }

        return view('admin.post.create', compact('all_category', 'page', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (null == $request->input('category'))
        {
            $category = json_encode(array());
        } else
        {
            $category = json_encode($request->input('category'));
        }
        
        $save_type = false;
        if ($request->input('save_type') == 'draft') $save_type = true;


        $post = post::find($id);
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->article = $request->input('article');
        $post->category = $category;
        $post->cover = '';
        $post->url = $this->safe_url($post->title);
        $post->draft = $save_type;

        $post->save();

        if ($save_type) return redirect()->route('admin.post.draft');
        return redirect()->route('admin.post.published');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        post::where('id', $id)->delete();

        if (@$_GET['page'] == 'draft') return redirect()->route('admin.post.draft');
        return redirect()->route('admin.post.published');
    }

    private function safe_url($title)
    {
        $safe_url = [
            ' ' => '-',     '?' => '',      ',' => '-',     '#' => '',
            '!' => '',      '@' => '',      '$' => '',      '%' => '',
            '^' => '',      '&' => '',      '*' => '',      '(' => '',
            ')' => '',      '+' => '',      '=' => '',      '{' => '',
            '}' => '',      '[' => '',      ']' => '',      '\\' => '',
            '|' => '',      '"' => '',      "'" => '',      ':' => '',
            ';' => '',      '/' => '',      '.' => '',      '>' => '',
            '<' => '',      '~' => '',      '`' => '',
        ];

        $title = strtolower($title);
        $title = str_replace(array_keys($safe_url), array_values($safe_url), $title);
        return $title;
    }

    public function draft(Request $request)
    {
        if (isset($_GET['a']))
        {
            switch ($_GET['a']) {
                case 'publish':
                    if (!isset($_GET['id'])) return redirect()->route('admin.post.draft');
                    $post = post::find($_GET['id']);
                    $post->draft = false;
                    $post->save();
                    return redirect()->route('admin.post.draft');
                    break;
                
                default:
                    return redirect()->route('admin.post.draft');
                    break;
            }
        }

        if ($request->ajax())
        {
            return DataTables::of(\App\Models\post::select('id', 'category', 'title')
                ->where('draft', true)
                ->orderBy('created_at', 'DESC')
                ->get())
                ->addColumn('no', function(){
                    static $no = 1;
                    return $no++;
                })
                ->addColumn('title', function($post){
                    $max = 50;

                    if (strlen($post->title) > $max) return substr($post->title, 0, $max) . '...';
                    return $post->title;
                })
                ->addColumn('category', function($post){
                    $cat = [];

                    foreach (json_decode($post->category) as $category_id) {
                        $cat[] = \App\Models\category::find($category_id)->name;
                    }

                    $cat = implode(', ', $cat);
                    $max = 10;
                    if (strlen($cat) > $max) return substr($cat, 0, $max) . '...';

                    return $cat;
                })
                ->addColumn('action', function($post){
                    return '
                        <a href="'.route('admin.post.edit', ['id' => $post->id, 'page' => 'draft']).'" class="btn btn-xs btn-warning">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <form style="display:inline;" method="POST" action="'.route('admin.post.destroy', ['id' => $post->id, 'page' => 'draft']).'">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                        <a title="Publish Sekarang" href="'.url()->current().'?a=publish&id='.$post->id.'" class="btn btn-xs btn-success">
                            <i class="fa fa-sticky-note"></i> 
                        </a>
                    ';
                })->make(true);
        }
        return view("admin.post.draft");
    }
}
