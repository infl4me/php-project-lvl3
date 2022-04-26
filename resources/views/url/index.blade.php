@extends('layouts.app')

@section('main')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Последняя проверка</th>
                <th scope="col">Код ответа</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($urls as $url)
                <tr>
                    <th scope="row">{{ $url->id }}</th>
                    <td><a href="{{ $url->name }}" target="_blank">{{ $url->name }}</a></td>
                    <td>{{ $url->created_at }}</td>
                    <td>?</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
