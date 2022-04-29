<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::with('urlChecks')->get()->map(function ($url) {
            $lastCheck = $url->urlChecks->last();
            if (!$lastCheck) {
                return $url;
            }

            $url['status_code'] = $lastCheck->status_code;
            $url['last_checked'] = $lastCheck->created_at;
            return $url;
        });

        return view('url.index', compact('urls'));
    }

    public function show($id)
    {
        $url = Url::find($id);
        $urlChecks = $url->urlChecks;

        return view('url.view', compact('url', 'urlChecks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url.name' => 'max:255|url',
        ]);
        if (!$request->input('url.name') || $validator->fails()) {
            $request->session()->flash('ntfn', ['status' => 'danger', 'message' => 'Некорректный URL']);

            return redirect()
                ->route('/')
                ->withErrors($validator)
                ->withInput();
        }
        ['host' => $host, 'scheme' => $scheme] = parse_url($request->input('url.name'));
        $url = $scheme . '://' . $host;

        $existingUrls = Url::where('name', $url)->get();

        if (collect($existingUrls)->isNotEmpty()) {
            $request->session()->flash('ntfn', ['status' => 'info', 'message' => 'Страница уже существует']);
            return redirect()->route('urls.show', [$existingUrls[0]->id]);
        }

        $newUrl = Url::make(['name' => $url]);
        $newUrl->save();

        $request->session()->flash('ntfn', ['status' => 'success', 'message' => 'Страница успешно добавлена']);
        return redirect()->route('urls.show', $newUrl);
    }
}
