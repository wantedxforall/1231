    @extends('front.layouts.app', ['title' => isset($store) ? 'Edit Store ' . ' ' . $store->name : 'Store Create'])
    @section('content')
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!--begin::Form-->

                            <form class="form d-flex flex-column flex-lg-row"
                                action="{{ isset($store) ? '/stores/update/' . $store->id : route('front.stores.save') }}"
                                method="POST" enctype="multipart/form-data">
                                @if (isset($store))
                                    <!-- method_field('PATCH')
                                                                                                        csrf_field() -->
                                    @csrf
                                @else
                                    @csrf
                                @endif
                                <!--begin::Aside column-->
                                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                                    <!--begin::Thumbnail settings-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Logo</h2>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body text-center pt-0">
                                            <!--begin::Image input-->
                                            <!--begin::Image input placeholder-->
                                            <style>
                                                .image-input-placeholder {
                                                    background-image: url('{{ url('assets/media/svg/files/blank-image.svg') }}');
                                                }

                                                [data-theme="dark"] .image-input-placeholder {
                                                    background-image: url('{{ url('assets/media/svg/files/blank-image-dark.svg') }}');
                                                }
                                            </style>
                                            <style>
                                                .image-input-placeholder {
                                                    background-image: url('{{ isset($store) && $store->full_logo_url ? $store->full_logo_url : url('assets/media/svg/files/blank-image.svg') }}');
                                                }

                                                [data-theme="dark"] .image-input-placeholder {
                                                    background-image: url('{{ isset($store) && $store->full_logo_url ? $store->full_logo_url : url('assets/media/svg/files/blank-image-dark.svg') }}');
                                                }
                                            </style>
                                            <!--end::Image input placeholder-->
                                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                                data-kt-image-input="true">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-150px h-150px"
                                                    style="background-image: url('')">
                                                </div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Label-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                                    <!-- <input type="hidden" name="avatar_remove" /> -->
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Cancel-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Cancel-->
                                                <!--begin::Remove-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">image. Only *.png, *.jpg and *.jpeg image files are
                                                accepted</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Thumbnail settings-->


                                </div>
                                <!--end::Aside column-->

                                <!--begin::Main column-->
                                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                                    <!--begin:::Tabs-->
                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                href="#kt_general">General</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                href="#Kt_integration">Integration</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                href="#Kt_providers">Providers</a>
                                        </li>
                                        <!--end:::Tab item-->
                                    </ul>
                                    <!--end:::Tabs-->
                                    <!--begin::Tab content-->
                                    <div class="tab-content">
                                        <!--begin::Tab general-->
                                        <div class="tab-pane fade show active" id="kt_general" role="tab-panel">
                                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                                <!--begin::General options-->
                                                <div class="card card-flush py-4">
                                                    <!--begin::Card header-->
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <h2>General</h2>
                                                        </div>
                                                    </div>
                                                    <div class="card-title">
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <!--end::Card header-->
                                                    <!--begin::Card body-->
                                                    <div class="card-body pt-0">
                                                        <!--begin::Input group-->
                                                        <div class="mb-10 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Store Name</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="name" class="form-control mb-2"
                                                                placeholder="Store name"
                                                                value="{{ old('name', isset($store) ? $store->name : '') }}"
                                                                @if (isset($store)) readonly="readonly" @endif />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A store name is required and
                                                                recommended to be unique.</div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="mb-10">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Store Username</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div class="input-group mb-5">
                                                                <span
                                                                    class="input-group-text">{{ route('front.home') }}/store/</span>
                                                                <input type="text" name="username"
                                                                    value="{{ old('username', isset($store) ? $store->username : '') }}"
                                                                    class="form-control" placeholder="Username"
                                                                    required="">
                                                            </div>
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">The store username is for the
                                                                direct link, {{ route('front.home') }}/store/username</div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="mb-10 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Domain Name</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="domain" class="form-control mb-2"
                                                                placeholder="example.com"
                                                                value="{{ old('domain', isset($store) ? $store->domain : '') }}"
                                                                @if (isset($store)) readonly="readonly" @endif />

                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A Domain is required and
                                                                recommended to be unique.</div>
                                                            <!--end::Description-->
                                                            <br>

                                                            <!--begin::Label-->
                                                            <label class="form-label">Mobile Wallet</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="mobile_wallet"
                                                                class="form-control mb-2" placeholder="01000000000"
                                                                value="{{ old('mobile_wallet', isset($store) ? $store->mobile_wallet : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">You can use (,) for multiple
                                                                numbers.</div>
                                                            <!--end::Description-->
                                                            <br>

                                                            <!--begin::Label-->
                                                            <label class="form-label">Whatsapp</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="whatsapp"
                                                                class="form-control mb-2" placeholder="01000000000"
                                                                value="{{ old('whatsapp', isset($store) ? $store->whatsapp : '') }}" />
                                                            <!--end::Input-->
                                                            <br>

                                                            <div id="CurrencyRate">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">Currency Rate</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input id="CurrencyRateset" type="text"
                                                                    name="currency" class="form-control mb-2"
                                                                    placeholder="0.00"
                                                                    value="{{ old('currency', isset($store) ? $store->currency : '') }}" />
                                                                <!--end::Input-->
                                                                <!--begin::Description-->
                                                                <div class="text-muted fs-7">A currency is required and
                                                                    recommended.</div>
                                                                <!--end::Description-->
                                                            </div>

                                                            <br>

                                                            <div class="row mb-0">
                                                                <!--begin::Label-->
                                                                <label class="col-form-label fw-semibold fs-6">Rate
                                                                    Sync</label>
                                                                <!--begin::Label-->
                                                                <div class="col-lg-8 d-flex align-items-center">
                                                                    <div
                                                                        class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                                        <input type="hidden" name="ratesync"
                                                                            value="0" />
                                                                        <input class="form-check-input w-45px h-30px"
                                                                            type="checkbox" value="1"
                                                                            id="ratesync_check" name="ratesync" />
                                                                        <label class="form-check-label"
                                                                            for="ratesync"></label>
                                                                    </div>
                                                                    <!--begin::Description-->
                                                                    <div class="text-muted fs-7">Using for get live rate
                                                                    </div>
                                                                    <!--end ::Description-->
                                                                </div>
                                                                <!--begin::Label-->
                                                            </div>
                                                            <br>

                                                            <div id="rate_option" style="display: none;">
                                                                <!--begin::Methods-->
                                                                <!--begin::Input row-->
                                                                <div class="d-flex fv-row">
                                                                    <!--begin::Radio-->
                                                                    <div
                                                                        class="form-check form-check-custom form-check-solid">
                                                                        <!--begin::Input-->
                                                                        <input class="form-check-input me-3"
                                                                            name="synctype" type="radio" value="1"
                                                                            id="kt_ecommerce_add_category_automation_0"
                                                                            {{ old('synctype', 2) === 1 ? 'checked' : 'checked' }}
                                                                            {{ isset($store) && $store->synctype == 1 ? 'checked' : '' }} />
                                                                        <!--end::Input-->
                                                                        <!--begin::Label-->
                                                                        <label class="form-check-label"
                                                                            for="kt_ecommerce_add_category_automation_0">
                                                                            <div class="fw-bold text-gray-800">USDT sync
                                                                            </div>
                                                                            <div class="text-gray-600">Sync rate by usdt ≈
                                                                                {{ $options['usdt_rate'] }}</div>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                    </div>
                                                                    <!--end::Radio-->
                                                                </div>
                                                                <!--end::Input row-->
                                                                <div class="separator separator-dashed my-5"></div>
                                                                <!--begin::Input row-->
                                                                <div class="d-flex fv-row">
                                                                    <!--begin::Radio-->
                                                                    <div
                                                                        class="form-check form-check-custom form-check-solid">
                                                                        <!--begin::Input-->
                                                                        <input class="form-check-input me-3"
                                                                            name="synctype" type="radio" value="2"
                                                                            {{ old('synctype', 1) === 2 ? 'checked' : '' }}
                                                                            {{ isset($store) && $store->synctype == 2 ? 'checked' : '' }}
                                                                            id="kt_ecommerce_add_category_automation_1" />
                                                                        <!--end::Input-->
                                                                        <!--begin::Label-->
                                                                        <label class="form-check-label"
                                                                            for="kt_ecommerce_add_category_automation_1">
                                                                            <div class="fw-bold text-gray-800">USD sync
                                                                            </div>
                                                                            <div class="text-gray-600">Sync rate by usd ≈
                                                                                {{ $options['usd_rate'] }}</div>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                    </div>
                                                                    <!--end::Radio-->
                                                                </div>
                                                                <!--end::Input row-->
                                                                <!--end::Methods-->
                                                            </div>

                                                            <br>

                                                            <div class="row mb-0">
                                                                <!--begin::Label-->
                                                                <label class="col-form-label fw-semibold fs-6">SIMs</label>
                                                                <!--end::Label-->
                                                                <div class="col-lg-8 d-flex align-items-center">
                                                                    <div
                                                                        class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                                        <input type="hidden" name="sim1"
                                                                            value="0" />
                                                                        <input class="form-check-input w-45px h-30px"
                                                                            name="sim1" type="checkbox" value="1"
                                                                            {{ old('sim1', 0) === 1 ? 'checked' : '' }}
                                                                            {{ isset($store) && $store->sim1 == 1 ? 'checked' : '' }}
                                                                            id="sim1_check" />

                                                                        <label class="form-check-label"
                                                                            for="sim1_check">SIM1</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row mb-0">
                                                                <div class="col-lg-8 d-flex align-items-center">
                                                                    <div
                                                                        class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                                        <input type="hidden" name="sim2"
                                                                            value="0" />
                                                                        <input class="form-check-input w-45px h-30px"
                                                                            name="sim2" type="checkbox" value="1"
                                                                            {{ old('sim2', 0) === 1 ? 'checked' : '' }}
                                                                            {{ isset($store) && $store->sim2 == 1 ? 'checked' : '' }}
                                                                            id="sim2_check" />

                                                                        <label class="form-check-label"
                                                                            for="sim2_check">SIM2</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>

                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--end::Card header-->
                                                </div>
                                                <!--end::General options-->

                                            </div>
                                        </div>
                                        <!--end::Tab general-->
                                        <!--begin::Tab integration-->
                                        <div class="tab-pane fade show" id="Kt_integration" role="tab-panel">
                                            <!--begin::integration-->
                                            <div class="card card-flush py-4">
                                                <!--begin::Card header-->
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h2>
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                                                <span class="required">Select Integration</span>
                                                                <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Specify your Integration"></i>
                                                            </label>
                                                            <!--end::Label-->
                                                        </h2>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Card body-->
                                                <div class="card-body pt-0">
                                                    <!--begin::Input group-->
                                                    <div class="fv-row">

                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-success">
                                                                        <i class="fab fa-wordpress text-success fs-2x"></i>
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Wordpress</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    {{ isset($store) && $store->integration == 1 ? 'checked' : '' }}
                                                                    name="integration" value="1" />
                                                            </span>
                                                            <!--end:Input-->
                                                        </label>
                                                        <!--end::Option-->
                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-warning">
                                                                        <img style="height: 40px;width: 50px;"
                                                                            src="{{ asset('assets/media/logos/perfectpanel.png') }}">
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Perfect Panel</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    name="integration" value="2"
                                                                    {{ isset($store) && $store->integration == 2 ? 'checked' : '' }} />
                                                            </span>
                                                            <!--end:Input-->

                                                        </label>
                                                        <!--begin::key integration-->
                                                        <div class="perfect-panel p-4" style="display: none">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Integration Key</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="key-perfect"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('key', isset($store) ? $store->key : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A integration key is required
                                                                and recommended for Perfect panel.</div>
                                                            <!--end::Description-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Affiliate Commission
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="afc-perfect"
                                                                    value="0" />
                                                                <input class="form-check-input afc-perfect"
                                                                    name="afc-perfect" type="checkbox" value="1"
                                                                    {{ old('afc', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->afc == 1 ? 'checked' : '' }}
                                                                    id="afc" />
                                                                <label class="form-check-label" for="afc"></label>
                                                            </div>
                                                            <!--end::Input-->
                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Bonus</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="bonus" value="0" />
                                                                <input class="form-check-input bonus" name="bonus"
                                                                    type="checkbox" value="1"
                                                                    {{ old('bonus', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->bonus == 1 ? 'checked' : '' }}
                                                                    id="bonus" />
                                                                <label class="form-check-label" for="bonus"></label>
                                                            </div>

                                                            <div class="bonus-form p-4" style="display: none;">
                                                                <br>
                                                                <label class="required form-label">Bonus amount</label>
                                                                <input type="number" min="0.01" max="100"
                                                                    step="0.01" aria-required="true"
                                                                    name="bonus_amount"
                                                                    class="form-control mb-2 bonus_amount" placeholder=""
                                                                    value="{{ old('bonus_amount', isset($store) ? $store->bonus_amount : '') }}" />
                                                                <label class="required form-label">Deposit from</label>
                                                                <input type="number" min="0" step="0.01"
                                                                    aria-required="true" name="bonus_from"
                                                                    class="form-control mb-2 bonus_from" placeholder=""
                                                                    value="{{ old('bonus_from', isset($store) ? $store->bonus_from : '') }}" />
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!--end::key integration-->
                                                        <!--end::Option-->
                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-warning">
                                                                        <img style="height: 40px;width: 50px;"
                                                                            src="{{ asset('assets/media/logos/socpanel.png') }}">
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Soc Panel</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    name="integration" value="3"
                                                                    {{ isset($store) && $store->integration == 3 ? 'checked' : '' }} />
                                                            </span>
                                                            <!--end:Input-->

                                                        </label>
                                                        <!--begin::key integration-->
                                                        <div class="soc-panel p-4" style="display: none">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Integration Key</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="key-soc"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('key', isset($store) ? $store->key : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A integration key is required
                                                                and recommended for Soc panel.</div>
                                                            <!--end::Description-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Bonus</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="bonus-soc" value="0" />
                                                                <input class="form-check-input bonus-soc" name="bonus-soc"
                                                                    type="checkbox" value="1"
                                                                    {{ old('bonus', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->bonus == 1 ? 'checked' : '' }}
                                                                    id="bonus" />
                                                                <label class="form-check-label" for="bonus"></label>
                                                            </div>

                                                            <div class="bonus-form-soc p-4" style="display: none;">
                                                                <br>
                                                                <label class="required form-label">Bonus amount</label>
                                                                <input type="number" min="0.01" max="100"
                                                                    step="0.01" aria-required="true"
                                                                    name="bonus_amount-soc"
                                                                    class="form-control mb-2 bonus_amount-soc"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_amount', isset($store) ? $store->bonus_amount : '') }}" />
                                                                <label class="required form-label">Deposit from</label>
                                                                <input type="number" min="0" step="0.01"
                                                                    aria-required="true" name="bonus_from-soc"
                                                                    class="form-control mb-2 bonus_from-soc"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_from', isset($store) ? $store->bonus_from : '') }}" />
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!--end::key integration-->
                                                        <!--end::Option-->

                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <img style="height: 40px;width: 50px;"
                                                                            src="{{ asset('assets/media/logos/amzingpanel.png') }}">
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Amazing Panel</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    name="integration" value="4"
                                                                    {{ isset($store) && $store->integration == 4 ? 'checked' : '' }} />
                                                            </span>
                                                            <!--end:Input-->

                                                        </label>
                                                        <!--begin::key integration-->
                                                        <div class="amazing-panel p-4" style="display: none">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Integration Key</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="key-amazing"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('key', isset($store) ? $store->key : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A integration key is required
                                                                and recommended for Custom panel.</div>
                                                            <!--end::Description-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Affiliate Commission</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="afc-amazing"
                                                                    value="0" />
                                                                <input class="form-check-input afc-amazing"
                                                                    name="afc-amazing" type="checkbox" value="1"
                                                                    {{ old('afc', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->afc == 1 ? 'checked' : '' }}
                                                                    id="afc" />
                                                                <label class="form-check-label" for="afc"></label>
                                                            </div>
                                                            <!--end::Input-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Bonus</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="bonus-amazing"
                                                                    value="0" />
                                                                <input class="form-check-input bonus-amazing"
                                                                    name="bonus-amazing" type="checkbox" value="1"
                                                                    {{ old('bonus', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->bonus == 1 ? 'checked' : '' }}
                                                                    id="bonus" />
                                                                <label class="form-check-label" for="bonus"></label>
                                                            </div>

                                                            <div class="bonus-form-amazing p-4" style="display: none;">
                                                                <br>
                                                                <label class="required form-label">Bonus amount</label>
                                                                <input type="number" min="0.01" max="100"
                                                                    step="0.01" aria-required="true"
                                                                    name="bonus_amount-amazing"
                                                                    class="form-control mb-2 bonus_amount-amazing"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_amount', isset($store) ? $store->bonus_amount : '') }}" />
                                                                <label class="required form-label">Deposit from</label>
                                                                <input type="number" min="0" step="0.01"
                                                                    aria-required="true" name="bonus_from-amazing"
                                                                    class="form-control mb-2 bonus_from-amazing"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_from', isset($store) ? $store->bonus_from : '') }}" />
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!--end::key integration-->
                                                        <!--end::Option-->


                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <img style="height: 40px;width: 50px;"
                                                                            src="{{ asset('assets/media/logos/amzingpanel.png') }}">
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Child Panel</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    name="integration" value="5"
                                                                    {{ isset($store) && $store->integration == 5 ? 'checked' : '' }} />
                                                            </span>
                                                            <!--end:Input-->

                                                        </label>
                                                        <!--begin::key integration-->
                                                        <div class="child-panel p-4" style="display: none">

                                                            <!--begin::Label-->
                                                            <label class="required form-label">Username</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="username_chaild"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('username_chaild', isset($store) ? $store->username_chaild : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">Username is required.</div>
                                                            <!--end::Description-->
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Password</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="password_chaild"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('password_chaild', isset($store) ? $store->password_chaild : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">Password is required.</div>
                                                            <!--end::Description-->

                                                            <!--begin::Label-->
                                                            <label class="required form-label">Integration Key</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="key-child"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('key', isset($store) ? $store->key : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A integration key is required
                                                                and recommended for Custom panel.</div>
                                                            <!--end::Description-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Affiliate Commission</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="afc-child" value="0" />
                                                                <input class="form-check-input afc-child" name="afc-child"
                                                                    type="checkbox" value="1"
                                                                    {{ old('afc', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->afc == 1 ? 'checked' : '' }}
                                                                    id="afc" />
                                                                <label class="form-check-label" for="afc"></label>
                                                            </div>
                                                            <!--end::Input-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Bonus</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="bonus-child"
                                                                    value="0" />
                                                                <input class="form-check-input bonus-child"
                                                                    name="bonus-child" type="checkbox" value="1"
                                                                    {{ old('bonus', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->bonus == 1 ? 'checked' : '' }}
                                                                    id="bonus" />
                                                                <label class="form-check-label" for="bonus"></label>
                                                            </div>

                                                            <div class="bonus-form-child p-4" style="display: none;">
                                                                <br>
                                                                <label class="required form-label">Bonus amount</label>
                                                                <input type="number" min="0.01" max="100"
                                                                    step="0.01" aria-required="true"
                                                                    name="bonus_amount-child"
                                                                    class="form-control mb-2 bonus_amount-child"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_amount', isset($store) ? $store->bonus_amount : '') }}" />
                                                                <label class="required form-label">Deposit from</label>
                                                                <input type="number" min="0" step="0.01"
                                                                    aria-required="true" name="bonus_from-child"
                                                                    class="form-control mb-2 bonus_from-child"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_from', isset($store) ? $store->bonus_from : '') }}" />
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!--end::key integration-->
                                                        <!--end::Option-->
                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <img style="height: 40px;width: 50px;"
                                                                            src="{{ asset('assets/media/logos/amzingpanel.png') }}">
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Custom Panel</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    name="integration" value="6"
                                                                    {{ isset($store) && $store->integration == 6 ? 'checked' : '' }} />
                                                            </span>
                                                            <!--end:Input-->

                                                        </label>
                                                        <!--begin::key integration-->
                                                        <div class="custom-panel p-4" style="display: none">

                                                            <!--begin::Label-->
                                                            <label class="required form-label">Integration Key</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="key-custom"
                                                                class="form-control mb-2 key" placeholder=""
                                                                value="{{ old('key', isset($store) ? $store->key : '') }}" />
                                                            <!--end::Input-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7">A integration key is required
                                                                and recommended for Custom panel.</div>
                                                            <!--end::Description-->

                                                            <!--end::Input-->

                                                            <br>
                                                            <!--begin::Label-->
                                                            <label class="form-label">Bonus</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <div
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <input type="hidden" name="bonus-custom"
                                                                    value="0" />
                                                                <input class="form-check-input bonus-custom"
                                                                    name="bonus-custom" type="checkbox" value="1"
                                                                    {{ old('bonus', 0) === 1 ? 'checked' : '' }}
                                                                    {{ isset($store) && $store->bonus == 1 ? 'checked' : '' }}
                                                                    id="bonus" />
                                                                <label class="form-check-label" for="bonus"></label>
                                                            </div>

                                                            <div class="bonus-form-custom p-4" style="display: none;">
                                                                <br>
                                                                <label class="required form-label">Bonus amount</label>
                                                                <input type="number" min="0.01" max="100"
                                                                    step="0.01" aria-required="true"
                                                                    name="bonus_amount-custom"
                                                                    class="form-control mb-2 bonus_amount-custom"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_amount', isset($store) ? $store->bonus_amount : '') }}" />
                                                                <label class="required form-label">Deposit from</label>
                                                                <input type="number" min="0" step="0.01"
                                                                    aria-required="true" name="bonus_from-custom"
                                                                    class="form-control mb-2 bonus_from-custom"
                                                                    placeholder=""
                                                                    value="{{ old('bonus_from', isset($store) ? $store->bonus_from : '') }}" />
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!--end::key integration-->
                                                        <!--end::Option-->

                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <span class="symbol symbol-50px me-6">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <i class="fa-solid fa-code text-primary fs-2x"></i>
                                                                    </span>
                                                                </span>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <span class="fw-bold fs-6">Custom Api</span>
                                                                    <span class="fs-7 text-muted"></span>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                            <!--begin:Input-->
                                                            <span class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input integration" type="radio"
                                                                    name="integration" value="7"
                                                                    {{ isset($store) && $store->integration == 7 ? 'checked' : '' }} />
                                                            </span>
                                                            <!--end:Input-->
                                                        </label>
                                                        <!--end::Option-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Description-->
                                                    <div class="text-muted fs-7">Set your integration.</div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Card header-->
                                            </div>
                                            <!--end::integration-->
                                            <!--begin::Connected Accounts-->
                                            <!--end::Connected Accounts-->

                                        </div>
                                        <!--end::Tab integration-->
                                        <!--begin::Tab providers-->
                                        <div class="tab-pane fade show" id="Kt_providers" role="tab-panel">
                                            <!--begin::Connected Accounts-->
                                            <div class="card mb-5 mb-xl-10">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0 cursor-pointer" role="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#kt_account_connected_accounts" aria-expanded="true"
                                                    aria-controls="kt_account_connected_accounts">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">Providers</h3>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Content-->
                                                <div id="kt_account_settings_connected_accounts" class="collapse show">
                                                    <!--begin::Card body-->
                                                    <div class="d-flex flex-stack">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_ecommerce_sales_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                                    <th class="text-center min-w-100px">Icon</th>
                                                                    <th class="text-center min-w-100px">Name</th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-semibold text-gray-600">
                                                                @foreach ($providers as $provider)
                                                                    @php
                                                                        $currentValue = isset($store)
                                                                            ? $store
                                                                                ->providers()
                                                                                ->where('provider_id', $provider->id)
                                                                                ->first()
                                                                            : null;

                                                                    @endphp
                                                                    <tr>
                                                                        <!--begin::Icon=-->
                                                                        <td class="text-center">
                                                                            <div class="me-7 mb-4">
                                                                                <div
                                                                                    class="symbol symbol-60px symbol-lg-50px symbol-fixed position-relative">
                                                                                    <img src="{{ $provider->full_icon_url }}"
                                                                                        alt="{{ $provider->name }}">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <!--end::Icon=-->
                                                                        <td class="text-center">
                                                                            {{ $provider->name }}
                                                                        </td>

                                                                        <td class="text-center">
                                                                            {{-- @dump($currentValue); --}}
                                                                            <div
                                                                                class="form-check form-check-solid form-check-custom form-switch">
                                                                                <input type="hidden"
                                                                                    name="providers[{{ $provider->id }}]"
                                                                                    value="0">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="providers[{{ $provider->id }}]"
                                                                                    value="1"
                                                                                    {{ $currentValue ? ($currentValue->status == 1 ? 'checked' : '') : 'checked' }}>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Connected Accounts-->

                                        </div>
                                        <!--end::Tab providers-->

                                    </div>
                                    <!--end::Tab content-->
                                    <div class="d-flex justify-content-end">
                                        <!--begin::Button-->
                                        <a href="/stores" class="btn btn-light me-5">Cancel</a>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">{{ isset($store) ? 'Update' : 'Save' }}</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                                <!--end::Main column-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        @if (!isset($store))
            <script>
                $(document).ready(function() {
                    $('#ratesync_check').prop('checked', false);
                    $('#rate_option').hide();

                    $('#ratesync_check').change(function() {
                        if ($(this).is(':checked')) {
                            $('#rate_option').show();
                            $('#CurrencyRateset').val("0.00");
                            $('#CurrencyRate').hide();

                        } else {
                            $('#rate_option').hide();
                            $('#CurrencyRate').show();
                            $('#CurrencyRateset').val("");
                        }
                    });
                });
            </script>
        @else
            <script>
                $(document).ready(function() {
                    if ({{ old('ratesync', isset($store) ? $store->ratesync : '') }} == 0) {
                        $('#ratesync_check').prop('checked', false);
                        $('#rate_option').hide();
                    } else {
                        $('#ratesync_check').prop('checked', true);
                        $('#CurrencyRate').hide();
                        $('#rate_option').show();

                    }
                    $('#ratesync_check').change(function() {
                        if ($(this).is(':checked')) {
                            $('#rate_option').show();
                            $('#CurrencyRate').hide();
                        } else {
                            $('#rate_option').hide();
                            $('#CurrencyRate').show();
                        }
                    });
                });
            </script>
        @endif
    @endpush

    @push('js')
        <script>
            $(document).ready(function() {

                let integration = $("input[name='integration']:checked");
                if (integration.val() == 2) {
                    $('.perfect-panel').css('display', 'block');
                }
                if (integration.val() == 3) {
                    $('.soc-panel').css('display', 'block');
                }
                if (integration.val() == 4) {
                    $('.amazing-panel').css('display', 'block');
                }
                if (integration.val() == 5) {
                    $('.child-panel').css('display', 'block');
                }
                if (integration.val() == 6) {
                    $('.custom-panel').css('display', 'block');
                }



                $('.integration').change(function() {
                    $val = $(this).val();
                    if ($val == 2) {
                        $('.perfect-panel').css('display', 'block');
                    } else {
                        $('.perfect-panel').hide();
                    }
                    if ($val == 3) {
                        $('.soc-panel').css('display', 'block');
                    } else {
                        $('.soc-panel').hide();
                    }
                    if ($val == 4) {
                        $('.amazing-panel').css('display', 'block');
                    } else {
                        $('.amazing-panel').hide();
                    }
                    if ($val == 5) {
                        $('.child-panel').css('display', 'block');
                    } else {
                        $('.child-panel').hide();
                    }
                    if ($val == 6) {
                        $('.custom-panel').css('display', 'block');
                    } else {
                        $('.custom-panel').hide();
                    }



                }) //integration change if it perfect panel.
            })
        </script>

        <script>
            // Get the bonus checkbox element
            var bonusCheckbox = document.querySelector('.bonus');

            // Get the bonus form element
            var bonusForm = document.querySelector('.bonus-form');

            // Check if the bonus checkbox is checked on page load
            if (bonusCheckbox.checked) {
                // Show the bonus form if the checkbox is checked
                bonusForm.style.display = 'block';
            }

            // Add an event listener to the bonus checkbox
            bonusCheckbox.addEventListener('change', function() {
                // If the checkbox is checked
                if (bonusCheckbox.checked) {
                    // Show the bonus form
                    bonusForm.style.display = 'block';
                } else {
                    // Hide the bonus form
                    bonusForm.style.display = 'none';
                }
            });
        </script>

        <script>
            // Get the bonus checkbox element
            var bonusCheckboxSoc = document.querySelector('.bonus-soc');
            var bonusCheckboxAmazing = document.querySelector('.bonus-amazing');
            var bonusCheckboxChild = document.querySelector('.bonus-child');
            var bonusCheckboxCustom = document.querySelector('.bonus-custom');

            // Get the bonus form element
            var bonusFormSoc = document.querySelector('.bonus-form-soc');
            var bonusFormAmazing = document.querySelector('.bonus-form-amazing');
            var bonusFormChild = document.querySelector('.bonus-form-child');
            var bonusFormCustom = document.querySelector('.bonus-form-custom');

            // Check if the bonus checkbox is checked on page load
            if (bonusCheckboxSoc.checked) {
                // Show the bonus form if the checkbox is checked
                bonusFormSoc.style.display = 'block';
            }

            if (bonusCheckboxAmazing.checked) {
                // Show the bonus form if the checkbox is checked
                bonusFormAmazing.style.display = 'block';
            }

            if (bonusCheckboxChild.checked) {
                // Show the bonus form if the checkbox is checked
                bonusFormChild.style.display = 'block';
            }

            if (bonusCheckboxCustom.checked) {
                // Show the bonus form if the checkbox is checked
                bonusFormCustom.style.display = 'block';
            }

            // Add an event listener to the bonus checkbox
            bonusCheckboxSoc.addEventListener('change', function() {
                // If the checkbox is checked
                if (bonusCheckboxSoc.checked) {
                    // Show the bonus form
                    bonusFormSoc.style.display = 'block';
                } else {
                    // Hide the bonus form
                    bonusFormSoc.style.display = 'none';
                }
            });

            // Add an event listener to the bonus checkbox
            bonusCheckboxAmazing.addEventListener('change', function() {
                // If the checkbox is checked
                if (bonusCheckboxAmazing.checked) {
                    // Show the bonus form
                    bonusFormAmazing.style.display = 'block';
                } else {
                    // Hide the bonus form
                    bonusFormAmazing.style.display = 'none';
                }
            });

            // Add an event listener to the bonus checkbox
            bonusCheckboxChild.addEventListener('change', function() {
                // If the checkbox is checked
                if (bonusCheckboxChild.checked) {
                    // Show the bonus form
                    bonusFormChild.style.display = 'block';
                } else {
                    // Hide the bonus form
                    bonusFormChild.style.display = 'none';
                }
            });

            // Add an event listener to the bonus checkbox
            bonusCheckboxCustom.addEventListener('change', function() {
                // If the checkbox is checked
                if (bonusCheckboxCustom.checked) {
                    // Show the bonus form
                    bonusFormCustom.style.display = 'block';
                } else {
                    // Hide the bonus form
                    bonusFormCustom.style.display = 'none';
                }
            });
        </script>

        <!--begin::Javascript-->
        <script>
            var hostUrl = "assets/";
        </script>
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Vendors Javascript(used by this page)-->
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
        <!--end::Vendors Javascript-->
        <!--begin::Custom Javascript(used by this page)-->
        <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        {{-- <script src="assets/js/custom/widgets.js"></script> --}}
        {{-- <script src="assets/js/custom/apps/chat/chat.js"></script> --}}
        <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
        <!--end::Custom Javascript-->
        <!--end::Javascript-->
    @endpush
