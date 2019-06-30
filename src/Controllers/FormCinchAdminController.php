<?php

namespace Ngmedia\FormCinch\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ngmedia\FormCinch\FormCinch;

class FormCinchAdminController extends Controller
{
    public function index()
    {
    	try{
		$forms = FormCinch::all();
	    } catch(\Exception $e) {
    		$forms = 'not setup';
	    }

    	return view('formcinch::admin.index', compact('forms'));
    }

	public function create()
	{
		return view('formcinch::admin.create');
	}

	public function show($slug)
	{
		$form = FormCinch::where('slug', $slug)->first();

		return view('formcinch::admin.results', compact('form'));
	}
}
