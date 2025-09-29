<div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        {{-- General Info --}}
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>General</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="mb-5 fv-row">
                    <x-metronic.label class="form-label">Product Name</x-metronic.label>
                    <x-metronic.input type="text" name="name" class="form-control mb-2"
                        placeholder="Product name recommended" :value="old('name', $product->name)">
                    </x-metronic.input>
                    <div class="text-muted fs-7">
                        A product name is and recommended to be unique.
                    </div>
                </div>
                <div class="mb-5 fv-row">
                    <x-metronic.label class="form-label">Tags</x-metronic.label>
                    <input class="form-control" name="tags" id="product_Tags"
                        value="{{ old('tags', $product->tags) }}" />
                </div>
                <div class="mb-5 fv-row">
                    <x-metronic.label class="form-label">Short Description</x-metronic.label>
                    <textarea name="short_description" class="ckeditor">{!! old('short_description', $product->short_description) !!}</textarea>
                    <div class="text-muted fs-7">
                        Add product long description here.
                    </div>
                </div>
                <div class="mb-5 fv-row">
                    <x-metronic.label class="form-label">Long Description</x-metronic.label>
                    <textarea name="long_description" class="ckeditor">{!! old('long_description', $product->long_description) !!}</textarea>
                    <div class="text-muted fs-7">
                        Add product long description here.
                    </div>
                </div>
                <div class="mb-5 fv-row">
                    <x-metronic.label class="form-label">Specification</x-metronic.label>
                    <textarea name="specification" class="ckeditor">{!! old('specification', $product->specification) !!}</textarea>
                    <div class="text-muted fs-7">
                        Add product long description here.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="kt_ecommerce_add_product_media" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        {{-- Inventory --}}
        <div class="py-4 mt-3 card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <h2>Media</h2>
                </div>
            </div>
            <div class="py-4 mt-3 card-body">
                <div class="row">
                    <div class="col-6">
                        <x-metronic.label for="" class="form-label">Primary Thumbnail
                            Image</x-metronic.label>
                        <x-metronic.file-input id="thumbnail_image" :source="asset('storage/' . $product->thumbnail_image)" name="thumbnail_image"
                            :value="old('thumbnail_image')"></x-metronic.file-input>
                        <div class="text-muted fs-7">
                            Set the product thumbnail image. Only *.webp, *.png,*.jpg and *.jpeg
                            image
                            files are accepted.
                        </div>
                    </div>
                    <div class="col-6">
                        <x-metronic.label for="" class="form-label">Secondary Thumbnail
                            Image</x-metronic.label>
                        <x-metronic.file-input id="thumbnail_image_2" :source="asset('storage/' . $product->thumbnail_image_2)" name="thumbnail_image_2"
                            :value="old('thumbnail_image_2')"></x-metronic.file-input>
                        <div class="text-muted fs-7">
                            Set the product thumbnail image. Only *.webp, *.png,*.jpg and *.jpeg
                            image
                            files are accepted.
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="p-5 mt-5" style="background-color: #eee">
                            <p>Product Multi image with Color Variation</p>
                            <!--begin::Repeater-->
                            <div id="productMediaColor">
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div data-repeater-list="productMediaColor">
                                        <div data-repeater-item>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <x-metronic.label for="multi_images"
                                                        class="col-form-label fw-bold fs-6 ">{{ __('Product Image') }}
                                                    </x-metronic.label>
                                                    <x-metronic.file-input id="multi_images" name="multi_images"
                                                        :value="old('multi_images')"></x-metronic.file-input>
                                                </div>
                                                <div class="col-md-2">
                                                    <x-metronic.label for="product_color"
                                                        class="col-form-label fw-bold fs-6 required">{{ __('Color') }}
                                                    </x-metronic.label>
                                                    <input class="form-control form-control-lg" id="product_color"
                                                        style="height: 50px" type="color" name="product_color"
                                                        value="{{ old('product_color') }}"
                                                        placeholder="Enter the Color">
                                                </div>
                                                <div class="col-md-3">
                                                    <x-metronic.label for="color_name"
                                                        class="col-form-label fw-bold fs-6 required">{{ __('Color Name') }}
                                                    </x-metronic.label>
                                                    <x-metronic.input class="form-control form-control-lg"
                                                        id="color_name" type="text" name="color_name"
                                                        value="{{ old('color_name') }}"
                                                        placeholder="Enter the Color Name"></x-metronic.input>
                                                </div>
                                                <div class="col-md-3">
                                                    <x-metronic.label for="color_name"
                                                        class="col-form-label fw-bold fs-6 required">{{ __('Price') }}
                                                    </x-metronic.label>
                                                    <x-metronic.input class="form-control form-control-lg"
                                                        id="color_price" type="text" name="color_price"
                                                        value="{{ old('color_price') }}"
                                                        placeholder="Enter the Color Name"></x-metronic.input>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="pt-2 mt-5 text-end">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="mt-5 btn btn-sm btn-danger mt-md-8">
                                                            <i class="fas fa-trash fs-5"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->

                                <!--begin::Form group-->
                                <div class="mt-5 form-group">
                                    <a href="javascript:;" data-repeater-create class="btn btn-primary">
                                        <i class="fas fa-plus fs-3"></i>
                                        Add
                                    </a>
                                </div>
                                <!--end::Form group-->
                            </div>
                            <!--end::Repeater-->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th width="30%">Image</th>
                                        <th width="20%">Color</th>
                                        <th width="20%">Color Name</th>
                                        <th width="20%">Price</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->images as $image)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . $image->photo) }}"
                                                    alt="{{ $image->photo }}" width="70px">
                                            </td>
                                            <td>
                                                <span class="p-3"
                                                    style="height:40px; background: {{ $image->color }};"></span>
                                            </td>
                                            <td>
                                                {{ $image->color_name }}
                                            </td>
                                            <td>
                                                {{ $image->price }}
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#multiimage_{{ $image->id }}" class="me-4">
                                                    <i class="text-primary fas fa-pencil-square fs-1"></i>
                                                </a>
                                                <a href="{{ route('admin.multiimage.destroy', $image->id) }}"
                                                    class="delete"><i
                                                        class="text-danger fas fa-trash-alt fs-1"></i></a>
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
    </div>
