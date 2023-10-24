@extends('auth.layouts')

@section('content')
<div class="bg-login-admin">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-4">
                            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="img-fluid logo" height="18" width="18">
                        </div>
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class=" mb-3">
                                <label for="email" class=" col-form-label text-md-end">{{ __('Tên đăng nhập: ') }}</label>

                                <div class="email_">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class=" col-form-label text-md-end">{{ __('Mật khẩu: ') }}</label>

                                <div class="pass_">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Ghi nhớ: ') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="btn-login ">
                                    <button type="submit" class="btn form-control ">
                                        {{ __('Đăng nhập') }}
                                    </button>
                                </div>
                                <div class=" text-center">
                                    <label for="" class=" col-form-label text-md-end"></label>
                                    <div class="text-qa">Thiết kế website <a href="https://finalstyle.com/" target="_blank" class="txt2 bo1">Finalstyle</a></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection