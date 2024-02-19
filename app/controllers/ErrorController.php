<?php

namespace App\Controllers;

use Proletariat\Controller;
	
class ErrorController extends Controller
{
	public function notFound() {
		return $this->render('error/notfound', []);
	}
}