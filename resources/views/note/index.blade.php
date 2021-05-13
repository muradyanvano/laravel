@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            @if($trash)
                                <h2 class="mb-1">{{ __('Recycle Bin') }}</h2>
                            @else
                                <h2 class="mb-1">{{ __('Notes') }}</h2>
                            @endif
                        </div>
                        <div class="float-right">
                            @if($trash)
                                <a class="btn btn-primary" href="{{ route('home') }}"><i class="fas fa-list-alt"></i> View All</a>
                            @else
                                <a href="{{ route('notes.create') }}" class="btn btn-primary"><i
                                        class="fas fa-plus-circle"></i>Add New</a>
                                <a href="{{ route('notes.trash') }}" class="btn btn-danger"><i
                                        class="fas fa-trash-alt"></i> Recycle Bins</a>
                            @endif


                        </div>
                    </div>
                    <div class="card-body">
                        @if (isset($error))
                            <h1>Vandam</h1>
                            <div class="alert alert-danger">
                                <strong>{{ $error }}</strong>
                            </div>
                        @endif

                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th width="180">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $no = 1 @endphp

                            @foreach($notes as $note)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $note->title }}</td>
                                    <td>
                                        @if($trash)
                                            <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Restore"
                                               href="{{ route('notes.restore', $note) }}"><i class="fas fa-trash-restore"></i></a>
                                            <form action="{{ route('notes.remove') }}" method="POST"
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$note->id}}">
                                                <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Remove"
                                                        type="submit"><i class="fas fa-times-circle"></i></button>
                                                @else
                                                    <a class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="View"
                                                       href="{{ route('notes.show', $note) }}"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"
                                                       href="{{ route('notes.edit', $note) }}"><i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('notes.destroy', $note) }}" method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Trash"
                                                                type="submit"><i class="fas fa-trash"></i></button>
                                                    </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
