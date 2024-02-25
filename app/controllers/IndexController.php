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
        
    }

    public function about()
    {
        return 'About';
    }

    public function store()
    {
        return redirect()->route('index');
    }
}