@extends('layouts.app')

@section('main')
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h1 class="h1 mt-5 mb-3">Сайт: {{ $url->name }}</h1>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{ $url->id }}</td>
                            </tr>
                            <tr>
                                <td>Имя</td>
                                <td>{{ $url->name }}</td>
                            </tr>
                            <tr>
                                <td>Дата создания</td>
                                <td>{{ $url->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
