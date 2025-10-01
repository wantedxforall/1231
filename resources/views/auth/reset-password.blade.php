@extends('auth.layouts.app', ['title' => 'Reset Password', 'current' => 'reset-password'])

@section('content')
    <!--begin::Aside-->
    <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
        <!--begin::Wrapper-->
        <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
            <!--begin::Header-->
            <div class="d-flex flex-stack py-2">
                <!--begin::Back link-->
                <div class="me-2">
                    <a href="../../demo11/dist/authentication/layouts/fancy/sign-in.html"
                        class="btn btn-icon bg-light rounded-circle">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr002.svg-->
                        <span class="svg-icon svg-icon-2 svg-icon-gray-800">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.60001 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13H9.60001V11Z"
                                    fill="currentColor" />
                                <path opacity="0.3" d="M9.6 20V4L2.3 11.3C1.9 11.7 1.9 12.3 2.3 12.7L9.6 20Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                </div>
                <!--end::Back link-->
                <!--begin::Sign Up link-->
                <div class="m-0">
                    <span class="text-gray-400 fw-bold fs-5 me-2" data-kt-translate="new-password-head-desc">Already a
                        member ?</span>
                    <a href="../../demo11/dist/authentication/layouts/fancy/sign-in.html" class="link-primary fw-bold fs-5"
                        data-kt-translate="new-password-head-link">Sign In</a>
                </div>
                <!--end::Sign Up link=-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-20">
                <!--begin::Form-->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ $request->email }}">
                    <!--begin::Heading-->
                    <div class="text-start mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3 fs-3x" data-kt-translate="new-password-title">Setup New Password</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="text-gray-400 fw-semibold fs-6" data-kt-translate="new-password-desc">Have you already
                            reset the password ?</div>
                        <!--end::Link-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <!--begin::Wrapper-->
                        <div class="mb-1">
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3">

                                <x-input id="password" class="form-control form-control-lg form-control-solid"
                                    type="password" name="password" required />

                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <!--end::Input wrapper-->
                            <!--begin::Meter-->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--end::Meter-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Hint-->
                        <div class="text-muted" data-kt-translate="new-password-hint">Use 8 or more characters with a mix of
                            letters, numbers &amp; symbols.</div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10">

                        <x-input id="password_confirmation" class="form-control form-control-lg form-control-solid"
                            type="password" name="password_confirmation" required />
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Actions-->
                    <div class="d-flex flex-stack">
                        <!--begin::Link-->
                        <button type="submit" id="kt_new_password_submit" class="btn btn-primary"
                            data-kt-translate="new-password-submit">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Submit</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                        <!--end::Link-->
                        <!--begin::Social-->
                        @include('auth.layouts.social')
                        <!--end::Social-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            @include('auth.layouts.lang')
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Aside-->
@endsection
