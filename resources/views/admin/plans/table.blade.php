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
                <th class="text-center min-w-100px">Name</th>
                <th class="text-center min-w-100px">Monthly transactions</th>
                <th class="text-center min-w-100px">Price</th>
                <th class="text-center min-w-100px">Status</th>
                <th class="text-center min-w-100px">Created</th>
                <th class="text-center min-w-100px">Actions</th>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-semibold text-gray-600">
            @foreach ($plans as $plan)
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
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $plan->id }}</a>
                    </td>
                    <td class="text-center">
                        {{ $plan->name }}
                    </td>
                    <td class="text-center">
                        {{ $plan->min }} - {{ $plan->max }}
                    </td>
                    <td class="text-center">
                        {{ $plan->cost }}
                    </td>
                    <td class="text-center">
                        <!--begin::Badges-->
                        @if ($plan->status == 0)
                            <div class="badge badge-light-danger">Disabled</div>
                        @else
                            <div class="badge badge-light-success text-success">Enabled</div>
                        @endif
                        <!--end::Badges-->
                    </td>
                    <td class="text-center pe-0">
                        <span class="text-gray-600 fw-bold fs-6">{{ $plan->created_at }}</span>
                    </td>
                    {{-- <td class="text-end pe-12">
                    <span class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\Campaign::STATUSES_CLASSES[$campaign->status] }}">{{ App\Models\Campaign::STATUSES[$campaign->status] }}</span>
</td> --}}

                    <td class="text-center d-flex">
                        @include('admin.layouts.actions', [
                            'id' => $plan->id,
                            'edit' => route('admin.plans.edit', $plan->id),
                            // 'destroy' => route('admin.plans.destroy', $plan->id),
                        ])
                    </td>
                </tr>
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
</div>
<!--end::Table-->
