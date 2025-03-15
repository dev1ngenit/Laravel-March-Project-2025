<style>
    @media only screen and (max-width: 600px) {
        .wish-ammount {
            line-height: 1.2;
            right: 65px;
            border-radius: 16.13px;
            background: #fff;
            display: flex;
            width: 20px;
            padding: 4px 4px 2px 5px;
            justify-content: center;
            align-items: end;
            position: absolute;
            top: 30px;
            height: 20px;
        }
    }
</style>
<div class="desktop-homepage">
    <div id="kt_header" class="header align-items-stretch">
        <div class="container-fluid d-flex align-items-stretch justify-content-between">
            <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                    id="kt_aside_mobile_toggle">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                fill="currentColor" />
                            <path opacity="0.3"
                                d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                <a href="/" class="d-lg-none">
                    {{-- <img alt="Logo" src="{{ asset('admin/assets/media/logos/logo-2.svg') }}" class="h-30px" /> --}}
                </a>
            </div>
            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                <div class="d-flex align-items-stretch" id="kt_header_nav">
                </div>
                <div class="flex-shrink-0 d-flex align-items-stretch">
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <a class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                            href="/">
                            <i class="fonticon-sun fs-2"></i>
                        </a>
                    </div>

                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <img src="{{ asset('admin/assets/media/avatars/300-1.jpg') }}" alt="user" />
                        </div>
                        <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold fs-6 w-275px"
                            data-kt-menu="true">
                            <div class="px-3 menu-item">
                                <div class="px-3 menu-content d-flex align-items-center">
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="{{ asset('admin/assets/media/avatars/300-1.jpg') }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder d-flex align-items-center fs-5">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <a href="#" class="fw-bold text-muted text-hover-primary fs-7">
                                            {{ Auth::user()->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="my-2 separator"></div>
                            <div class="px-5 menu-item">
                                <a href="{{ route('profile.edit') }}" class="px-5 menu-link">My
                                    Profile</a>
                            </div>
                            <div class="px-5 my-1 menu-item">
                                <a href="../../demo1/dist/account/settings.html" class="px-5 menu-link">Account
                                    Settings</a>
                            </div>

                            <div class="px-5 menu-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                        class="px-5 menu-link"> {{ __('Sign Out') }}</a>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
