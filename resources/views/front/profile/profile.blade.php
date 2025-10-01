@extends('front.layouts.app', ['title' => __('Profile'), 'current' => 'profile'])

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_profile_details" aria-expanded="true"
                    aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" class="form" method="POST"
                        action="{{ route('front.profile.update') }}">
                        @csrf
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" class="form-control form-control-solid" name="name"
                                                value="{{ $user->name }}" />
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" class="form-control form-control-solid" name="last_name"
                                                value="{{ $user->last_name }}" />
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" class="form-control form-control-solid" name="company"
                                        value="{{ $user->company }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Contact Phone</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="Phone number must be active"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="tel" class="form-control form-control-solid" name="phone"
                                        value="{{ $user->phone }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Site</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" class="form-control form-control-solid" name="site"
                                        value="{{ $user->site }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Country</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="Country of origination"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="country" aria-label="Select a Country" data-control="select2"
                                        data-placeholder="Select a country..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">Select a Country...</option>
                                        @foreach (config('countries.en') as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $user->country == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Time Zone</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="time_zone" aria-label="Select a Country" data-control="select2"
                                        data-placeholder="Select a country..."
                                        class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">Select a time zone...</option>

                                        @foreach (config('timezone') as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $user->time_zone == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                                Changes</button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Basic info-->
            <!--begin::Sign-in Method-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_signin_method">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Sign-in Method</h3>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_signin_method" class="collapse show">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        @include('front.layouts.errors')
                        {{-- @dump(session()->get('error')) --}}
                        <!--begin::Email Address-->
                        <div class="d-flex flex-wrap align-items-center">
                            <!--begin::Label-->
                            <div id="kt_signin_email">
                                <div class="fs-6 fw-bold mb-1">Email Address</div>
                                <div class="fw-semibold text-gray-600">{{ $user->email }}</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Edit-->
                            <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                <!--begin::Form-->
                                <form id="kt_signin_change_email" class="form" novalidate="novalidate">
                                    <div class="row mb-6">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New
                                                    Email Address</label>
                                                <input type="email"
                                                    class="form-control form-control-lg form-control-solid"
                                                    id="emailaddress" placeholder="Email Address" name="emailaddress"
                                                    value="{{ $user->email }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-0">
                                                <label for="confirmemailpassword"
                                                    class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="confirmemailpassword" id="confirmemailpassword" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button id="kt_signin_submit" type="button"
                                            class="btn btn-primary me-2 px-6">Update Email</button>
                                        <button id="kt_signin_cancel" type="button"
                                            class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Edit-->
                            <!--begin::Action-->
                            <div id="kt_signin_email_button" class="ms-auto">
                                <button class="btn btn-light btn-active-light-primary">Change Email</button>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--end::Email Address-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-6"></div>
                        <!--end::Separator-->
                        <!--begin::Password-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Label-->
                            <div id="kt_signin_password">
                                <div class="fs-6 fw-bold mb-1">Password</div>
                                <div class="fw-semibold text-gray-600">************</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Edit-->
                            <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                <!--begin::Form-->
                                <form id="kt_signin_change_password" class="form" method="POST"
                                    action="{{ route('front.profile.password.post') }}">
                                    @csrf
                                    <div class="row mb-1">
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="old_password" class="form-label fs-6 fw-bold mb-3">Current
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="old_password" id="old_password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="password" class="form-label fs-6 fw-bold mb-3">New
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="password" id="password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="password_confirmation" class="form-label fs-6 fw-bold mb-3">Confirm
                                                    New Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="password_confirmation" id="password_confirmation" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text mb-5">Password must be at least 8 character and contain symbols
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit"
                                            class="btn btn-primary me-2 px-6">Update Password</button>
                                            <button id="kt_password_cancel" type="button"
                                            class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Edit-->
                            <!--begin::Action-->
                            <div id="kt_signin_password_button" class="ms-auto">
                                <button class="btn btn-light btn-active-light-primary">Reset Password</button>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--end::Password-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Sign-in Method-->
        </div>
    </div>
@endsection

@push('js')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ url('assets/js/custom/account/settings/signin-methods.js') }}"></script>
@endpush
