<div class="container py-5 mb-5 mb-lg-0 desktop-homepage">
    <div class="py-5 row">
        <div class="col-lg-10 offset-lg-1">
            <div class="border-0 card">
                <div class="p-0 border-0 shadow-sm card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="">
                                        <p class="pb-2">Welcome Here!</p>
                                        <h2 class="mb-5 fw-bold">Register Now</h2>
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <!-- 2 column grid layout with text inputs for the first and last names -->
                                            <div class="row">
                                                <div class="mb-2 col-md-12 col-12">
                                                    <div class="form-outline">
                                                        <x-input-label class="form-label" for="name"
                                                            :value="__('Name')" />
                                                        <x-text-input id="name"
                                                            class="form-control form-control-solid" type="text"
                                                            name="name" :value="old('name')" required autofocus
                                                            autocomplete="name" placeholder="" />
                                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-md-12 col-12">
                                                    <div class="form-outline">
                                                        <x-input-label class="form-label" for="email"
                                                            :value="__('Email')" />
                                                        <x-text-input id="email"
                                                            class="form-control form-control-solid" type="email"
                                                            name="email" :value="old('email')" required
                                                            autocomplete="username" />
                                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-4 col-md-6 col-12">
                                                    <div class="form-outline">
                                                        <x-input-label class="form-label" for="password"
                                                            :value="__('Password')" />

                                                        <x-text-input id="password"
                                                            class="form-control form-control-solid" type="password"
                                                            placeholder="********" name="password" required
                                                            autocomplete="new-password" />
                                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="mb-4 col-md-6 col-12">
                                                    <div class="form-outline">
                                                        <x-input-label class="form-label" for="password_confirmation"
                                                            :value="__('Confirm Password')" />

                                                        <x-text-input id="password_confirmation"
                                                            class="form-control form-control-solid"
                                                            placeholder="********" type="password"
                                                            name="password_confirmation" required
                                                            autocomplete="new-password" />
                                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pt-4">
                                                <!-- Submit button -->
                                                <x-primary-button class="px-4 btn btn-common-one rounded-pill w-100">
                                                    {{ __('Register') }}
                                                </x-primary-button>
                                            </div>

                                            <!-- Checkbox -->
                                            <div
                                                class="pt-4 mb-2 form-check d-flex justify-content-center align-items-center">
                                                <h6 class="d-flex justify-content-start align-items-center">
                                                    {{ __('Already registered?') }}
                                                    <a href="{{ route('login') }}"
                                                        class="btn btn-sm btn-link text-gray fw-bold fs-6">Log In</a>
                                                </h6>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5 col-lg-6 mb-lg-0 d-none d-lg-block">
                            <img class="img-fluid register-img" src="{{ asset('images/login-img.png') }}"
                                class="w-100 rounded-4 shadow-4" alt="" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
