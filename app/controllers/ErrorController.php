<?php

namespace App\Controllers;

use Core\Controller;
	
class ErrorController extends Controller
{
	public function notFound() {
		return $this->render('error/notfound', []);
	}
}