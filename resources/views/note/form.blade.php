@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    @if(isset($note))
                        <h2 class="mb-1">{{ __('Edit Note') }}</h2>
                    @else
                        <h2 class="mb-1">{{ __('New Note') }}</h2>
                    @endif
                </div>
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('home') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i>  Back</a>
                </div>
            </div>
            <div class="card-body">
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        <strong>{{Session::get('error')}}</strong>
                    </div>
                @endif
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input id="title" name="title" type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="@if($note ?? '') {{ $note->title }} @endif">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">{{ __('Body') }}</label>
                                <textarea id="content" name="body" rows="6"
                                          class="form-control @error('body') is-invalid @enderror">@if($note ?? '') {{ $note->body }} @endif</textarea>
                                @error('body')
                                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                @if ($note ?? '')
                                    @method('PUT')
                                    <button class="btn btn-warning" formaction="{{ route('notes.update', $note) }}"
                                            type="submit">{{ __('Update') }}</button>
                                @else
                                    <button class="btn btn-primary" formaction="{{ route('notes.store') }}"
                                            type="submit">{{ __('Submit') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
