<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlCheckController extends Controller
{
    public function store($id, Request $request)
    {
        $url = Url::find($id);

        $urlCheck = $url->urlChecks()->make();
        $urlCheck->save();

        $request->session()->flash('ntfn', ['status' => 'info', 'message' => 'Страница успешно проверена']);

        return redirect()->route('urls.show', $url);
    }
}
