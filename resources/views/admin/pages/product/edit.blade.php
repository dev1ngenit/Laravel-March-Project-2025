<x-admin-app-layout :title="'Product Edit'">
    <style>
        .nav-line-tabs .nav-item {
            margin-bottom: 2px;
            background: white;
            padding: 5px 10px;
            border: 1px solid #eee;
            border-radius: 0.8rem;
        }
    </style>
    <div id="kt_app_content_container" class="app-container container-xxl">
        <form id="kt_ecommerce_add_product_form" method="post" action="{{ route('admin.product.update', $product->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="gap-7 gap-lg-10 mb-7 col-lg-3">
                    {{-- Status Card Start --}}
                    <div class="card card-flush py-4 mb-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Status</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <x-metronic.select-option id="kt_ecommerce_add_product_status_select"
                                class="form-select mb-2" data-control="select2" data-hide-search="true" name="status"
                                data-placeholder="Select an option">
                                <option></option>
                                <option value="active" @selected($product->status == 'active')>Active</option>
                                <option value="draft" @selected($product->status == 'draft')>Draft</option>
                                <option value="inactive" @selected($product->status == 'inactive')>Inactive</option>
                            </x-metronic.select-option>
                            <div class="text-muted fs-7">Set the product status.</div>
                        </div>
                    </div>
                    {{-- Status Card End --}}
                    {{-- Category Card Start --}}
                    <div class="py-4 card card-flush">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Brand & Category</h2>
                            </div>
                        </div>
                        <div class="pt-0 card-body">
                            <div class="fv-row">
                                <x-metronic.label for="brand_id" class="col-form-label required fw-bold fs-6">
                                    {{ __('Select Brand') }}</x-metronic.label>
                                <x-metronic.select-option id="brand_id" class="mb-2 form-select" name="brand_id"
                                    data-control="select2" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                            <div class="fv-row">
                                <x-metronic.label for="category_id" class="col-form-label required fw-bold fs-6">
                                    {{ __('Select a Category') }}</x-metronic.label>
                                <x-metronic.select-option id="category_id" class="mb-2 form-select" name="category_id"
                                    data-control="select2" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($parentCategories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                            <div class="fv-row">
                                <x-metronic.label for="sub_category_id" class="col-form-label fw-bold fs-6">
                                    {{ __('Select a SubCategory') }}</x-metronic.label>
                                <x-metronic.select-option id="sub_category_id" class="mb-2 form-select"
                                    name="sub_category_id" data-control="select2" data-placeholder="Select an option"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach ($subCategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" @selected(old('sub_category_id', $product->sub_category_id) == $subcategory->id)>
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                            <div class="fv-row">
                                <x-metronic.label for="child_category_id" class="col-form-label fw-bold fs-6">
                                    {{ __('Select a Child Category') }}</x-metronic.label>
                                <x-metronic.select-option id="child_category_id" class="mb-2 form-select"
                                    name="child_category_id" data-control="select2" data-placeholder="Select an option"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach ($subCategories as $childcategory)
                                        <option value="{{ $childcategory->id }}" @selected(old('child_category_id', $product->child_category_id) == $childcategory->id)>
                                            {{ $childcategory->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                        </div>
                    </div>
                    {{-- Category Card End --}}
                </div>
                <div class="gap-7 gap-lg-10 col-lg-9">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_general">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_media">Media</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_advanced">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_price">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_meta">Meta Options</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-4">
                        @include('admin.pages.product.partials.edit_tabs')
                    </div>
                    <div class="d-flex justify-content-end mt-10">
                        <a href="{{ route('admin.product.index') }}" class="btn btn-danger me-5">
                            Back To Product List
                        </a>
                        {{-- <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label"> Save Changes </span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button> --}}
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label"> Save Changes </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @foreach ($product->images as $image)
        <div class="modal fade" id="multiimage_{{ $image->id }}" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0 border-0 shadow-sm">
                    <div class="modal-header p-2 rounded-0">
                        <h5 class="modal-title ps-5">
                            Image Update</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container px-0">
                            <div class="card border rounded-0">

                                <form action="{{ route('admin.multiimage.update', $image->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body p-1 px-2 mb-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <x-metronic.label for="multi_images"
                                                    class="col-form-label fw-bold fs-6 ">{{ __('Product Image') }}
                                                </x-metronic.label>
                                                <x-metronic.file-input name="photo" :source="asset('storage/' . $image->photo)"
                                                    :value="old('photo')"></x-metronic.file-input>
                                            </div>
                                            <div class="col-lg-2">
                                                <x-metronic.label for="product_color"
                                                    class="col-form-label fw-bold fs-6 required">{{ __('Color') }}
                                                </x-metronic.label>
                                                <input class="form-control form-control-lg" id="product_color"
                                                    style="height: 50px" type="color" name="color"
                                                    value="{{ old('color', $image->color) }}"
                                                    placeholder="Enter the Color">
                                            </div>
                                            <div class="col-md-4">
                                                <x-metronic.label for="color_name"
                                                    class="col-form-label fw-bold fs-6 required">{{ __('Color Name') }}
                                                </x-metronic.label>
                                                <x-metronic.input class="form-control form-control-lg" id="color_name"
                                                    type="text" name="color_name"
                                                    value="{{ old('color_name', $image->color_name) }}"
                                                    placeholder="Enter the Color Name"></x-metronic.input>
                                            </div>
                                            <div class="col-md-4">
                                                <x-metronic.label for="price"
                                                    class="col-form-label fw-bold fs-6 required">{{ __('Price') }}
                                                </x-metronic.label>
                                                <x-metronic.input class="form-control form-control-lg" id="color_price"
                                                    type="text" name="price"
                                                    value="{{ old('price', $image->price) }}"
                                                    placeholder="Enter the Color Name"></x-metronic.input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-3">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">
                                                <span class="indicator-label"> Update </span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            $('#productMediaColor').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // The DOM elements you wish to replace with Tagify
                var input1 = document.querySelector("#product_Tags");
                var input2 = document.querySelector("#product_meta_tags");
                var input3 = document.querySelector("#product_meta_keyword");
                var input4 = document.querySelector("#color");

                // Initialize Tagify components on the above inputs
                new Tagify(input1);
                new Tagify(input2);
                new Tagify(input4);
                new Tagify(input3);
            });



           
        </script>
    @endpush
</x-admin-app-layout>
