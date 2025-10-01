<div class="card-body pt-0">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
        <!--begin::Table head-->
        <thead>

            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                            data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1" />
                    </div>
                </th>
                <th class="min-w-70px">#</th>
                <th class="text-center min-w-100px">Icon</th>
                <th class="text-center min-w-100px">Name</th>
                <th class="text-center min-w-100px">Status</th>
                <th class="text-center min-w-100px">Created</th>
                <th class="text-center min-w-100px">Actions</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-semibold text-gray-600">
            @foreach ($providers as $provider)
                <tr>
                    <!--begin::Checkbox-->
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                    </td>
                    <!--end::Checkbox-->
                    <td>
                        <a href=""
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $provider->id }}</a>
                    </td>
                    <!--begin::Icon=-->
                        <td class="text-center">
                            <div class="me-7 mb-4">
                                <div class="symbol symbol-60px symbol-lg-50px symbol-fixed position-relative">
                                    <img src="{{ $provider->full_icon_url }}" alt="{{ $provider->name }}">
                                </div>
                            </div>
                    </td>
                    <!--end::Icon=-->
                    <td class="text-center">
                        {{ $provider->name }}
                    </td>
                    <td class="text-center">
                        <!--begin::Badges-->
                        @if ($provider->status == 0)
                            <div class="badge badge-light-danger">Disabled</div>
                        @else
                            <div class="badge badge-light-success text-success">Enabled</div>
                        @endif
                        <!--end::Badges-->
                    </td>
                    <td class="text-center pe-0">
                        <span class="text-gray-600 fw-bold fs-6">{{ $provider->created_at }}</span>
                    </td>
                    {{-- <td class="text-end pe-12">
                    <span class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\Campaign::STATUSES_CLASSES[$campaign->status] }}">{{ App\Models\Campaign::STATUSES[$campaign->status] }}</span>
</td> --}}

                    <td class="text-center d-flex">
                        @include('admin.layouts.actions', [
                            'id' => $provider->id,
                            'edit' => route('admin.providers.edit', $provider->id),
                            'destroy' => route('admin.providers.destroy', $provider->id),
                        ])
                    </td>
                </tr>
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
</div>
<!--end::Table-->
