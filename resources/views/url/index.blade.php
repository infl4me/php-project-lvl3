@extends('layouts.app')

@section('main')
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h1 class="h1 mt-5 mb-3">Сайты</h1>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Последняя проверка</th>
                                <th>Код ответа</th>
                            </tr>
                            @foreach ($urls as $url)
                                <tr>
                                    <td>{{ $url->id }}</td>
                                    <td><a href="{{ route('urls.show', [$url->id]) }}">{{ $url->name }}</a></td>
                                    <td>{{ $url->created_at }}</td>
                                    <td>?</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
