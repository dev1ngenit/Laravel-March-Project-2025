<x-admin-app-layout :title="'Category List'">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container-xxl">
            <!--begin::Category-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                        <!--begin::Add product-->
                        {{-- @if (Auth::guard('admin')->user()->can('add.category')) --}}
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-light-primary">Add Category</a>
                        {{-- @endif --}}
                        <!--end::Add product-->

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_datatable_example_5"
                            class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                            <thead class="bg-dark text-light">
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">

                                    <th class="min-w-10px">{{ __('category.Sl') }}</th>
                                    <th class="min-w-150px">{{ __('category.Name') }}</th>
                                    <th class="min-w-150px">{{ __('category.Slug') }}</th>
                                    <th class="min-w-150px">{{ __('category.Status') }}</th>
                                    <th class="min-w-150px">{{ __('category.Parent') }}</th>
                                    <th class="min-w-70px">{{ __('category.Action') }}</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                                @forelse ($categories as $category)
                                    <!--begin::Table row-->
                                    <tr>

                                        <!--end::Checkbox-->
                                        <td>
                                            <!--begin::Sl-->
                                            <span class="fw-bolder"> {{ $loop->iteration }}</span>
                                            <!--end::Sl-->
                                        </td>
                                        <td>
                                            <!--begin::Sl-->
                                            <span class="fw-bolder"> {{ $category->name }}</span>
                                            <!--end::Sl-->
                                        </td>
                                        <td>
                                            <!--begin::Sl-->
                                            <span class="fw-bolder"> {{ $category->slug }}</span>
                                            <!--end::Sl-->
                                        </td>
                                        <td>
                                            <!--begin::Status-->
                                            <div
                                                class="badge {{ $category->status == 'active' ? 'badge-light-success' : 'badge-light-danger' }}">
                                                {{ $category->status == 'active' ? 'Active' : 'InActive' }}
                                            </div>
                                            <!--end::Status-->
                                        </td>
                                        <td>
                                            <!--begin::Sl-->
                                            <span class="fw-bolder">
                                                {{ $category->parent_id ? $category->parent->name : 'N/A' }}</span>
                                            <!--end::Sl-->
                                        </td>

                                        <!--begin::Action=-->
                                        {{-- <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon--></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">


                                                <!--begin::Menu item-->
                                                @if (Auth::guard('admin')->user()->can('show.category'))
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.categories.show', $category->id) }}"
                                                            class="menu-link px-3">Show</a>
                                                    </div>
                                                @endif
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                @if (Auth::guard('admin')->user()->can('edit.category'))
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                            class="menu-link px-3">Edit</a>
                                                    </div>
                                                @endif
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                @if (Auth::guard('admin')->user()->can('delete.category'))
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.categories.destroy', $category->id) }}"
                                                            class="menu-link px-3 delete">Delete</a>
                                                    </div>
                                                @endif
                                                <!--end::Menu item-->

                                            </div>
                                            <!--end::Menu-->
                                        </td> --}}

                                        <td>
                                            <!--begin::Menu item-->
                                            {{-- @if (Auth::guard('admin')->user()->can('show.category')) --}}

                                            <a href="{{ route('admin.categories.show', $category->id) }}"
                                                class="menu-link"><i
                                                    class="fa-solid fa-eye text-success me-1 fs-4"></i></a>

                                            {{-- @endif --}}
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            {{-- @if (Auth::guard('admin')->user()->can('edit.category')) --}}

                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="menu-link"><i
                                                    class="fa-solid fa-edit text-primary me-1 fs-4"></i></a>

                                            {{-- @endif --}}
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            {{-- @if (Auth::guard('admin')->user()->can('delete.category')) --}}

                                            <a href="{{ route('admin.categories.destroy', $category->id) }}"
                                                class="menu-link delete"><i
                                                    class="fa-solid fa-trash text-danger fs-4"></i></a>

                                            {{-- @endif --}}
                                            <!--end::Menu item-->
                                        </td>


                                        <!--end::Action=-->

                                    </tr>
                                    <!--end::Table row-->
                                    @foreach ($category->children as $child)
                                        <tr>

                                            <td>
                                                <!--begin::Sl-->
                                                <span class="fw-bolder">
                                                    {{ $loop->parent->iteration }}.{{ $loop->iteration }}</span>
                                                <!--end::Sl-->
                                            </td>
                                            <td>
                                                <!--begin::Sl-->
                                                <span class="fw-bolder"> -- {{ $child->name }}</span>
                                                <!--end::Sl-->
                                            </td>
                                            <td>
                                                <!--begin::Sl-->
                                                <span class="fw-bolder"> {{ $child->slug }}</span>
                                                <!--end::Sl-->
                                            </td>
                                            <td>
                                                <!--begin::Status-->
                                                <div
                                                    class="badge {{ $child->status == 1 ? 'badge-light-success' : 'badge-light-danger' }}">
                                                    {{ $child->status == 1 ? 'Active' : 'InActive' }}
                                                </div>
                                                <!--end::Status-->
                                            </td>
                                            <td>
                                                <!--begin::Sl-->
                                                <span class="fw-bolder">
                                                    {{ $child->parent->name ?? 'N/A' }}
                                                    <!--end::Sl-->
                                            </td>

                                            <!--begin::Action=-->
                                            {{-- <td class="text-end">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                    data-kt-menu-trigger="click"
                                                    data-kt-menu-placement="bottom-end">Actions
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon--></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                    data-kt-menu="true">

                                                    @if (Auth::guard('admin')->user()->can('show.category'))
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.categories.show', $child->id) }}"
                                                                class="menu-link px-3">Show</a>
                                                        </div>
                                                    @endif
                                                    <!--end::Menu item-->

                                                    @if (Auth::guard('admin')->user()->can('show.category'))
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.categories.edit', $child->id) }}"
                                                                class="menu-link px-3">Edit</a>
                                                        </div>
                                                    @endif
                                                    <!--end::Menu item-->

                                                    @if (Auth::guard('admin')->user()->can('show.category'))
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.categories.destroy', $child->id) }}"
                                                                class="menu-link px-3 delete">Delete</a>
                                                        </div>
                                                    @endif
                                                    <!--end::Menu item-->

                                                </div>
                                                <!--end::Menu-->
                                            </td> --}}

                                            <td>

                                                {{-- @if (Auth::guard('admin')->user()->can('show.category')) --}}
                                                <!--begin::Menu item-->

                                                <a href="{{ route('admin.categories.show', $child->id) }}"
                                                    class="menu-link"><i
                                                        class="fa-solid fa-eye text-success me-1 fs-4"></i></a>

                                                {{-- @endif --}}
                                                <!--end::Menu item-->

                                                {{-- @if (Auth::guard('admin')->user()->can('show.category')) --}}

                                                <a href="{{ route('admin.categories.edit', $child->id) }}"
                                                    class="menu-link"><i
                                                        class="fa-solid fa-edit text-primary me-1 fs-4"></i></a>

                                                {{-- @endif --}}
                                                <!--end::Menu item-->

                                                {{-- @if (Auth::guard('admin')->user()->can('show.category')) --}}

                                                <a href="{{ route('admin.categories.destroy', $child->id) }}"
                                                    class="menu-link delete"><i
                                                        class="fa-solid fa-trash text-danger fs-4"></i></a>

                                                {{-- @endif --}}
                                                <!--end::Action=-->
                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Category-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $("#kt_datatable_example_5").DataTable({
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom": "<'row'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                        ">" +
                        "<'table-responsive'tr>" +
                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">",
                });

                // Rebind the action buttons after table is redrawn (pagination, sorting, etc.)
                table.on('draw', function() {
                    // Bind actions for newly drawn table rows
                    $(".btn-light").on("click", function() {
                        // Your action button click logic here, for example:
                        // console.log('Button clicked!');
                    });
                });
            });
        </script>
    @endpush
</x-admin-app-layout>
