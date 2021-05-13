@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h2 class="mb-1">{{ __('Preview Note') }}</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('home') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>  Back</a>
                </div>
            </div>
            <div class="card-body">
                <h1 class="text-center">{{ $note->title }}</h1>
                <p>
                    {{ $note->body }}

                </p>

                <p>
                    <span><b>{{ __('Created:') }}</b> {{ $note->created_at }}</span><br>
                    <span><b>{{ __('Last update:') }}</b> {{ $note->updated_at }}</span>
                </p>
            </div>
        </div>
    </div>
@endsection
