<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\theme;
use App\Models\post;
use App\Models\category;

use App\Helpers\vcms;

class TemplateController extends Controller
{
	public function index($page = 1)
	{
		if ($page == 0) return redirect()->route('page', ['page' => 1]);

		#~ Get Theme
		$home_theme = theme::find(vcms::setting()->get('theme'))->theme_home;


		#~ Default Config :
		$config = [
			'max-symbol' => '...',
			'title-max' => 50,
			'post-glue' => '',
			'category-null' => 'No Category.',
			'post-null' => 'No Post.',
			'pagination-limit' => 3,
			'force-full-pagination' => 0,
		];

		$config 	= $this->render_config($home_theme, $config)[1];

		$home_theme = $this->render_config($home_theme, $config)[0];
		$home_theme = $this->render_app_info($home_theme);
		$home_theme = $this->render_post_looping($home_theme, $config, $page);
		$home_theme = $this->render_system_pagination($home_theme, $config, $page);
		return $home_theme;
	}

	public function post_model1($post){
		$model = json_decode(\App\Helpers\vcms::setting()->get('post_url'))->model;
		if ($model != 1) abort(404);

		$post = \App\Models\post::where('url', $post);
		if ($post->count() == 0) abort(404);

		return $this->show_post($post);
	}

	public function post_model2($segment_1 ,$post){
		$model = json_decode(\App\Helpers\vcms::setting()->get('post_url'));
		$post = \App\Models\post::where('url', $post);

		if ($model->model != 2) abort(404);
		if ($model->segment[0] != $segment_1) abort(404);
		if ($post->count() == 0) abort(404);

		return $this->show_post($post);
	}

	public function show_post($post)
	{
		## SET DEFAULT CONFIG
		$config = [
			'category-null' => 'No Category.',
		];

		# GET THEME
		$post_theme = theme::find(vcms::setting()->get('theme'))->theme_post;

		# GET CONFIG CUSTOM
		$config 	= $this->render_config($post_theme, $config)[1];
		$post_theme = $this->render_config($post_theme, $config)[0];
		
		# RENDER
		$post_theme = $this->render_app_info($post_theme);
		$post_theme = $this->render_post_info($post_theme, $config, $post->first());

		# SHOW RENDERED
		return $post_theme;
	}


	##########################################################################################################

	public function render_post_info($post_theme, $config, $post)
	{
		$mySyntax = [
			'[:post.title:]' => $post->title,
			'[:post.article:]' => $post->article,
		];
		## Replace A Category
		preg_match_all("/\[\:post.category\|(.*?)\|(.*?):]/", $post_theme, $opt);
		foreach ($opt[1] as $opt_key => $opt_value) {
			$category_html = $opt_value;
			$opt_html = [];
			$category_all = json_decode($post->category);
			foreach ($category_all as $category) {
				$tmp_opt = $category_html;
				$tmp_opt = str_replace('[:post.category.text:]', category::find($category)->name, $tmp_opt);
				$opt_html[] = $tmp_opt;
			}

			if (count($category_all) == 0) $opt_html[] = $config['category-null'];
			$post_theme = str_replace($opt[0][$opt_key], implode($opt[2][$opt_key], $opt_html), $post_theme);
		}

		return str_replace(array_keys($mySyntax), array_values($mySyntax), $post_theme);
	}