</div>
<div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        {{-- Inventory --}}
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Inventory</h2>
                </div>
            </div>
            <div class="pt-0 card-body row">
                <div class="mb-10 fv-row col-6">
                    <x-metronic.label class="form-label">SKU Code</x-metronic.label>
                    <x-metronic.input type="text" name="sku" class="mb-2 form-control"
                        placeholder="SKU Number" :value="old('sku', $product->sku)"></x-metronic.file-input>
                        <div class="text-muted fs-7">Enter the product SKU.</div>
                </div>
                <div class="mb-10 fv-row col-6">
                    <x-metronic.label class="form-label">MF Code</x-metronic.label>
                    <x-metronic.input type="text" name="mf_code" class="mb-2 form-control"
                        placeholder="MF Number" :value="old('mf_code', $product->mf_code)"></x-metronic.file-input>
                        <div class="text-muted fs-7">Enter the product MF.</div>
                </div>

                {{-- <div class="mb-10 fv-row col-12">
                    <x-metronic.label class="form-label">Barcode</x-metronic.label>
                    <x-metronic.input type="text" name="barcode_id" class="mb-2 form-control"
                        placeholder="Barcode Number" :value="old('barcode_id', $product->barcode_id)"></x-metronic.file-input>
                        <div class="text-muted fs-7">
                            Enter the product barcode number.
                        </div>
                </div> --}}
                <div class="mb-10 fv-row col-12">
                    <x-metronic.label for="accessories" class="col-form-label required fw-bold fs-6">
                        {{ __('Accessory Products') }}
                    </x-metronic.label>


                    @php
                        $selectedAccessories = old('accessories', $product->accessories ?? []);
                    @endphp

                    <x-metronic.select-option id="accessories" class="mb-2 form-control select" name="accessories[]"
                        multiple multiselect-search="true" multiselect-select-all="true" data-control="select2"
                        data-placeholder="Select an option" data-allow-clear="true">

                        <option></option>
                        @foreach ($products as $accessory)
                            <option value="{{ $accessory->id }}" @selected(in_array($accessory->id, $selectedAccessories))>
                                {{ $accessory->name }}
                            </option>
                        @endforeach
                    </x-metronic.select-option>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="kt_ecommerce_add_product_price" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        {{-- Pricing --}}
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Pricing</h2>
                </div>
            </div>
            <div class="pt-0 card-body row">
                <div class="mb-5 fv-row col-4">
                    <x-metronic.label class="form-label">Price</x-metronic.label>
                    <x-metronic.input type="number" name="price" id="price" class="mb-2 form-control"
                        placeholder="how much the unit price" :value="old('price', $product->price)"></x-metronic.file-input>
                        <div class="text-muted fs-7">How much unit price.</div>
                </div>
                <div class="mb-5 fv-row col-4">
                    <x-metronic.label class="form-label">Partner Price</x-metronic.label>
                    <x-metronic.input type="number" name="partner_price" id="partner_price"
                        class="mb-2 form-control" placeholder="how much the partner price"
                        :value="old('partner_price', $product->partner_price)"></x-metronic.file-input>
                        <div class="text-muted fs-7">How much partner price.</div>
                </div>
                <div class="mb-5 fv-row col-4">
                    <x-metronic.label class="form-label">Discounted Price</x-metronic.label>
                    <x-metronic.input type="number" name="discount_price" id="unit_discount"
                        class="mb-2 form-control" placeholder="how much the unit discount price"
                        :value="old('discount_price', $product->discount_price)"></x-metronic.file-input>
                        <div class="text-muted fs-7">How much unit discount price.</div>
                </div>
                <div class="mb-5 fv-row col-4">
                    <x-metronic.label class="form-label">Stock</x-metronic.label>
                    <x-metronic.input type="number" name="qty" id="qty" class="mb-2 form-control"
                        placeholder="how much the qty" :value="old('qty', $product->qty)">
                        </x-metronic.file-input>
                        <div class="text-muted fs-7">How much stock. Eg: 50</div>
                </div>
                <div class="mb-5 fv-row col-4">
                    <x-metronic.label class="form-label">Vat</x-metronic.label>
                    <x-metronic.input type="number" name="vat" id="vat" class="mb-2 form-control"
                        placeholder="how much the vat" :value="old('vat', $product->vat)"></x-metronic.file-input>
                        <div class="text-muted fs-7">How much vat. Eg: 5%</div>
                </div>
                <div class="mb-5 fv-row col-4">
                    <x-metronic.label class="form-label">Tax</x-metronic.label>
                    <x-metronic.input type="number" name="tax" id="tax" class="mb-2 form-control"
                        placeholder="how much the tax " :value="old('tax', $product->tax)"></x-metronic.file-input>
                        <div class="text-muted fs-7">How much tax Eg: 5%</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="kt_ecommerce_add_product_meta" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        {{-- Meta Options --}}
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Meta Options</h2>
                </div>
            </div>
            {{-- @dd($product->meta_title) --}}
            <div class="card-body pt-0">
                <div class="mb-10">
                    <div class="mb-5 fv-row">
                        <x-metronic.label class="form-label">Product Meta
                            Title</x-metronic.label>
                        <x-metronic.input class="form-control" type="text" name="meta_title"
                            placeholder="Meta Title" :value="old('meta_title', $product->meta_title)"></x-metronic.input>
                    </div>
                    <div class="text-muted fs-7">
                        Add Product Meta Title.
                    </div>
                </div>
                <div class="mb-10">
                    <div class="mb-5 fv-row">
                        <x-metronic.label class="form-label">Meta
                            Description (150 words)</x-metronic.label>
                        <textarea name="meta_description" class="form-control">{!! old('meta_description', $product->meta_description) !!}</textarea>
                        <div class="text-muted fs-7">
                            Add Meta Meta details.
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mb-5 fv-row">
                        <x-metronic.label class="form-label">Meta Tag
                            Keywords</x-metronic.label>
                        <input class="form-control" name="meta_keywords" placeholder="Meta tag keywords"
                            id="product_meta_keyword" value="{{ old('meta_keywords', $product->meta_keywords) }}" />
                        <div class="text-muted fs-7">
                            Add product Meta tag keywords.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
