<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Services\ServiceInterface;

class IndexController extends Controller
{
    private $service;

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

	public function index()
    {        
        // $users = User::all();
        
        // $users = \Core\Cache::get('users');

        // return $this->render('index', compact('users'));

        return \Core\Config::get('cache.default');   
    }

    public function about()
    {
        return 'Hello World';
    }

    public function store()
    {
        return $this->redirect()->route('index');
    }
}