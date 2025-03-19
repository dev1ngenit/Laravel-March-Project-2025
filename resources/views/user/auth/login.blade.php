<div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-4 p-5" style="max-width: 480px; width: 100%; background: #f9f9f9;">
        <div class="card-body">
            <!-- Logo or App Name (Optional) -->
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark">Welcome Back!</h3>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold text-muted">Email</label>
                    <input id="email" type="email" name="email" class="form-control form-control-lg shadow-sm"
                        required autocomplete="username" placeholder="Enter your email">
                    <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold text-muted">Password</label>
                    <input id="password" type="password" name="password" class="form-control form-control-lg shadow-sm"
                        required autocomplete="current-password" placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label text-muted" for="remember_me">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-decoration-none text-muted fw-semibold">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn btn-primary w-100 rounded-pill py-2 shadow-lg transition-all hover:scale-105">Log
                    In</button>
            </form>


        </div>
    </div>
</div>
