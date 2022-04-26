@extends('layouts.app')

@section('main')
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 mx-auto border rounded-3 bg-light p-5">
                <h1 class="display-3">Анализатор страниц</h1>
                <p class="lead">Бесплатно проверяйте сайты на SEO пригодность</p>

                {{ Form::open(['route' => 'urls.store', 'method' => 'POST', 'class' => 'd-flex justify-content-center']) }}
                {{ Form::text('name', '', [
                    'placeholder' => 'https://www.example.com',
                    'class' => 'form-control form-control-lg',
                    'required' => true,
                    'autocomplete' => 'off',
                ]) }}
                {{ Form::submit('Проверить', ['class' => 'btn btn-primary btn-lg ms-3 px-5 text-uppercase mx-3']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
