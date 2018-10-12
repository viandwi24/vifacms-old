<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\theme;

use App\Helpers\vcms;

class ThemeController extends Controller
{
    protected $theme_page = ['theme_home', 'theme_post', 'theme_search', 'theme_404'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_theme      = theme::select('id', 'name')->get();
        $active_theme   = vcms::setting()->get('theme');
        $theme          = theme::find($active_theme);

        return view('admin.theme.index', compact('all_theme', 'theme'));
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
        //
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
        $theme = theme::findOrFail($id);
        $page = 'theme_' . $_GET['page'];
        $name = strtoupper($_GET['page']);

        if (!in_array($page, $this->theme_page)) abort(404);
        $theme = $theme->{$page};
        return view('admin.theme.edit', compact('theme', 'page', 'id', 'name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (isset($_GET['a']))
        {
            switch ($_GET['a']) {
                case 'change_theme':
                    vcms::setting()->set('theme', $request->input('theme'));
                    return redirect()->route('admin.theme.index');
                    break;
                case 'edit_theme':
                    $theme = theme::findOrFail($request->input('id'));
                    $page = $request->input('page');

                    if (!in_array($page, $this->theme_page)) abort(404);
                    $theme->{$page} = $request->input('theme');
                    $theme->save();

                    $page = str_replace('theme_', '', $page);
                    return redirect()->route('admin.theme.edit', ['id' => $theme, 'page' => $page]);
                    break;

                default:
                    abort(404);
                    break;
            }
        } else { abort(404); }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
