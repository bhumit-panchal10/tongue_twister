@extends('layouts.app')
@section('title', 'Category List')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="display: flex;justify-content: space-between;">
                            <h5 class="card-title mb-0">Category List</h5>
                            <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary">
                                <i data-feather="plus"></i> Add New
                            </a>
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
                                        <th scope="col">Sequence No.</th>
                                        <th scope="col">Parent </th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">GST</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    //dd($Category);
                                    ?>
                                    @foreach ($Category as $category)
                                    <tr>
                                        {{-- <td>{{ $i + $Category->perPage() * ($Category->currentPage() - 1) }} --}}
                                        <td class="text-center">{{ $category->strSequence }}</td>
                                        <td class="text-center">{{ $category->parentname ?? '-' }}</td>

                                        <td class="text-center">{{ $category->name }}</td>

                                        <td class="text-center">
                                            <?php if ($category->categoryphoto) { ?>
                                                <img src="{{ asset('/Category') . '/' . $category->categoryphoto }}"
                                                    style="width: 50px;height: 50px;">
                                            <?php } else { ?>
                                                <img src="{{ asset('assets/images/noimage.png') }}"
                                                    style="width: 50px;height: 50px;">
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">{{ $category->strGST }}</td>
                                        <td class="text-center">
                                            @if ($category->iStatus == 0)
                                            <span class="badge badge-gradient-danger">Inactive</span>
                                            @elseif ($category->iStatus == 1)
                                            <span class="badge badge-gradient-primary">Active</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2">
                                                @if ($category->iStatus == 0)
                                                <a href="{{ route('category.status', ['category_id' => $category->categoryId, 'status' => 1]) }}"
                                                    title="InActive" class="mx-1"
                                                    onclick="return confirm('Are you sure you want to change the status to Active?')">
                                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                                </a>
                                                @elseif ($category->iStatus == 1)
                                                <a href="{{ route('category.status', ['category_id' => $category->categoryId, 'status' => 0]) }}"
                                                    title="Active" class="mx-1"
                                                    onclick="return confirm('Are you sure you want to change the status to InActive?')">
                                                    <i class="fa fa-unlock" aria-hidden="true"></i>
                                                </a>
                                                @endif

                                                <a class="mx-1" title="Edit"
                                                    href="{{ route('category.edit', $category->categoryId) }}">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                                <a class="" href="#" data-bs-toggle="modal"
                                                    title="Delete" data-bs-target="#deleteRecordModal"
                                                    onclick="deleteData(<?= $category->categoryId ?>);">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $Category->links() }} 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Delete Modal Start -->
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
                                    colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                </lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you Sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                        ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <a class="btn btn-primary mx-2" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                    Yes,
                                    Delete It!
                                </a>
                                <button type="button" class="btn w-sm btn-primary mx-2"
                                    data-bs-dismiss="modal">Close</button>
                                <form id="user-delete-form" method="POST" action="{{ route('category.delete') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="categoryId" id="deleteid" value="">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Delete modal End -->

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function deleteData(id) {
        $("#deleteid").val(id);
    }
</script>
@endsection