@extends('front.layouts.app', ['title' => __('Stores'), 'current' => 'stores'])

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    </div>
                    <!--end::Card toolbar-->
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Filter
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-subscription-table-filter="form">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Status:</label>
                                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-subscription-table-filter="status" data-hide-search="true">
                                        <option></option>
                                        <option value="Active">Active</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Provider:</label>
                                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-subscription-table-filter="billing" data-hide-search="true">
                                        <option></option>
                                        <option value="VF-Cash">VF-Cash</option>
                                        <option value="ET-Cash">ET-Cash</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset"
                                        class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                        data-kt-menu-dismiss="true" data-kt-subscription-table-filter="reset">Reset</button>
                                    <button type="submit" class="btn btn-primary fw-semibold px-6"
                                        data-kt-menu-dismiss="true"
                                        data-kt-subscription-table-filter="filter">Apply</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Add user-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_user">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add User
                        </button>
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="text-center min-w-100px">Account</th>
                                <th class="text-center min-w-100px">Email</th>
                                <th class="text-center min-w-100px">Status</th>
                                <th class="text-center min-w-100px">Last Login</th>
                                <th class="text-center min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Account=-->
                                <td class="text-center pe-0">
                                    <span class="fw-bold">jimmy</span>
                                </td>
                                <!--end::Account=-->
                                <!--begin::Integration=-->
                                <td class="text-center pe-0">
                                    <span class="fw-bold">trkytrkya430@gmail.com</span>
                                </td>
                                <!--end::Integration=-->
                                <!--begin::Status=-->
                                <td class="text-center pe-0">
                                    <!--begin::Badges-->
                                    <div class="badge badge-light-success">Active</div>
                                    <!--end::Badges-->
                                </td>
                                <!--end::Status=-->
                                <!--begin::Date Modified=-->
                                <td class="text-center" data-order="2022-11-10 13:24:10">
                                    <span class="fw-bold">2022-11-10 13:24:10</span>
                                </td>
                                <!--end::Date Modified=-->
                                <!--begin::Action=-->
                                <td class="text-center">
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_add_user">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_set_password">Set password</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Account=-->
                                <td class="text-center pe-0">
                                    <span class="fw-bold">jimmy</span>
                                </td>
                                <!--end::Account=-->
                                <!--begin::Integration=-->
                                <td class="text-center pe-0">
                                    <span class="fw-bold">trkytrkya430@gmail.com</span>
                                </td>
                                <!--end::Integration=-->
                                <!--begin::Status=-->
                                <td class="text-center pe-0">
                                    <!--begin::Badges-->
                                    <div class="badge badge-light-danger">Suspended</div>
                                    <!--end::Badges-->
                                </td>
                                <!--end::Status=-->
                                <!--begin::Date Modified=-->
                                <td class="text-center" data-order="2022-11-10 13:24:10">
                                    <span class="fw-bold">2022-11-10 13:24:10</span>
                                </td>
                                <!--end::Date Modified=-->
                                <!--begin::Action=-->
                                <td class="text-center">
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_add_user">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_set_password">Set password</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                        <!--end::Toolbar-->

                        </td>
                        <!--end::Action=-->
                        </tr>
                        <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->

        </div>
        <!--end::Container-->
    </div>

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add User</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Account</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="user_name"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="user_email"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Password</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="password"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="status" aria-label="Select a Country" data-control="select2"
                                    class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                </select>

                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Discard</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Create account</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    <!--begin::Modals-->
    <!--begin::Modal - Adjust Balance-->
    <div class="modal fade" id="kt_subscriptions_export_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Export Subscriptions</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_subscriptions_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_subscriptions_export_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                                name="format" class="form-select form-select-solid">
                                <option value="excell">Excel</option>
                                <option value="pdf">PDF</option>
                                <option value="cvs">CVS</option>
                                <option value="zip">ZIP</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Pick a date" name="date" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Row-->
                        <div class="row fv-row mb-15">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Payment Type:</label>
                            <!--end::Label-->
                            <!--begin::Radio group-->
                            <div class="d-flex flex-column">
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked"
                                        name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-semibold">All</span>
                                </label>
                                <!--end::Radio button-->
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked"
                                        name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-semibold">Visa</span>
                                </label>
                                <!--end::Radio button-->
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox" value="3"
                                        name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                                </label>
                                <!--end::Radio button-->
                                <!--begin::Radio button-->
                                <label class="form-check form-check-custom form-check-sm form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="4"
                                        name="payment_type" />
                                    <span class="form-check-label text-gray-600 fw-semibold">American Express</span>
                                </label>
                                <!--end::Radio button-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_subscriptions_export_cancel"
                                class="btn btn-light me-3">Discard</button>
                            <button type="submit" id="kt_subscriptions_export_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Card-->
    <!--end::Modals-->


    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_set_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_set_password_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Set password</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_set_password_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_set_password_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_set_password_header"
                            data-kt-scroll-wrappers="#kt_modal_set_password_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Account</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 mb-lg-0" name="user_name" value="user_name" readonly="readonly">
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Password</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="password"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value="" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Discard</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Set password</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

@endsection

@push('js')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ url('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/add.js') }}"></script>
@endpush
