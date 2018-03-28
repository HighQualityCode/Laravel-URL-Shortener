@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="shortener">
                        <h2>URL-Shortener</h2>
                        {{Form::open(array('url'=>'/home','method'=>'post'))}}
                        {{ csrf_field() }}
                        <div class="mb-2">
                            {{Form::text('link',Input::old('link'),array('class'=>'w-100 p-2' ,'placeholder'=>'Insert your URL here and press enter!'))}}
                        </div>
                        {{Form::close()}}
                    </div>

                    <div id="urls">
                        @foreach($links as $link)
                            <div class="row">
                                <div class="col-5">{{Html::link($link->hash, `$link->hash`)}}</div>
                                <div class="col-5">{{$link->url}}</div>
                                <div class="col-2">{{$link->count}}</div>
                            </div>
                        @endforeach
                    </div>

                    @if(Session::has('errors'))
                        <h3 class="error">{{$errors->first('link')}}</h3>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
