<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Users;
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
        return $this->service->doSomething();
    }

    public function store()
    {
        $user = new Users();
        $user->create([
            'username' => 'admin',
            'password' => 'admin',
        ]);
        return $this->back();
    }
}