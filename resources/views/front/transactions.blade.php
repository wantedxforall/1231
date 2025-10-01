@extends('front.layouts.app', ['title' => __('Transactions'), 'current' => 'transactions'])

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
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <form action="" method="GET">
                                <input type="text" id="mySearchText" name="search"
                                    class="form-control form-control-solid w-250px ps-15"
                                    placeholder="Search Transaction" />
                            </form>
                            {{-- <input type="text" data-kt-ecommerce-order-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search Transaction" /> --}}
                        </div>
                        <!--end::Search-->
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
                            <form action="{{ route('front.transactions') }}" method="GET" id="filterForm">
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
                                    {{-- @dump(!is_null(request('status')) , request('status') == 0, request('status')) --}}
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Status:</label>
                                        <select id="status" name="status" class="form-select form-select-solid fw-bold"
                                            data-kt-select2="true" data-control="select2"
                                            data-placeholder="Select an option">
                                            {{-- <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                            data-placeholder="Select option" data-allow-clear="true"
                                            data-kt-subscription-table-filter="status" data-hide-search="true"
                                            id="provider"> --}}
                                            <option {{ is_null(request('status')) ? 'selected' : '' }} value="all">All
                                            </option>
                                            @foreach (App\Models\front\transactions::STATUSES as $key => $value)
                                                <option
                                                    {{ !is_null(request('status')) && request('status') === (string) $key ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Providers:</label>
                                        <select id="providers" name="providers"
                                            class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                            data-control="select2" data-placeholder="Select an option">
                                            <option
                                                {{ !request()->has('providers') || request('providers') == 'all' ? 'selected' : '' }}
                                                value="all">All
                                            </option>
                                            @foreach ($transactions->pluck('providers')->flatten()->unique('id') as $provider)
                                                <option {{ request('providers') == $provider->id ? 'selected' : '' }}
                                                    value="{{ $provider->id }}">{{ $provider->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="Pick a date"
                                            name="date" id="dateRange"
                                            value="{{ $startDate && $endDate ? $startDate . ' to ' . $endDate : ($startDate ? $startDate : '') }}" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row mb-10">
                                        <label class="form-label">Amount</label>
                                        <div id="kt_slider_tooltip"></div>

                                        <input type="hidden" name="fromslider" id="fromslider" value="">
                                        <input type="hidden" name="toslider" id="toslider" value="">
                                    </div>
                                    <!--end::Input group-->

                                    {{-- <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-semibold form-label mb-5">Username : </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="By username" name="username" id="username" value="{{ request()->get('username') }}" />
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-semibold form-label mb-5">Phone : </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="By Sender Phone Number" name="from" id="from" value="{{ request()->get('from') }}" />
                                    <!--end::Input-->
                                </div>
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-semibold form-label mb-5">Transaction NO : </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="By Transaction NO" name="transaction" id="transaction" value="  " />
                                    <!--end::Input-->
                                </div> --}}
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-menu-dismiss="true"
                                            onclick=" window.location.href = '{{ route('front.transactions') }}';"
                                            data-kt-subscription-table-filter="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary fw-semibold px-6">Apply</button>
                                    </div>

                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </form>
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                            data-bs-target="#kt_subscriptions_export_modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                        transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                    <path
                                        d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Export
                        </button>
                        <!--end::Export-->
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
                            <!--end::Svg Icon-->Add Transactions
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
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_ecommerce_sales_table .form-check-input"
                                            value="1" />
                                    </div>
                                </th>
                                <th class="min-w-70px">ID</th>
                                <th class="min-w-70px">Store</th>
                                <th class="min-w-70px">From</th>
                                <th class="min-w-70px">Name</th>
                                <th class="text-center min-w-70px">Status</th>
                                <th class="text-center min-w-100px">Amount</th>
                                <th class="text-center min-w-100px">Balance</th>
                                <th class="text-center min-w-100px">Transaction No.</th>
                                <th class="text-center min-w-100px">Provider</th>
                                <th class="text-center min-w-100px">Sim number</th>
                                <th class="text-center min-w-100px">Username</th>
                                <th class="text-center min-w-100px">Date</th>
                                <th class="text-center min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <?php $i = 0; ?>
                            @foreach ($transactions as $val)
                                <?php $i++; ?>
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Checkbox-->
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </td>
                                    <!--end::Checkbox-->
                                    <!--begin::ID=-->
                                    <td>
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary fw-bold">{{ $val->id }}</a>
                                    </td>
                                    <!--begin::ID=-->
                                    <!--begin::Store name=-->
                                    <td>
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary fw-bold">{{ optional($val->stores)->name }}</a>
                                    </td>
                                    <!--begin::Store name=-->
                                    <!--begin::Phone=-->
                                    <td>
                                        <a href="tel:{{ $val->from }}"
                                            class="text-gray-800 text-hover-primary fw-bold">{{ $val->from }}</a>
                                    </td>
                                    <!--end::Phone=-->
                                    <!--begin::name=-->
                                    <td>
                                        <a href="tel:{{ $val->name }}"
                                            class="text-gray-800 text-hover-primary fw-bold">{{ $val->name }}</a>
                                    </td>
                                    <!--end::name=-->

                                    <!--begin::Status=-->
                                    <td class="text-center pe-0" data-order="Pending">
                                        <!--begin::Badges-->
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\front\transactions::STATUSES_CLASSES[$val->status] }}">{{ App\Models\front\transactions::STATUSES[$val->status] }}</span>

                                        <!--end::Badges-->
                                    </td>
                                    <!--end::Status=-->
                                    <!--begin::Amount=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ round($val->amount, 2) }}</span>
                                    </td>
                                    <!--end::Amount=-->
                                    <!--begin::Balance=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ round($val->balance, 2) }}</span>
                                    </td>
                                    <!--end::Balance=-->
                                    <!--begin::Transaction No.=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ $val->transaction_id }}</span>
                                    </td>
                                    <!--end::Transaction No.=-->
                                    <!--begin::Provider=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ optional($val->providers)->name }}</span>
                                    </td>
                                    <!--end::Provider=-->
                                    <!--begin::Sim=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ $val->sim_number }}</span>
                                    </td>
                                    <!--end::Sim=-->
                                    <!--begin::Username=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ $val->username }}</span>
                                    </td>
                                    <!--end::Username=-->
                                    <!--begin::Date Modified=-->
                                    <td class="text-center" data-order="{{ $val->created_at }}">
                                        <span class="fw-bold">{{ $val->created_at }}</span>
                                    </td>
                                    <!--end::Date Modified=-->
                                    <!--begin::Action=-->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @if ($val->status == 0 && optional($val->stores)->actions == 0 && $val->username != null)
                                                @include('front.layouts.actions', [
                                                    'id' => $val->id,
                                                    'approve' => route('front.transactions.approve', $val->id),
                                                    'reject' => route('front.transactions.reject', $val->id),
                                                ])
                                            @elseif ($val->status == 4 && $val->username != null)
                                                @include('front.layouts.actions', [
                                                    'id' => $val->id,
                                                    'resend' => route('front.transactions.resend', $val->id),
                                                ])
                                            @elseif ($val->status == 0 && optional($val->stores)->actions == 0)
                                                @include('front.layouts.actions', [
                                                    'id' => $val->id,
                                                    'reject' => route('front.transactions.reject', $val->id),
                                                ])
                                            @else
                                            @endif
                                            @if ($val->status != 3)
                                                @include('front.layouts.actions', [
                                                    'id' => $val->id,
                                                    'destroy' => route('front.transactions.destroy', $val->id),
                                                ])
                                            @endif
                                        </div>

                                    </td>
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                            <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    {{ $transactions->withQueryString()->links() }}

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->

        </div>
        <!--end::Container-->
    </div>

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
                    <h2 class="fw-bold">Export Current Transactions</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_subscriptions_export_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                        data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="currentColor" />
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
                    <form id="kt_subscriptions_export_form" class="form"
                        action="{{ route('front.transactions.export') }}" method="POST">
                        @csrf
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                                name="format" class="form-select form-select-solid">
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                                <option value="csv">CSV</option>
                            </select>
                            @forelse (request()->query() as $key => $value)
                                <input type="hidden" name="{{ $key }}" value={{ $value }}>
                            @empty
                                <input type="hidden" name="mode" value="all">
                            @endforelse
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Row-->
                        <!--end::Row-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_subscriptions_export_cancel" data-bs-dismiss="modal"
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

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add Transaction</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="currentColor" />
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
                    <form id="kt_modal_add_user_form" class="form" enctype="multipart/form-data"
                        action="{{ route('front.transactions.store') }}" method="POST">
                        @csrf

                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Message</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea style="height: 117px;" type="text"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 msg_body" placeholder="message body"
                                    id="msg_body" name="msg_body"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Stores:</label>
                                <select id="store" name="store" class="form-select form-select-solid fw-bold"
                                    data-kt-select2="true" data-control="select2" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($storess as $store)
                                        <option value="{{ $store->id }}"
                                            {{ optional($store)->value == $store->id ? 'selected' : '' }}>
                                            {{ $store->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Providers:</label>
                                <select id="provider" name="provider" class="form-select form-select-solid fw-bold"
                                    data-kt-select2="true" data-control="select2" data-placeholder="Select an option">

                                    <option></option>
                                    @foreach ($providerss as $provider)
                                        <option value="{{ $provider }}"
                                            {{ optional($provider) == $provider ? 'selected' : '' }}>
                                            {{ $provider }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->


                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
    <!--end::Modal - Add task-->

    <!--end::Modals-->
@endsection

@push('js')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ url('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/add.js') }}"></script>
    <script>
        $('#dateRange').flatpickr({
            mode: "range",
            dateFormat: "Y-m-d"
        })
        var tooltipSlider = document.querySelector("#kt_slider_tooltip");
        var from = document.querySelector("#fromslider");
        var to = document.querySelector("#toslider");
        noUiSlider.create(tooltipSlider, {
            start: [parseInt("{{ $fromSlider }}"), parseInt("{{ $toSlider }}")],
            tooltips: true,
            step: 1,
            range: {
                "min": 0,
                "max": parseInt("{{ $maxAmount }}") + 50

            }
        });
        tooltipSlider.noUiSlider.on("update", function(values, handle) {
            if (handle) {
                to.value = values[handle];
            } else {
                from.value = values[handle];
            }
        });
    </script>
@endpush
