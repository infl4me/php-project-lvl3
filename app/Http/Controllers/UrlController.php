<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function index()
    {
        $urls = DB::select('SELECT * FROM urls');

        return view('url.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|url|unique:urls',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('ntfn', ['status' => 'danger', 'message' => 'There is validation error']);

            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $url = $request->input('name');
        $dateNow = Carbon::now();
        DB::insert("INSERT INTO urls VALUES (default, '{$url}', '{$dateNow}')");

        $request->session()->flash('ntfn', ['status' => 'success', 'message' => 'Url has been added!']);

        return redirect()->route('/');
    }
}
