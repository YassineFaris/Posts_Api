<?php

namespace App\Http\Controllers;

class GuideController extends Controller
{
	public function Welcome()
	{
        return
        response('Access Denied', 401)
        ->header('Content-Type', 'application/json');
    }
}





