<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store($id, Request $request)
    {
        $url = Url::find($id);

        $response = Http::get($url->name);
        $urlCheck = $url->urlChecks()->make([
            'status_code' => $response->status(),
        ]);
        $urlCheck->save();

        $request->session()->flash('ntfn', ['status' => 'info', 'message' => 'Страница успешно проверена']);

        return redirect()->route('urls.show', $url);
    }
}