	public function render_system_pagination($home_theme, $config, $page)
	{
		$html = '';
	
		$limit 	= $config['pagination-limit'];
		$offset = ($limit * $page)-($limit);
		$post 	= post::where('draft', false)
					->limit($limit)
					->offset($offset)
					->orderBy('id', 'DESC');
		$total 	= post::where('draft', false)->count();
		$total_page = ceil($total/$limit);
		$tmp_html = '';
		$simple_paginate = true;
		if ($config['force-full-pagination'] == 1) $simple_paginate = false;

		### GET HTML
		preg_match_all('/\[\:data.pagination.div.start:](.*?)\[\:data.pagination.div.end:]/s', $home_theme, $output);

		foreach ($output[1] as $opt_key => $opt_value) {
			## GET HTML - btn page
			preg_match_all('/\[\:pagination.btn-page.start:](.*?)\[\:pagination.btn-page.end:]/s', $home_theme, $html_btn_page);

			## GET HTML - btn page active
			preg_match_all('/\[\:pagination.btn-page.active.start:](.*?)\[\:pagination.btn-page.active.end:]/s', $home_theme, $html_btn_page_active);

			## GET HTML - btn far
			preg_match_all('/\[\:pagination.btn-far.start:](.*?)\[\:pagination.btn-far.end:]/s', $home_theme, $html_btn_far);

			## GET HTML - btn previous active
			preg_match_all('/\[\:pagination.btn-previous.active.start:](.*?)\[\:pagination.btn-previous.active.end:]/s', $home_theme, $html_btn_previous_active);

			## GET HTML - btn previous disable
			preg_match_all('/\[\:pagination.btn-previous.disable.start:](.*?)\[\:pagination.btn-previous.disable.end:]/s', $home_theme, $html_btn_previous_disable);

			## GET HTML - btn next active
			preg_match_all('/\[\:pagination.btn-next.active.start:](.*?)\[\:pagination.btn-next.active.end:]/s', $home_theme, $html_btn_next_active);

			## GET HTML - btn next disable
			preg_match_all('/\[\:pagination.btn-next.disable.start:](.*?)\[\:pagination.btn-next.disable.end:]/s', $home_theme, $html_btn_next_disable);



			$tmp_html_page = '';
			$tmp_html_page_child = '';
			$tmp_html_end = '';
			$tmp_html_first = '';
			$paginate_far_left = false;
			$paginate_far_right = false;
			$tmp_html_btn_previous = "";
			$tmp_html_btn_next = "";

			if ($page == 1)
			{			 
				$tmp_html_btn_previous = $html_btn_previous_disable[1][$opt_key];
			} else {
				$tmp_this = $html_btn_previous_active[1][$opt_key];
				$property = [
					'[:url:]' => route('page', ['page' => $page-1]),
				];
				$tmp_html_btn_previous = str_replace(array_keys($property), array_values($property), $tmp_this);	
			}

			if ($page == $total_page or $total_page < 1)
			{			 
				$tmp_html_btn_next = $html_btn_next_disable[1][$opt_key];
			} else {
				$tmp_this = $html_btn_next_active[1][$opt_key];
				$property = [
					'[:url:]' => route('page', ['page' => $page+1]),
				];
				$tmp_html_btn_next = str_replace(array_keys($property), array_values($property), $tmp_this);	
			}

			if ($simple_paginate) {
				$simple_paginate_run = false;
				if ($total_page > 10) $simple_paginate_run = true;
			} else {
				$simple_paginate_run = false;
			}

			if ($simple_paginate_run)
			{
				if ( $page-3 >= 1 ) {
					$paginate_far_left = true;
				} 
				if ( $page+3 < $total_page ) {
					$paginate_far_right = true;
				}
			}

			for ($i=1; $i < $total_page+1; $i++) {

				if ($simple_paginate_run)
				{
					if ($i != 1 and $i != $total_page){
						if (($i > ($page-3)) and ($i < ($page+3)) )
						{
							if ($page == $i)
							{
								$tmp_this = $html_btn_page_active[1][$opt_key];
								$property = [
									'[:page:]' => $i,
								];
								$tmp_html_page .= str_replace(array_keys($property), array_values($property), $tmp_this);
							} else {
								$tmp_this = $html_btn_page[1][$opt_key];
								$property = [
									'[:url:]' => route('page', ['page' => $i]),
									'[:page:]' => $i,
								];
								$tmp_html_page .= str_replace(array_keys($property), array_values($property), $tmp_this);
							}
						}
					}
				} else {
					if ($i != 1 and $i != $total_page){
						if ($page == $i)
						{
							$tmp_this = $html_btn_page_active[1][$opt_key];
							$property = [
								'[:page:]' => $i,
							];
							$tmp_html_page .= str_replace(array_keys($property), array_values($property), $tmp_this);
						} else {
							$tmp_this = $html_btn_page[1][$opt_key];
							$property = [
								'[:url:]' => route('page', ['page' => $i]),
								'[:page:]' => $i,
							];
							$tmp_html_page .= str_replace(array_keys($property), array_values($property), $tmp_this);
						}
					}
				}

				if ($i == 1){
					if ($page == 1) 
					{
						$tmp_this = $html_btn_page_active[1][$opt_key];
						$property = [
							'[:page:]' => $i,
						];
						$tmp_html_first = str_replace(array_keys($property), array_values($property), $tmp_this);
					} else {
						$tmp_this = $html_btn_page[1][$opt_key];
						$property = [
							'[:url:]' => route('page', ['page' => $i]),
							'[:page:]' => $i,
						];
						$tmp_html_first = str_replace(array_keys($property), array_values($property), $tmp_this);
					}


					

				} elseif ($i == $total_page){
					if ($page == $total_page) 
					{
						$tmp_this = $html_btn_page_active[1][$opt_key];
						$property = [
							'[:page:]' => $i,
						];
						$tmp_html_end = str_replace(array_keys($property), array_values($property), $tmp_this);
					} else {
						$tmp_this = $html_btn_page[1][$opt_key];
						$property = [
							'[:url:]' => route('page', ['page' => $i]),
							'[:page:]' => $i,
						];
						$tmp_html_end = str_replace(array_keys($property), array_values($property), $tmp_this);
					}
				}

			}

			$tmp_html_far = $html_btn_far[1][$opt_key];

			if ($paginate_far_left) $tmp_html_page = $tmp_html_far . $tmp_html_page;
			if ($paginate_far_right) $tmp_html_page = $tmp_html_page . $tmp_html_far;

			$tmp_html = $tmp_html_btn_previous . $tmp_html_first 
						. $tmp_html_page . 
						$tmp_html_end . $tmp_html_btn_next;

			$html .= $tmp_html;
			$home_theme = str_replace($output[0][$opt_key], $html, $home_theme);
		}
		return $home_theme;
	}

