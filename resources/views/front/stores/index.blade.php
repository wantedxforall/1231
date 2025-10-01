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
                                <th class="min-w-50px">#</th>
                                <th class="min-w-125px">Store</th>
                                <th class="text-center min-w-75px">Transactions</th>
                                <th class="text-center min-w-75px">Total</th>
                                <th class="text-center min-w-75px">Currency Rate</th>
                                <th class="text-center min-w-75px">Mobile Wallet</th>
                                <th class="text-center min-w-75px">Integration</th>
                                <th class="text-center min-w-75px">Device</th>
                                <th class="text-center min-w-75px">Status</th>
                                <th class="text-center min-w-75px">EXPIRY</th>
                                <th class="text-center min-w-75px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            <!--begin::Table row-->
                            <?php $i = 0; ?>
                            @foreach ($stores as $val)
                                <?php $i++; ?>
                                <tr>
                                    <!--begin::Checkbox-->
                                    <td>
                                        {{ $val->id }}
                                    </td>
                                    <!--end::Checkbox-->
                                    <!--begin::Store=-->
                                    <td class="d-flex align-items-center">
                                        <!--begin:: Logo -->
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <img src="{{ $val->full_logo_url }}" alt="{{ $val->name }}">
                                        </div>
                                        <!--end::Logo-->
                                        <!--begin::Store details-->
                                        <div class="d-flex flex-column">
                                            <a href="https://{{ $val->domain }}" class="text-gray-800 text-hover-primary mb-1">{{ $val->name }}</a>
                                            <span>{{ $val->domain }}</span>
                                        </div>
                                        <!--begin::Store details-->
                                    </td>
                                    <!--end::Store=-->
                                    <!--begin::Phone=-->
                                    {{-- <td class="text-center">
                                        {{ optional($val->plans)->name }}
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                            title="from {{ optional($val->plans)->min }} to {{ optional($val->plans)->max }} monthly orders"></i>
                                    </td> --}}
                                    <!--end::Phone=-->
                                    <!--begin::Transaction No.=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ Tiny::transactionsCountForStore($val->id) }}</span>
                                    </td>
                                    <!--end::Transaction No.=-->
                                    <!--begin::Total=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ round(Tiny::AmountCountForStore($val->id)) }}</span>
                                    </td>
                                    <!--end::Total=-->
                                    <!--begin::Currency Rate=-->
                                    <td class="text-center pe-0">
                                        @if ($val->ratesync == 0)
                                            <span class="fw-bold">{{ $val->currency . ' EGP' }}</span>
                                        @elseif ($val->ratesync == 1 && $val->synctype == 1)
                                            <span class="fw-bold">{{ $options['usdt_rate'] . ' ≈ USDT' }}</span>
                                        @else
                                            <span class="fw-bold">{{ $options['usd_rate']  . ' ≈ USD' }}</span>
                                        @endif
                                    </td>
                                    <!--end::Currency Rate=-->
                                    <!--begin::Mobile Wallet=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">{{ $val->mobile_wallet ?? 'N/A' }}</span>
                                    </td>
                                    <!--end::Mobile Wallet=-->
                                    <!--begin::Integration=-->
                                    <td class="text-center pe-0">
                                        <span class="fw-bold">
                                            @if ($val->integration == 1)
                                                <span class="symbol symbol-50px me-6" title="Wordpress">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="fab fa-wordpress text-success fs-2x"></i>
                                                    </span>
                                                </span>
                                            @elseif ($val->integration == 2)
                                                <span class="symbol symbol-50px me-6" title="Perfect Panel">
                                                    <span class="symbol-label bg-light-warning">
                                                        <img style="height: 40px;width: 50px;"
                                                            src="{{ asset('assets/media/logos/perfectpanel.png') }}">
                                                    </span>
                                                </span>
                                            @elseif ($val->integration == 3)
                                                <span class="symbol symbol-50px me-6" title="Soc Panel">
                                                    <span class="symbol-label bg-light-primary">
                                                        <img style="height: 40px;width: 50px;"
                                                            src="{{ asset('assets/media/logos/socpanel.png') }}">
                                                    </span>
                                                </span>
                                            @elseif ($val->integration == 4)
                                                <span class="symbol symbol-50px me-6" title="Amazing Panel">
                                                    <span class="symbol-label bg-light-primary">
                                                        <img style="height: 40px;width: 50px;"
                                                            src="{{ asset('assets/media/logos/amzingpanel.png') }}">
                                                    </span>
                                                </span>
                                            @elseif ($val->integration == 5)
                                                <span class="symbol symbol-50px me-6" title="Child Panel">
                                                    <span class="symbol-label bg-light-primary">
                                                        <img style="height: 40px;width: 50px;"
                                                            src="{{ asset('assets/media/logos/amzingpanel.png') }}">
                                                    </span>
                                                </span>
                                            @elseif ($val->integration == 7)
                                                <span class="symbol symbol-50px me-6" title="Custom Api">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="fa-solid fa-code text-primary fs-2x"></i>
                                                    </span>
                                                </span>
                                            @endif
                                        </span>
                                    </td>
                                    <!--end::Integration=-->
                                    <!--begin::Device=-->
                                    <td class="text-center pe-0">
                                        <!--begin::Badges-->
                                        @if ($val->status == 1)
                                            @if ($val->device == 0)
                                                <div class="badge badge-light-danger">Disconnected</div>
                                            @else
                                                <div class="badge badge-light-success text-success">Connected</div>
                                            @endif
                                        @else
                                            <span class="fw-bold"></span>
                                        @endif
                                        <!--end::Badges-->
                                    </td>
                                    <!--end::Device=-->
                                    <!--begin::Status=-->
                                    <td class="text-center pe-0">
                                        <!--begin::Badges-->
                                        <span
                                            class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\front\stores::STATUSES_CLASSES[$val->status] }}">{{ App\Models\front\stores::STATUSES[$val->status] }}</span>
                                        <!--end::Badges-->
                                    </td>
                                    <!--end::Status=-->
                                    <!--begin::Date Modified=-->
                                    <td class="text-center">
                                        <span class="fw-bold">
                                            <span class="fw-bold fs-6 text-gray-800"><span
                                                    class="badge badge-dark fs-25">{{ $val->expiry }}</span></span>
                                        </span>
                                    </td>
                                    <!--end::Date Modified=-->
                                    <!--begin::Action=-->
                                    <td class="text-center">
                                        <!--begin::Toolbar-->
                                        @if ($val->status == 1)
                                            <!--begin::Edit-->
                                            <a href="/stores/edit/{{ $val->id }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                            <!--end::Edit-->
                                            <!--begin::More-->
                                            <a href="{{ route('front.stores.transactions', $val->id) }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                data-bs-toggle="tooltip" title="Transactions" data-kt-menu-trigger="click"
                                                data-kt-menu-placement="bottom-end">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-09-043348/core/html/src/media/icons/duotune/files/fil001.svg-->
                                                <span class="svg-icon svg-icon-3"><svg width="16" height="19"
                                                        viewBox="0 0 16 19" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.3"
                                                            d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--end::More-->
                                            <!--begin::More-->
                                            <a target="_blank" href="{{ route('front.stores.payment_link', $val->username) }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                data-bs-toggle="tooltip" title="Payment Link"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3"><svg width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z"
                                                            fill="currentColor" />
                                                        <rect x="21.9497" y="3.46448" width="13" height="2"
                                                            rx="1" transform="rotate(135 21.9497 3.46448)"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--end::More-->
                                            <!--begin::More-->
                                            <a href="{{ route('front.stores.qrcode', $val->id) }}"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                data-bs-toggle="tooltip" title="QR Code"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/coding/cod003.svg-->
                                                    <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.95 18.9688C16.75 18.9688 16.55 18.8688 16.35 18.7688C15.85 18.4688 15.75 17.8688 16.05 17.3688L19.65 11.9688L16.05 6.56876C15.75 6.06876 15.85 5.46873 16.35 5.16873C16.85 4.86873 17.45 4.96878 17.75 5.46878L21.75 11.4688C21.95 11.7688 21.95 12.2688 21.75 12.5688L17.75 18.5688C17.55 18.7688 17.25 18.9688 16.95 18.9688ZM7.55001 18.7688C8.05001 18.4688 8.15 17.8688 7.85 17.3688L4.25001 11.9688L7.85 6.56876C8.15 6.06876 8.05001 5.46873 7.55001 5.16873C7.05001 4.86873 6.45 4.96878 6.15 5.46878L2.15 11.4688C1.95 11.7688 1.95 12.2688 2.15 12.5688L6.15 18.5688C6.35 18.8688 6.65 18.9688 6.95 18.9688C7.15 18.9688 7.35001 18.8688 7.55001 18.7688Z" fill="currentColor"/>
                                                        <path opacity="0.3" d="M10.45 18.9687C10.35 18.9687 10.25 18.9687 10.25 18.9687C9.75 18.8687 9.35 18.2688 9.55 17.7688L12.55 5.76878C12.65 5.26878 13.25 4.8687 13.75 5.0687C14.25 5.1687 14.65 5.76878 14.45 6.26878L11.45 18.2688C11.35 18.6688 10.85 18.9687 10.45 18.9687Z" fill="currentColor"/>
                                                        </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                </a>
                                            <!--end::More-->
                                        @else
                                            <!--begin::Edit-->
                                            <a href="#"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                            <!--end::Edit-->
                                            <!--begin::More-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                data-bs-toggle="tooltip" title="Transactions"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-10-09-043348/core/html/src/media/icons/duotune/files/fil001.svg-->
                                                <span class="svg-icon svg-icon-3"><svg width="16" height="19"
                                                        viewBox="0 0 16 19" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V2.40002C0 3.00002 0.4 3.40002 1 3.40002H12C12.6 3.40002 13 3.00002 13 2.40002V1.40002C13 0.800024 12.6 0.400024 12 0.400024Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.3"
                                                            d="M15 8.40002H1C0.4 8.40002 0 8.00002 0 7.40002C0 6.80002 0.4 6.40002 1 6.40002H15C15.6 6.40002 16 6.80002 16 7.40002C16 8.00002 15.6 8.40002 15 8.40002ZM16 12.4C16 11.8 15.6 11.4 15 11.4H1C0.4 11.4 0 11.8 0 12.4C0 13 0.4 13.4 1 13.4H15C15.6 13.4 16 13 16 12.4ZM12 17.4C12 16.8 11.6 16.4 11 16.4H1C0.4 16.4 0 16.8 0 17.4C0 18 0.4 18.4 1 18.4H11C11.6 18.4 12 18 12 17.4Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--end::More-->
                                            <!--begin::More-->
                                            <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                data-bs-toggle="tooltip" title="Payment Link"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3"><svg width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z"
                                                            fill="currentColor" />
                                                        <rect x="21.9497" y="3.46448" width="13" height="2"
                                                            rx="1" transform="rotate(135 21.9497 3.46448)"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->

                                            </a>
                                            <!--end::More-->
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <!--end::Table body-->
                        <!--end::Toolbar-->
                    </table>
                    {{ $stores->links() }}

                    <!--end::Table-->
                </div>


                <!--end::Card body-->
            </div>
            <!--end::Products-->

        </div>
        <!--end::Container-->
    </div>

    <!--begin::Modal -->
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
                <div id="kt_subscriptions_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
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
                <form id="kt_subscriptions_export_form" class="form" action="" method="POST">
                    @csrf
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Row-->
                    <!--end::Row-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_subscriptions_export_cancel" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>
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
<!--end::Modal -->

@endsection

@push('js')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ url('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/add.js') }}"></script>
@endpush
