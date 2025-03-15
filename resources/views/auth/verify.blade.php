<x-frontend-app-layout :title="'Email Verification'">
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="fw-bold mb-5">Verify Your Email</h2>
                        <p>Please check your inbox and click the verification link we sent to your email.</p>
                        <a href="{{ route('verification.verify', ['id' => Auth::id(), 'hash' => Auth::user()->email_verified_at]) }}"
                            class="btn btn-primary">
                            Resend Verification Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-app-layout>
