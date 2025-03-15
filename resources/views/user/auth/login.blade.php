<x-frontend-app-layout :title="'All Brands || NewSite'">
    <style>
        .register-img {
            width: 100%;
            height: 600px;
            object-fit: cover;
        }
    </style>
    <div class="container py-5 desktop-homepage">
        <div class="py-5 row">
            <div class="col-lg-10 offset-lg-1">
                <div class="border-0 card">
                    <div class="p-0 border-0 shadow-sm card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2">
                                        <h2 class="mb-5 fw-bold">Log In</h2>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <!-- 2 column grid layout with text inputs for the first and last names -->
                                            <div class="mb-4 row">
                                                <div class="form-outline">
                                                    <x-input-label class="form-label" for="email"
                                                        :value="__('Email')" />
                                                    <x-text-input id="email" class="form-control form-control-solid"
                                                        type="email" name="email" :value="old('email')" required
                                                        autocomplete="username" />
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="form-outline">
                                                    <x-input-label class="form-label" for="password"
                                                        :value="__('Password')" />

                                                    <x-text-input id="password" class="form-control form-control-solid"
                                                        type="password" name="password" required
                                                        autocomplete="new-password" />
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                </div>
                                            </div>

                                            <!-- Checkbox -->
                                            <div class="row justify-content-between align-items-center">
                                                <div
                                                    class="mb-3 form-check d-flex justify-content-center align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" value=""
                                                        id="remember_me" name="remember" />
                                                    <label class="form-check-label" for="remember_me">
                                                        {{ __('Remember me') }}
                                                    </label>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <div
                                                        class="mb-3 form-check d-flex justify-content-center align-items-center">
                                                        <h6 class="d-flex justify-content-center align-items-center">
                                                            {{ __('Forgot your password?') }}
                                                            <a href="{{ route('password.request') }}"
                                                                class="btn btn-sm btn-link text-gray fw-bold fs-6">{{ __('Click Here...') }}</a>
                                                        </h6>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Submit button -->
                                            <div class="mx-auto">
                                                <button type="submit" class="mb-4 btn btn-common-one rounded-pill"
                                                    style="width: 100% !important;">Log in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5 col-lg-6 mb-lg-0">
                                <img class="img-fluid register-img" src="{{ asset('images/login-img.png') }}"
                                    class="w-100 rounded-4 shadow-4" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-homepage parent-container">
        <div class="mobile-login-box">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="119" viewBox="0 0 120 119"
                                fill="none">
                                <path
                                    d="M109.935 78.9083C113.702 72.949 115.825 66.2253 115.825 59.1078C115.825 34.6418 90.7747 14.8081 59.8728 14.8081C51.7728 14.8081 44.0747 16.1707 37.1246 18.6225C30.5352 21.1671 24.3589 24.6734 18.7967 29.0274C13.1246 34.4241 3.92041 45.2766 3.92041 59.1078C3.92041 83.5737 28.9711 103.408 59.873 103.408C74.1336 103.408 87.1454 99.1813 97.0271 92.2276L100.014 93.9505L109.94 99.6774L109.936 88.2177L109.935 78.9083Z"
                                    fill="#F15A2D" />
                                <path
                                    d="M28.6057 24.9413C29.7471 24.3312 30.1779 22.9116 29.568 21.7702C28.9579 20.6288 27.5383 20.198 26.3969 20.8078C25.2555 21.4177 24.8247 22.8375 25.4346 23.9789C26.0447 25.1203 27.4643 25.5511 28.6057 24.9413Z"
                                    fill="#252525" />
                                <path
                                    d="M100.895 25.9418C89.914 17.2477 75.3452 12.4596 59.873 12.4596C51.6874 12.4596 43.7709 13.7878 36.3436 16.4077C35.1204 16.8389 34.4786 18.1805 34.9101 19.4034C35.3416 20.6264 36.6832 21.2681 37.9059 20.8369C44.8301 18.3945 52.2211 17.1563 59.8732 17.1563C89.4307 17.1563 113.477 35.9756 113.477 59.1075C113.477 65.6119 111.618 71.8517 107.95 77.6532C107.712 78.0288 107.586 78.4641 107.586 78.9085L107.59 95.6101L98.2006 90.193C97.8127 89.9692 97.3689 89.861 96.9215 89.8811C96.4742 89.9013 96.0419 90.0489 95.6757 90.3066C85.823 97.2402 73.1079 101.059 59.8732 101.059C30.3157 101.059 6.26901 82.2392 6.26901 59.1073C6.26901 48.6146 11.2605 38.5657 20.3238 30.8114C21.3093 29.9681 21.4247 28.4857 20.5816 27.5004C19.7386 26.5151 18.2561 26.3993 17.2706 27.2426C7.14698 35.9039 1.5719 47.2203 1.5719 59.1075C1.5719 71.6729 7.70831 83.4514 18.8507 92.2733C29.8319 100.967 44.4005 105.755 59.873 105.755C73.5183 105.755 86.685 101.945 97.133 94.9995L108.766 101.711C109.123 101.917 109.528 102.025 109.94 102.025C110.353 102.025 110.757 101.916 111.114 101.71C111.471 101.504 111.768 101.208 111.974 100.85C112.18 100.493 112.288 100.088 112.288 99.6762L112.283 79.5781C116.193 73.1783 118.174 66.2951 118.174 59.1073C118.174 46.5424 112.037 34.7639 100.895 25.9418Z"
                                    fill="#252525" />
                                <path
                                    d="M100.996 72.4923C102.325 72.4923 103.403 71.4149 103.403 70.0859C103.403 68.7569 102.325 67.6796 100.996 67.6796C99.6672 67.6796 98.5898 68.7569 98.5898 70.0859C98.5898 71.4149 99.6672 72.4923 100.996 72.4923Z"
                                    fill="#252525" />
                                <path
                                    d="M26.0185 50.6961V56.7371H18.692V50.6961C18.692 49.3993 17.6406 48.3479 16.3438 48.3479C15.047 48.3479 13.9955 49.3993 13.9955 50.6961V68.0703C13.9955 69.3671 15.047 70.4185 16.3438 70.4185C17.6406 70.4185 18.692 69.3671 18.692 68.0703V61.4337H26.0185V68.0705C26.0185 69.3673 27.0699 70.4187 28.3667 70.4187C29.6635 70.4187 30.7149 69.3673 30.7149 68.0705V50.6963C30.7149 49.3995 29.6635 48.3481 28.3667 48.3481C27.0699 48.3481 26.0185 49.3993 26.0185 50.6961ZM36.7042 70.4187H44.0249C45.3219 70.4187 46.3731 69.3673 46.3731 68.0705C46.3731 66.7737 45.3217 65.7223 44.0249 65.7223H39.0524V61.7318H43.4851C44.7821 61.7318 45.8333 60.6804 45.8333 59.3836C45.8333 58.0868 44.7819 57.0354 43.4851 57.0354H39.0524V53.045H44.0249C45.3219 53.045 46.3731 51.9936 46.3731 50.6968C46.3731 49.4 45.3217 48.3486 44.0249 48.3486H36.7042C35.4071 48.3486 34.356 49.4 34.356 50.6968V68.071C34.356 69.3673 35.4074 70.4187 36.7042 70.4187ZM51.8633 47.7968C50.5663 47.7968 49.5151 48.8483 49.5151 50.145V67.5047C49.5151 68.6492 50.3401 69.6268 51.4679 69.8197C51.6343 69.848 55.9867 69.8307 57.9604 69.8197C59.2574 69.8124 60.3029 68.7887 60.2954 67.4919C60.2884 66.1993 59.2384 65.1565 57.9475 65.1565H57.9341C56.799 65.1629 55.3801 65.1687 54.2118 65.1706V50.1453C54.2115 48.8482 53.1601 47.7968 51.8633 47.7968ZM65.0174 47.7968C63.7206 47.7968 62.6692 48.8483 62.6692 50.145V67.5047C62.6692 68.059 62.8652 68.5955 63.2227 69.0191C63.5801 69.4428 64.0759 69.7263 64.6222 69.8197C64.7886 69.848 69.141 69.8307 71.1144 69.8197C72.4112 69.8124 73.4568 68.7887 73.4497 67.4919C73.4425 66.1993 72.3925 65.1565 71.1018 65.1565H71.0884C69.9533 65.1629 68.5344 65.1687 67.3661 65.1706V50.1453C67.3656 48.8482 66.3142 47.7968 65.0174 47.7968ZM84.2797 70.4187C90.3648 70.4187 95.3153 65.4683 95.3153 59.3832C95.3153 53.2981 90.3648 48.3476 84.2797 48.3476C78.1947 48.3476 73.2442 53.2981 73.2442 59.3832C73.2442 65.4683 78.1947 70.4187 84.2797 70.4187ZM84.2797 53.0445C87.775 53.0445 90.6187 55.8882 90.6187 59.3834C90.6187 62.8787 87.775 65.7223 84.2797 65.7223C80.7845 65.7223 77.9408 62.8787 77.9408 59.3834C77.9408 55.8882 80.7845 53.0445 84.2797 53.0445ZM100.996 64.7445C102.293 64.7445 103.344 63.6931 103.344 62.3963V49.3123C103.344 48.0155 102.293 46.9641 100.996 46.9641C99.6993 46.9641 98.6479 48.0155 98.6479 49.3123V62.3963C98.6479 63.6931 99.6993 64.7445 100.996 64.7445ZM103.005 14.4825C103.418 14.8072 103.928 14.9836 104.453 14.9831C104.809 14.9837 105.161 14.903 105.481 14.7472C105.802 14.5914 106.082 14.3646 106.302 14.0841L108.636 11.108C109.437 10.0875 109.259 8.61118 108.238 7.81103C107.217 7.01017 105.741 7.18876 104.941 8.20946L102.607 11.1856C101.807 12.206 101.985 13.6821 103.005 14.4825ZM89.0165 8.41782C89.1287 8.43376 89.2403 8.4415 89.3507 8.4415C90.5008 8.4415 91.5058 7.59563 91.6726 6.42399L92.2061 2.67962C92.3889 1.39571 91.4964 0.206488 90.2123 0.0234412C88.9291 -0.157965 87.7391 0.733129 87.5561 2.01727L87.0226 5.76165C86.8398 7.04579 87.7326 8.23478 89.0165 8.41782ZM119.847 23.7495C119.388 22.5366 118.033 21.9258 116.819 22.3852L113.282 23.7249C112.069 24.1842 111.459 25.5401 111.918 26.7528C112.087 27.1987 112.387 27.5827 112.78 27.8537C113.172 28.1248 113.638 28.27 114.115 28.2701C114.391 28.2701 114.672 28.2209 114.946 28.1171L118.483 26.7774C119.696 26.318 120.306 24.9621 119.847 23.7495ZM16.9944 104.475C15.9739 103.674 14.4978 103.853 13.6974 104.874L11.3633 107.85C10.5629 108.87 10.7412 110.347 11.7617 111.147C12.1744 111.472 12.6843 111.648 13.2095 111.647C13.906 111.647 14.5955 111.339 15.0589 110.748L17.3931 107.772C18.1932 106.752 18.0148 105.276 16.9944 104.475ZM30.9835 110.54C29.6999 110.36 28.5104 111.249 28.3274 112.534L27.7939 116.278C27.6109 117.562 28.5034 118.751 29.7875 118.934C29.8998 118.95 30.0113 118.958 30.1217 118.958C31.2718 118.958 32.2766 118.112 32.4435 116.941L32.9769 113.196C33.1602 111.912 32.2674 110.723 30.9835 110.54ZM5.05414 90.8408L1.51718 92.1805C0.304288 92.6398 -0.306494 93.9955 0.152881 95.2084C0.321761 95.6543 0.622348 96.0383 1.0147 96.3093C1.40705 96.5804 1.87259 96.7256 2.34945 96.7257C2.62577 96.7257 2.90702 96.6765 3.18077 96.5727L6.71773 95.233C7.93062 94.7736 8.5414 93.418 8.08203 92.2051C7.62242 90.9922 6.26703 90.3819 5.05414 90.8408Z"
                                    fill="#eee" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="pt-4 text-center">
                            <h1>Welcome Back</h1>
                            <p class="pt-3">Sign in to access your account</p>
                        </div>

                        <div class="p-5 px-4">

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Submit button -->
                                <div class="icon-parent-cnt" style="margin-bottom: 25px">
                                    <input type="email" class="border-0 form-control"
                                        placeholder="Enter your email....">
                                    <span class="icons-mobile-login">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                                                stroke="black" stroke-opacity="0.3" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M22 6L12 13L2 6" stroke="black" stroke-opacity="0.3"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- Password Field -->
                                    <input type="password" id="password-field" class="form-control"
                                        placeholder="Password">

                                    <!-- Toggle Button with Lock Icon -->
                                    <button type="button" id="toggle-password" class="px-0 btn lock-mobile-re">
                                        <i class="px-3 fa-solid fa-lock site-text" id="lockIcon"></i>
                                    </button>
                                </div>
                                <div class="d-flex justify-content-between align-items-center"
                                    style="padding-top: 15px;padding-bottom: 30px">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label mfs" for="exampleCheck1">Check me out</label>
                                    </div>
                                    <div>
                                        <a href="{{ route('password.request') }}" class="site-text mfs">Forgot
                                            password?</a>
                                    </div>
                                </div>

                                <x-primary-button class="mb-4 btn btn-common-one rounded-pill w-100">
                                    {{ __('Log in') }}
                                </x-primary-button>
                                <p class="pt-3 text-center mfs">Don't have account? <a href="{{ route('register') }}"><span
                                            class="site-text">Register Now</span></a></p>
                            </form>

                            {{-- <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- 2 column grid layout with text inputs for the first and last names -->
                                <div class="mb-4 row">
                                    <div class="form-outline">
                                        <x-input-label class="form-label" for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="form-control form-control-solid"
                                            type="email" name="email" :value="old('email')" required
                                            autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="form-outline">
                                        <x-input-label class="form-label" for="password" :value="__('Password')" />

                                        <x-text-input id="password" class="form-control form-control-solid"
                                            type="password" name="password" required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Checkbox -->
                                <div class="row justify-content-between align-items-center">
                                    <div class="mb-3 form-check d-flex justify-content-center align-items-center">
                                        <input class="form-check-input me-2" type="checkbox" value=""
                                            id="remember_me" name="remember" />
                                        <label class="form-check-label" for="remember_me">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <div class="mb-3 form-check d-flex justify-content-center align-items-center">
                                            <h6 class="d-flex justify-content-center align-items-center">
                                                {{ __('Forgot your password?') }}
                                                <a href="{{ route('password.request') }}"
                                                    class="btn btn-sm btn-link text-gray fw-bold fs-6">{{ __('Click Here...') }}</a>
                                            </h6>
                                        </div>
                                    @endif
                                </div>

                                <!-- Submit button -->
                                <div class="mx-auto">
                                    <button type="submit" class="mb-4 btn btn-common-one rounded-pill" style="width: 100% !important;">Log in</button>
                                </div>
                            </form> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordField = document.getElementById('password-field');
                const lockIcon = document.getElementById('lockIcon');
                const currentType = passwordField.type;

                if (currentType === "password") {
                    passwordField.type = "text";
                    lockIcon.classList.remove('fa-lock', 'site-text'); // Remove lock and danger classes
                    lockIcon.classList.add('fa-unlock', 'text-success'); // Add unlock and success classes
                } else {
                    passwordField.type = "password";
                    lockIcon.classList.remove('fa-unlock', 'text-success'); // Remove unlock and success classes
                    lockIcon.classList.add('fa-lock', 'site-text'); // Add lock and danger classes
                }
            });
        </script>
    @endpush
</x-frontend-app-layout>
