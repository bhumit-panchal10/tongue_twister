@extends('layouts.app')

@section('title', 'Meta Data List')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="display: flex;justify-content: space-between;">
                                <h5 class="card-title mb-0">Meta Data List</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                Id
                                            </th>
                                            <th scope="col">
                                                Page Name
                                            </th>
                                            <th scope="col">
                                                Meta Title
                                            </th>
                                            <th scope="col">
                                                Meta Keyword
                                            </th>
                                            <th scope="col">
                                                Meta Description
                                            </th>

                                            <th scope="col">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $datas)
                                            <tr class="text-center">
                                                <td width="1%">
                                                    {{ $datas->id ?? '' }}
                                                </td>
                                                <td width="1%">
                                                    {{ $datas->pagename ?? '' }}
                                                </td>
                                                <td width="6%">
                                                    {{ $datas->metaTitle ?? '' }}
                                                </td>
                                                <td width="6%">
                                                    {{ $datas->metaKeyword ?? '' }}
                                                </td>
                                                <td width="6%">
                                                    {{ $datas->metaDescription ?? '' }}
                                                </td>
                                                <td width="1%">
                                                    <a class="btn btn-link p-0" title="Edit"
                                                        href="{{ route('metaData.edit', $datas->id) }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection
