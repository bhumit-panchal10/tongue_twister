@extends('layouts.app')

@section('title', 'Blog List')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                @if ($errors->any())
                    {{--  <h5 style="color:red">Following errors exists in your excel file</h5>  --}}

                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach

                @endif
                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Blog</h4>
                            <a href="{{ route('blog.create') }}" class="btn btn-sm btn-success">
                                <i data-feather="plus"></i> Add New
                            </a>
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
                                            <th width="1%">sr.no</th>
                                            <th width="5%">Title</th>
                                            <th width="5%">Description</th>
                                            <th width="2%">Photo</th>
                                            <th width="1%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Blog as $blog)
                                            <tr class="text-center">
                                                <td>
                                                    {{ $i + $Blog->perPage() * ($Blog->currentPage() - 1) }}</td>
                                                <td>{{ $blog->strTitle }}</td>
                                                <td>
                                                    {{ strip_tags(Str::limit($blog->strDescription, 200, '.....')) }}
                                                </td>
                                                <td class="text-center">
                                                    <?php if($blog->strPhoto == "" || $blog->strPhoto == null){ ?>
                                                    <a target="_blank" href="{{ asset('assets/images/noimage.png') }}">
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width: 50px;height: 50px;">
                                                    </a>
                                                    <?php }else{ ?>
                                                    <a target="_blank"
                                                        href="{{ asset('/Blog/Thumbnail/') . '/' . $blog->strPhoto }}">
                                                        <img src="{{ asset('/Blog/Thumbnail/') . '/' . $blog->strPhoto }}"
                                                            style="width: 50px;height: 50px;">
                                                    </a>
                                                    <?php } ?>

                                                </td>

                                                <td class="text-center">

                                                    <a class="mx-1" title="Edit"
                                                        href="{{ route('blog.edit', $blog->blogId) }}">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <a class="mx-1" href="#" data-bs-toggle="modal" title="Delete"
                                                        data-bs-target="#deleteRecordModal"
                                                        onclick="deleteData(<?= $blog->blogId ?>);">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $Blog->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    <!--Delete Modal -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <form id="user-delete-form" method="POST" action="{{ route('blog.delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="blogId" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Modal -->

@endsection

@section('scripts')


    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


@endsection
