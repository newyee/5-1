@extends('layouts.app')
@section('title', 'つぶやき一覧')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{ action('PostController@create') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="body" value="{{ old('body') }}">
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary mb-4" value="つぶやき">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                @isset($formatDisplayItem)
                    @foreach ($formatDisplayItem as $data)
                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="col-4 card-title">{{ $data['user_name'] }}</p>
                                <p class="col-4 card-text">{{ $data['body'] }}</p>
                                <p class="col-4 card-text">{{ $data['created_at'] }}</p>
                                @if (Auth::user()->id === $data['user_id'])
                                    <div class="row justify-content-end">
                                        <a href="{{ action('PostController@delete', ['id' => $data['post_id']]) }}"
                                            class="btn btn-primary">削除</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
@endsection
