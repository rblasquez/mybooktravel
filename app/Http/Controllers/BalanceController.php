<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
	public function __construct()
    {
        parent::__construct();
    }
    
	public function index()
	{
		return view('balance.index');
	}
}
