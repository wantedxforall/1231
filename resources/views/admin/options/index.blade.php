@extends('admin.layouts.app', ['title' => 'Options', 'current' => 'options'])
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Content-->
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <!--begin::Tables widget 14-->
                        @if(session('success'))
                        <div class="notice d-flex bg-light-success rounded border-success border border-dashed p-6 mb-5">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">
                                        {{ session('success') }}
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                    @endif
                        <div class="card card-flush h-md-100">
                            <!--begin::Header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Settings</span>

                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <div class="card-toolbar">
                                <div class="d-flex" style="margin-left: 22px;">
                                    @foreach(App\Models\Option::TABS as $key => $tab)
                                    <a href="{{ route('admin.options.index', ['group' => $key]) }}" style="margin: 5px;" class="btn btn-sm btn-light-primary {{ $key == request('group',0) ? 'active' : '' }}">{{ $tab }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <form action="{{ route('admin.options.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @foreach($alloptions as $option)
                                    @if ($option->key == 'embed_code' || $option->key == 'site_description')
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                        <textarea type="text" rows="5" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ $option->label }}" name="{{ $option->key }}">{{ $option->value }}</textarea>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        @elseif ($option->key == 'default_plan')
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <select name="{{ $option->key }}" aria-label="Select Plan" data-control="select2" data-placeholder="Select a plan..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option></option>
                                                        @foreach ($plans as $plan)
                                                        <option value="{{ $plan->id }}" {{ optional($option)->value == $plan->id ? 'selected' : '' }}>
                                                            {{ $plan->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        @elseif ($option->key == 'default_store')
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <select name="{{ $option->key }}" aria-label="Select Store" data-control="select2" data-placeholder="Select a store..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                        <option></option>
                                                        @foreach ($stores as $store)
                                                        <option value="{{ $store->id }}" {{ optional($option)->value == $store->id ? 'selected' : '' }}>
                                                            {{ $store->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>

                                        @elseif ($option->key == 'email_smtp_encryption')
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <select name="{{ $option->key }}" aria-label="Select Role" data-control="select2" data-placeholder="Select a role..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                    <option></option>
                                                    @foreach (App\Models\Option::ENCRYPTION as $key => $value)
                                                    <option
                                                        {{ $option
                                                            ? (old('status', $key) == optional($option)->value
                                                                ? 'selected'
                                                                : '')
                                                            : ($key == 1
                                                                ? 'selected'
                                                                : '') }}
                                                        value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    @elseif ($option->key == 'email_protocal')
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                        <!--begin::Options-->
                                                        <div class="d-flex align-items-center mt-3">
                                                            <!--begin::Option-->
                                                            <input type="hidden" name="{{ $option->key }}" value="0">
                                                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                                                <input class="form-check-input" type="radio" name="{{ $option->key }}" value="0" {{ old('Mail', optional($option)->value, 0) == 0 ? 'checked="checked"' : '' }} >
                                                                <label class="form-check-label" for="flexCheckboxSm">Mail</label>
                                                            </label>
                                                            <!--end::Option-->
                                                            <!--begin::Option-->
                                                            <label class="form-check form-check-inline form-check-solid">
                                                                <input class="form-check-input" type="radio" name="{{ $option->key }}" value="1" {{ old('SMTP', optional($option)->value , 0) == 1 ? 'checked="checked"' : '' }} />
                                                                <label class="form-check-label" for="flexCheckboxSm">SMTP</label>
                                                            </label>
                                                            <!--end::Option-->
                                                        </div>
                                                        <!--end::Options-->
                                                    </div>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    @elseif ($option->key == 'facebook_login_status' || $option->key == 'twitter_login_status' || $option->key == 'google_login_status' || $option->key == 'opay_status' || $option->key == 'campaigns_needs_approve' || $option->key == 'recaptcha_status')
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <div class="form-check form-check-solid form-switch fv-row">
                                                        <input type="hidden" name="{{ $option->key }}" value="0">
                                                        <input class="form-check-input" name="{{ $option->key }}" type="checkbox" value="1"
                                                        {{ old('status', optional($option)->value) ? 'checked="checked"' : '' }} />
                                                        <span class="form-check-label fw-bold text-gray-400">
                                                            {{ old('status', optional($option)->value) ? 'ON' : 'OFF' }}
                                                        </span>
													</div>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    @elseif ($option->key == 'approve_item' || $option->key == 'convert_pending_balance' || $option->key == 'max_price_for_campaign' || $option->key == 'min_price_for_campaign' || $option->key == 'max_price_for_review' || $option->key == 'min_price_for_review')
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="number" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ $option->label }}" name="{{ $option->key }}" value="{{ $option->value }}" />
                                                    </div>
                                                    <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    @else
                                      @if ($option->is_image)
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <input class="form-control file" type="file" name="{{ $option->key }}" id="">
                                                </div>
                                                <div class="col-lg-4">
                                                   <a class="border-0" href="{{ url('storage/' . $option->value) }}" target="_blank" class="btn btn-primary"> <img src="{{ url('storage/' . $option->value) }}" alt="" width="100px"></a>
                                                </div>
                                                <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                      @else
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $option->label }}</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="{{ $option->label }}" name="{{ $option->key }}" value="{{ $option->value }}" />
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>

                                     @endif
                                    @endif




                                    {{-- <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">{{ $option->label }}</label>
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <input type="text" class="form-control form-control-solid form-control-sm" value="{{ $option->value }}" name="{{ $option->key }}" placeholder="{{ $option->label }}">
                                        </div>
                                    </div> --}}
                                @endforeach
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                                        Changes</button>
                                </div>
                                {{-- <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                 </div> --}}
                                </form>
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Tables widget 14-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
@endsection
