@extends('auth.layouts.app', ['title' => 'Login', 'current' => 'login'])

@section('content')
    <!--begin::Aside-->
    <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
        <!--begin::Wrapper-->
        <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
            <!--begin::Header-->
            <div class="d-flex flex-stack py-2">
                <!--begin::Back link-->
                <div class="me-2"></div>
                <!--end::Back link-->
                <!--begin::Sign Up link-->
                <div class="m-0">
                    <span class="text-gray-400 fw-bold fs-5 me-2" data-kt-translate="sign-in-head-desc">Not a Member
                        yet?</span>
                    <a href="{{ route('register') }}" class="link-primary fw-bold fs-5"
                        data-kt-translate="sign-in-head-link">Sign Up</a>
                </div>
                <!--end::Sign Up link=-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-20">
                <!--begin::Form-->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Heading-->

                        <div class="text-start mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3 fs-3x" data-kt-translate="sign-in-title">Sign In</h1>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="text-gray-400 fw-semibold fs-6" data-kt-translate="general-desc">

                            </div>
                            <!--end::Link-->
                        </div>

                        @if ($errors->all())
                            <div class="alert alert-danger">
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            </div>
                        @endif
                        <!--begin::Heading-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input id="email" class="form-control form-control-solid" type="email" name="email"
                                :value="old('email')" required autofocus placeholder="Email"/>
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        <div class="position-relative mb-3" data-kt-password-meter="true">
                            <!--begin::Password-->
                            <input id="password" class="form-control form-control-solid" type="password" name="password"
                                required autocomplete="current-password" placeholder="Password"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            <!--end::Password-->
                        </div>

                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" name="remember_me" type="checkbox" value="1"
                                id="remember_me" />
                            <label class="form-check-label" for="remember_me">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
                            <div></div>
                            <!--begin::Link-->
                            <a href="{{ route('password.request') }}" class="link-primary"
                                data-kt-translate="sign-in-forgot-password">Forgot Password ?</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Actions-->
                        <div class="d-flex flex-stack">
                            <!--begin::Submit-->
                            <button id="kt_sign_in_submit" class="btn btn-primary me-2 flex-shrink-0">
                                <!--begin::Indicator label-->
                                <span class="indicator-label" data-kt-translate="sign-in-submit">Sign In</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">
                                    <span data-kt-translate="general-progress">Please wait...</span>
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <!--end::Indicator progress-->
                            </button>
                            <!--end::Submit-->
                            {{-- @include('auth.layouts.social') --}}
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--begin::Body-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            {{-- @include('auth.layouts.lang') --}}
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Aside-->
@endsection
