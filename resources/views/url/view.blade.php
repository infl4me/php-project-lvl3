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

                <h2 class="h2 mt-5 mb-3">Проверки</h2>
                {{ Form::open(['url' => route('url_checks.store', $url->id), 'method' => 'POST', 'class' => 'd-flex mb-3']) }}
                {{ Form::submit('Запустить проверку', ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Код ответа</th>
                                <th>h1</th>
                                <th>title</th>
                                <th>description</th>
                                <th>Дата Создания</th>
                            </tr>
                            @foreach ($urlChecks as $urlCheck)
                                <tr>
                                    <td>{{ $urlCheck->id }}</td>
                                    <td>{{ $urlCheck->status_code }}</td>
                                    <td>{{ $urlCheck->h1 }}</td>
                                    <td>{{ $urlCheck->title }}</td>
                                    <td>{{ $urlCheck->description }}</td>
                                    <td>{{ $urlCheck->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
