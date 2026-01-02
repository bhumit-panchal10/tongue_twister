@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <!--<div class="row">-->
            <!--    <div class="col-lg-12">-->
            <!--        <div class="card">-->
            <!--            <div class="card-header"-->
            <!--                style="display: flex;-->
            <!--            justify-content: space-between;">-->
            <!--                <h5 class="card-title mb-0">Add Product</h5>-->
            <!--                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">-->
            <!--                    <i data-feather="plus"></i> Add New-->
            <!--                </a>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"
                            style="display: flex;
                            justify-content: space-between;">
                            <h5 class="card-title mb-0">Search Product</h5>
                        </div>
                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST"
                                    action="{{ route('product.index') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">

                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <select class="form-control" name="searchCategoryId">
                                                    <option value="">Select Category Name </option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->categoryId }}"
                                                        {{ isset($searchCategoryId) && $searchCategoryId == $category->categoryId ? 'selected' : '' }}>
                                                        {{ $category->categoryname }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div>
                                                <input type="text" class="form-control" placeholder="Search Product Name"
                                                    name="searchProductName" autocomplete="off"
                                                    value="{{ $searchProductName ?? "" }}">
                                            </div>
                                        </div>
                                        <!--</div>-->
                                        <!--<div class="card-footer mt-5" style="float: right;">-->
                                        <div class="col-lg-4 col-md-6">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Search</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('product.index') }}">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header"
                            style="display: flex;
                            justify-content: space-between;">
                            <h5 class="card-title mb-0">Product List</h5>
                            <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">
                                <i data-feather="plus"></i> Add New
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Category Name</th>
                                        <!--<th scope="col">Sub Category Name</th>-->
                                        <th scope="col">Photo</th>
                                        <th scope="col">Rate Without GST</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($Product as $product)
                                    <tr class="text-center">
                                        <td width="1%">
                                            {{ $i + $Product->perPage() * ($Product->currentPage() - 1) }}
                                        </td>
                                        <td width="2%">{{ $product->productname }}</td>
                                        <td width="2%">
                                            <?php
                                            $CategoryMultiple = \App\Models\CategoryMultiple::select('multiplecategory.productid', 'multiplecategory.categoryid', 'category.categoryname')
                                                ->orderBy('id', 'DESC')
                                                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                                                ->where(['multiplecategory.iStatus' => 1, 'multiplecategory.isDelete' => 0, 'multiplecategory.productid' => $product->productId])
                                                ->get();

                                            $dist = '';
                                            foreach ($CategoryMultiple as $district) {
                                                $dist .= $district->categoryname . ',';
                                            }
                                            echo rtrim($dist, ',');
                                            ?>
                                        </td>

                                        <!--<td width="2%">-->
                                        <!--    {{ $product->subcategoryname ?? '-' }}-->
                                        <!--</td>-->

                                        <td width="3%">
                                            <a href='{{asset('Product/Thumbnail/').'/'.$product->photo }}' target='_blank'>
                                                <img src="{{ asset('Product/Thumbnail/') . '/' . $product->photo }}" style="width: 50px;height: 50px;" alt="">
                                            </a>
                                            <?php
                                            // $ProductImages = App\Models\Productphotos::where(['productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productphotos.productid' => $product->productId])
                                            //     ->join('product', 'productphotos.productid', '=', 'product.productId')
                                            //     ->get();
                                            // $trim = '';

                                            // foreach ($ProductImages as $data) {
                                            //     $trim .= "<a href='/Product/Thumbnail/$data->strphoto' target='_blank'><img class='mb-2 mx-2' src='/Product/Thumbnail/$data->strphoto' style=width:70px;height:60px;border:2px solid;></a>";
                                            // }
                                            // echo rtrim($trim, ',');



                                            ?>
                                        </td>
                                        <td width="2%">
                                            {{ $product->AmountWithOutGST ?? 0 }}
                                        </td>
                                        <td width="1%">
                                            {{ $product->rate }}
                                        </td>
                                        <td width="1%">
                                            {{ $product->weight }}
                                        </td>

                                        <td width="1%">
                                            @if ($product->iStatus == 0)
                                            <span class="badge badge-gradient-danger">Inactive</span>
                                            @elseif ($product->iStatus == 1)
                                            <span class="badge badge-gradient-primary">Active</span>
                                            @endif
                                        </td>

                                        <td width="2%">

                                            @if ($product->iStatus == 0)
                                            <a href="{{ route('product.status', ['product_id' => $product->productId, 'status' => 1]) }}"
                                                title="InActive" class="mx-1"
                                                onclick="return confirm('Are you sure you want to change the status to Active?')">
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            </a>
                                            @elseif ($product->iStatus == 1)
                                            <a href="{{ route('product.status', ['product_id' => $product->productId, 'status' => 0]) }}"
                                                title="Active" class="mx-1"
                                                onclick="return confirm('Are you sure you want to change the status to InActive?')">
                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                            </a>
                                            @endif

                                            <a class="mx-1" title="Edit"
                                                href="{{ route('product.edit', $product->productId) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="mx-1" href="#" data-bs-toggle="modal" title="Delete"
                                                data-bs-target="#deleteRecordModal"
                                                onclick="deleteData(<?= $product->productId ?>);">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                            <a class="mx-1" title="Product Photos List"
                                                href="{{ route('product.productphotos', $product->productId) }}">
                                                <i class="fa-solid fa-plus fa-lg"></i>
                                            </a>

                                            <a class="mx-1" title="Product Attribute"
                                                href="{{ route('product.product_attribute', $product->productId) }}">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $Product->appends(request()->except('page'))->links() }}
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
                    <a class="btn btn-primary mx-2" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                        Yes,
                        Delete It!
                    </a>
                    <button type="button" class="btn w-sm btn-primary mx-2" data-bs-dismiss="modal">Close</button>
                    <form id="user-delete-form" method="POST"
                        action="{{ route('product.delete', $product->id ?? '') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="productId" id="deleteid" value="">

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
    function editpassword(id) {
        $("#GetId").val(id);
    }

    function deleteData(id) {
        $("#deleteid").val(id);
    }
</script>
@endsection