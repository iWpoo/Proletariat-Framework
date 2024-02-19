<?php

namespace App\Controllers;

use Proletariat\Controller;
use App\Models\User;
use App\Services\ServiceInterface;

class IndexController extends Controller
{
    private ServiceInterface $service;

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

	public function index()
    {        
        // $users = User::all();
        // return $users;
        return route('about');
        
    }

    public function about()
    {
        return 'Hello World';
    }

    public function store()
    {
        return route('index');
    }
}