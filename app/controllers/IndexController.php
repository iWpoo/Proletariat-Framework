<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Services\ServiceInterface;

class IndexController extends Controller
{
	public function index()
    {        
        $users = User::all();
        
        return $this->render('index', compact('users'));
    }

    public function store()
    {
        return $this->back();
    }
}