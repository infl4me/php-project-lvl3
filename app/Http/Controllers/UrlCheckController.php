<?php

namespace App\Http\Controllers;

use App\Models\Url;
use DiDom\Document;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store($id, Request $request)
    {
        $url = Url::find($id);

        try {
            $response = Http::get($url->name);
        } catch (ConnectionException $err) {
            $request->session()->flash('ntfn', ['status' => 'danger', 'message' => $err->getMessage()]);

            return redirect()->route('urls.show', $url);
        }

        $document = new Document($response->body());
        $h1 = $document->first('h1');
        $title = $document->first('title');
        $description = $document->first('meta[name="description"]');
        $urlCheck = $url->urlChecks()->make([
            'status_code' => $response->status(),
            'h1' => $h1 ? $h1->text() : null,
            'title' => $title ? $title->text() : null,
            'description' => $description ? $description->getAttribute('content') : null,
        ]);
        $urlCheck->save();

        $request->session()->flash('ntfn', ['status' => 'info', 'message' => 'Страница успешно проверена']);

        return redirect()->route('urls.show', $url);
    }
}
