<x-guest-layout>
    <p class="login-box-msg">Sign in to your account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        {{-- Username --}}
        <div class="form-group">
            <label for="username">Username or Email address</label>
            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="username or email"
                value="{{ old('username') }}" />
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" />
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="row mt-5">
            <div class="col-8">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">
                    Remember Me
                </label>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    @if (Route::has('password.request'))
    <p class="mb-1">
        <a href="{{ route('password.request') }}">Forgot your password?</a>
    </p>
    @endif
</x-guest-layout>