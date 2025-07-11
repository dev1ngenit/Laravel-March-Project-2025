<x-admin-app-layout :title="'Product Add'">
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
        <form id="kt_ecommerce_add_product_form" method="post" action="{{ route('admin.product.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="gap-7 gap-lg-10 col-9">
                    <ul class="border-0 nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="pb-2 nav-link text-active-primary active" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_general">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="pb-2 nav-link text-active-primary" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_media">Media</a>
                        </li>
                        <li class="nav-item">
                            <a class="pb-2 nav-link text-active-primary" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_advanced">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="pb-2 nav-link text-active-primary" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_price">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="pb-2 nav-link text-active-primary" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_meta">Meta Options</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-4">
                        @include('admin.pages.product.partials.create_tabs')
                    </div>
                    <div class="mt-10 d-flex justify-content-end">
                        <a href="{{ route('admin.product.index') }}" class="btn btn-danger me-5">
                            Back To Product List
                        </a>
                        {{-- <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label"> Save Changes </span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="align-middle spinner-border spinner-border-sm ms-2"></span>
                            </span>
                        </button> --}}
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label"> Save Changes </span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="gap-7 gap-lg-10 mb-7 col-3">
                    {{-- Status Card Start --}}
                    <div class="py-4 mb-6 card card-flush">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Status</h2>
                            </div>
                        </div>
                        <div class="pt-0 card-body">
                            <x-metronic.select-option id="kt_ecommerce_add_product_status_select"
                                class="mb-2 form-select" data-control="select2" data-hide-search="true"
                                name="status" data-placeholder="Select an option">
                                <option></option>
                                <option value="draft">Draft</option>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
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
                                    data-control="select2" data-placeholder="Select an option"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                            <div class="fv-row">
                                <x-metronic.label for="category_id" class="col-form-label required fw-bold fs-6">
                                    {{ __('Select a Category') }}</x-metronic.label>
                                <x-metronic.select-option id="category_id" class="mb-2 form-select"
                                    name="category_id" data-control="select2" data-placeholder="Select an option"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach ($parentCategories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}
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
                                        <option value="{{ $subcategory->id }}" @selected(old('sub_category_id') == $subcategory->id)>{{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                            <div class="fv-row">
                                <x-metronic.label for="child_category_id" class="col-form-label fw-bold fs-6">
                                    {{ __('Select a Child Category') }}</x-metronic.label>
                                <x-metronic.select-option id="child_category_id" class="mb-2 form-select"
                                    name="child_category_id" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($subCategories as $childcategory)
                                        <option value="{{ $childcategory->id }}" @selected(old('child_category_id') == $childcategory->id)>{{ $childcategory->name }}
                                        </option>
                                    @endforeach
                                </x-metronic.select-option>
                            </div>
                        </div>
                    </div>
                    {{-- Category Card End --}}
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
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
                new Tagify(input3);
                new Tagify(input4);
            });



            // Product dimension box
            document.addEventListener('DOMContentLoaded', function() {
                const lengthInput = document.getElementById('length');
                const widthInput = document.getElementById('width');
                const heightInput = document.getElementById('height');
                const weightInput = document.getElementById('weight');

                const dimensionPreview = document.getElementById('dimensionPreview');

                function updatePreview() {
                    const length = lengthInput.value || 0;
                    const width = widthInput.value || 0;
                    const height = heightInput.value || 0;
                    const weight = weightInput.value || 0;

                    dimensionPreview.textContent =
                        `${length} cm X ${width} cm X ${height} cm X ${weight} gm`;
                }

                // Attach the event listener to each input field
                lengthInput.addEventListener('input', updatePreview);
                widthInput.addEventListener('input', updatePreview);
                heightInput.addEventListener('input', updatePreview);
                weightInput.addEventListener('input', updatePreview);
            });

            // Define color mapping
            var colorMapping = {
                'Red': '#FF5733',
                'Green': '#33FF57',
                'Blue': '#3357FF',
                'Yellow': '#FFFF33',
                'Purple': '#A933FF',
                'Orange': '#FF8C33',
                'Pink': '#FF33B5',
                'Brown': '#8C4C33',
                'Gray': '#BEBEBE',
                'Black': '#000000',
                'White': '#FFFFFF',
                'Cyan': '#00FFFF',
                'Magenta': '#FF00FF',
                'Lime': '#00FF00',
                'Teal': '#008080',
                'Olive': '#808000',
                'Navy': '#000080',
                'Maroon': '#800000',
                'Silver': '#C0C0C0',
                'Gold': '#FFD700',
                'Coral': '#FF7F50',
                'Indigo': '#4B0082',
                'Turquoise': '#40E0D0',
                'Salmon': '#FA8072'
            };

            // Convert colorMapping to an array of objects for Tagify dropdown
            var colorArray = Object.keys(colorMapping).map(key => ({
                value: key,
                color: colorMapping[key]
            }));

            // Initialize Tagify on the input element
            var tagify = new Tagify(document.querySelector('#kt_tagify_color'), {
                delimiters: null,
                templates: {
                    tag: function(tagData) {
                        const color = colorMapping[tagData.value] || '#cccccc'; // Default color if not found
                        try {
                            return `<tag title='${tagData.value}' contenteditable='false' spellcheck="false"
                    class='tagify__tag ${tagData.class ? tagData.class : ""}' ${this.getAttributes(tagData)}
                    style="background-color: ${color}; border: none; display: flex; align-items: center; padding: 0;">
                        <x title='remove tag' class='tagify__tag__removeBtn'></x>
                        <div class="d-flex align-items-center" style="width: 25px; height: 25px; background-color: ${color}; border-radius: 4px; margin-right: 8px;"></div>
                        <span class='tagify__tag-text'>${tagData.value}</span>
                    </tag>`;
                        } catch (err) {
                            console.error('Error in tag template:', err);
                        }
                    },

                    dropdownItem: function(tagData) {
                        const color = colorMapping[tagData.value] || '#cccccc'; // Default color if not found
                        try {
                            return `<div ${this.getAttributes(tagData)} class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                    style="background-color: white; color: black; display: flex; align-items: center; padding: 4px 8px;">
                        <div style="width: 25px; height: 25px; background-color: ${color}; border-radius: 4px; margin-right: 8px;"></div>
                        <span>${tagData.value}</span>
                    </div>`;
                        } catch (err) {
                            console.error('Error in dropdown item template:', err);
                        }
                    }
                },
                // Remove whitelist to allow all colors to be shown in dropdown
                enforceWhitelist: false,
                // Display dropdown items based on the colorMapping array
                whitelist: colorArray,
                dropdown: {
                    enabled: 1, // Show the dropdown as the user types
                    classname: 'extra-properties' // Custom class for the suggestions dropdown
                }
            });

            // Show all color options when the input is clicked
            var inputElement = document.querySelector('#kt_tagify_color');

            inputElement.addEventListener('click', function() {
                tagify.dropdown.show.call(tagify);
            });

            // Add the first 2 tags and make them readonly
            // var tagsToAdd = tagify.settings.whitelist.slice(0, 2);
            // tagify.addTags(tagsToAdd);



            // Product Pricing
            function calculatePrices() {
                const boxContains = parseFloat(document.getElementById('box_contains').value) || 0;
                const boxPrice = parseFloat(document.getElementById('box_price').value) || 0;
                const boxDiscountPrice = parseFloat(document.getElementById('box_discount_price').value) || 0;

                const unitPrice = boxContains ? (boxPrice / boxContains).toFixed(2) : 0;
                const unitDiscount = boxContains ? (boxDiscountPrice / boxContains).toFixed(2) : 0;

                document.getElementById('unit_price').value = unitPrice;
                document.getElementById('unit_discount').value = unitDiscount;
            }

            document.getElementById('box_contains').addEventListener('input', calculatePrices);
            document.getElementById('box_price').addEventListener('input', calculatePrices);
            document.getElementById('box_discount_price').addEventListener('input', calculatePrices);

            // Product Multiimage Submit
            var uploadedDocumentMap = {}; // Assuming you have this variable defined somewhere

            var myDropzone = new Dropzone("#product_multiimage", {
                url: "{{ route('admin.product.store') }}",
                paramName: "multi_image", // The name that will be used to transfer the file
                uploadMultiple: true,
                parallelUploads: 10,
                maxFiles: 10,
                maxFilesize: 10, // MB
                addRemoveLinks: true,
                accept: function(file, done) {
                    console.log(file);
                    $('#kt_ecommerce_add_product_form').append(
                        '<input type="hidden" name="document[ value="{{ old('document') }}"]" value="' + file
                        .file + '">');
                    done();
                },
                method: "post",
            });

            document.getElementById('kt_ecommerce_add_product_form').addEventListener('submit', function(event) {
                var formData = new FormData(this);
                console.log(formData);
            });
            // textEditor
            class CKEditorInitializer {
                constructor(className) {
                    this.className = className;
                }

                initialize() {
                    const elements = document.querySelectorAll(this.className);
                    elements.forEach(element => {
                        ClassicEditor
                            .create(element)
                            .then(editor => {
                                console.log('CKEditor initialized:', editor);
                            })
                            .catch(error => {
                                console.error('CKEditor initialization error:', error);
                            });
                    });
                }
            }

            // Example usage:
            const ckEditorInitializer = new CKEditorInitializer('.ckeditor');
            ckEditorInitializer.initialize();
        </script>
        {{-- Product Media Form Repeater --}}
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
    @endpush
</x-admin-app-layout>
