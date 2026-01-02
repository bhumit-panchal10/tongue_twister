@extends('layouts.app')

@section('title', 'Pages List')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" style="margin-top:5rem !important">
                    <thead>
                        <tr>
                            <th>
                                Id
                            </th>
                            <th>
                                Page Name
                            </th>
                            <th>
                                Page Title
                            </th>
                            <th>
                                {{ 'Action' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $datas)
                            <tr data-entry-id="{{ $datas->id }}">
                                <td>
                                    {{ $datas->id ?? '' }}
                                </td>
                                <td>
                                    {{ $datas->Name ?? '' }}
                                </td>
                                <td>
                                    {{ $datas->Title ?? '' }}
                                </td>
                                
                                <td>
                                    <a class="btn btn-link p-0" title="Edit" href="{{ route('pages.edit', $datas->id) }}">
                                        <span class="text-500 fas fa-edit"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