	public function render_post_looping($home_theme, $config, $page)
	{

			$limit = $config['pagination-limit'];
			$offset = ($limit * $page)-($limit);
			$total 	= post::where('draft', false)->count();
			$total_page = ceil($total/$limit);

			## Post Loop
			preg_match_all("/\[\:data.post.div.start:](.*?)\[\:data.post.div.end:]/s", $home_theme, $output);
			$post = post::where('draft', false)
						->limit($limit)
						->offset($offset)
						->orderBy('id', 'DESC');
			if ($page != 1 and $page > $total_page) abort(404);

			foreach ($output[1] as $op_key => $op) {
				$html = $op;
				$ot = '';
				$all_post = [];

				foreach ($post->get() as $post) {
					$tmp_ot = $html;

					##max title
					if ($config['title-max'] != 'no')
					{
						if (strlen($post->title) > $config['title-max'])
						{
							$post->title = substr($post->title, 0, $config['title-max']) . $config['max-symbol'];
						}
					}


					## Replace Information POST
					$postInfo = [
						'[:post.title:]' => $post->title,
						'[:post.description:]' => $post->description,
						'[:post.url:]' => vcms::get_post_url($post->url),
					];
					$tmp_ot = str_replace(array_keys($postInfo), array_values($postInfo), $tmp_ot);

					$ot .= $tmp_ot;

					## Replace A Category
					preg_match_all("/\[\:post.category\|(.*?)\|(.*?):]/", $ot, $opt);
					foreach ($opt[1] as $opt_key => $opt_value) {
						$category_html = $opt_value;
						$opt_html = [];
						$category_all = json_decode($post->category);

						foreach ($category_all as $category) {
							$tmp_opt = $category_html;
							$tmp_opt = str_replace('[:post.category.text:]', category::find($category)->name, $tmp_opt);
							$opt_html[] = $tmp_opt;
						}

						if (count($category_all) == 0) $opt_html[] = $config['category-null'];

						$ot = str_replace($opt[0][$opt_key], implode($opt[2][$opt_key], $opt_html), $ot);
					}

					$all_post[] = $ot;
					$ot = '';
				}

				if ($post->count() > 0) 
				{
					$home_theme = str_replace($output[0][$op_key], implode($config['post-glue'], $all_post), $home_theme);
				} else {
					$home_theme = str_replace($output[0][$op_key], $config['post-null'], $home_theme);
				}
			}


			return $home_theme;
	}

	public function render_config($home_theme, $config)
	{
		#~ Get Manual Config :
		preg_match_all("/\[\:set.config.(.*)\|(.*):]/", $home_theme, $output);
		foreach ($output[0] as $key => $value) {
			$home_theme = str_replace($value, '', $home_theme);
			if (isset($config[$output[1][$key]]))
			{
				$config[$output[1][$key]] = $output[2][$key];
			}
		}

		return [$home_theme, $config];
	}
	public function render_app_info($home_theme)
	{
		## Replace Information CMS
		$mySyntax = [
			'[:app.title:]' => vcms::setting()->get('app_title'),
			'[:app.description:]' => vcms::setting()->get('app_description'),
			'[:app.author:]' => vcms::setting()->get('app_author'),
			'[:app.email:]' => vcms::setting()->get('app_email'),
			'[:app.address:]' => vcms::setting()->get('app_address'),
			'[:app.home.url:]' => route('home'),
		];
		return str_replace(array_keys($mySyntax), array_values($mySyntax), $home_theme);
	}
}