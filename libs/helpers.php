<?php

use Libs\View;

if (! function_exists("view")) {
	/**
	 * @param   string	$key
	 * @param   mixed[]	$params = []
	 */
	function view(string $key, array $params = []): View
    {
		return View::make($key, $params);
	}
}
