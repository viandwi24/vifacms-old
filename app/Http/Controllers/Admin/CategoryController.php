<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\DataTables\DataTables;
use App\Models\category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax())
        {
            return DataTables::of(category::select('id', 'name')->get())
                ->addColumn('no', function(){
                    static $no = 1;
                    return $no++;
                })
                ->addColumn('action', function($category){
                    $aksi = "editNow('".$category->id."' ,'".$category->name."');";
                    return '
                        <button class="btn btn-warning btn-xs" onclick="'.$aksi.'">
                            <i class="fa fa-pencil"></i>
                        </button>

                        <form style="display:inline;" method="POST" action="'.route('admin.post.category.destroy', ['id' => $category->id]).'">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    ';
                })
                ->make();
        }

        return view('admin.post.category');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new category();
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.post.category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $category = category::find($request->input('id'));
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.post.category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        category::where('id', $id)->delete();
        return redirect()->route('admin.post.category');
    }
}
