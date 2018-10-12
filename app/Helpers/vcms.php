<?php
/**
 * VIFA CMS
 */
namespace App\Helpers;

class vcms
{
	private static $setting = null;

	public static function setting()
	{
		if (self::$setting == null)
		{
			self::$setting = new setting();
		}
		return self::$setting;
	}

	public static function get_post_url($url)
	{
		$model = json_decode(self::setting()->get('post_url'));
		if ($model->model == 1) return route('post.model1', ['post' => $url]);
		if ($model->model == 2) return route('post.model2', ['segment_1' => $model->segment[0], 'post' => $url]);
	}
}

class setting
{
	public function set($key, $value = '')
	{
		$con = \App\Models\config::find($key);
		$con->value = $value;
		return $con->save();
	}

	public function get($key, $default = null)
	{
		$con = \App\Models\config::find($key);

		if ($con == null) return $default;
		return $con->value;
	}

	public function create($key, $value = '')
	{
		$con = new \App\Models\config();
		$con->key = $key;
		$con->value = $value;
		return $con->save();
	}
}