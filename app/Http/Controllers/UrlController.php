<?php

namespace App\Http\Controllers;

use App\Models\Url;
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

    public function show($id)
    {
        [$url] = DB::select("
            SELECT * FROM urls
            WHERE id = '{$id}'
        ");
        $urlChecks = DB::select('SELECT * FROM url_checks');

        return view('url.view', compact('url', 'urlChecks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|url',
        ]);
        if ($validator->fails()) {
            $request->session()->flash('ntfn', ['status' => 'danger', 'message' => 'Некорректный URL']);

            return redirect()
                ->route('/')
                ->withErrors($validator)
                ->withInput();
        }

        ['host' => $host, 'scheme' => $scheme] = parse_url($request->input('name'));
        $url = $scheme . '://' . $host;
        $validator = Validator::make(['url' => $url], [
            'url' => 'required|max:255|url',
        ]);

        $existingUrls = DB::select("
            SELECT * FROM urls
            WHERE name = '{$url}'
        ");
        if (collect($existingUrls)->isNotEmpty()) {
            $request->session()->flash('ntfn', ['status' => 'info', 'message' => 'Страница уже существует']);
            return redirect()->route('urls.show', [$existingUrls[0]->id]);
        }

        // DB::insert("INSERT INTO urls VALUES (default, '{$url}', '{$dateNow}')");
        Url::make(['name' => $url])->save();

        [$newUrl] = DB::select("SELECT * FROM urls ORDER BY id DESC LIMIT 1");

        $request->session()->flash('ntfn', ['status' => 'success', 'message' => 'Страница успешно добавлена']);
        return redirect()->route('urls.show', [$newUrl->id]);
    }
}
