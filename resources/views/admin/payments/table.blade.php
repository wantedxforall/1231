<div class="card-body pt-0">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_sales_table">
        <!--begin::Table head-->
        <thead>

            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="text-center min-w-50px">ID</th>
                <th class="text-center min-w-100px">Invoice ID</th>
                <th class="text-center min-w-100px">METHOD</th>
                <th class="text-center min-w-100px">Total</th>
                <th class="text-center min-w-100px">Status</th>
                <th class="text-center min-w-100px">MEMO</th>
                <th class="text-center min-w-100px">MESSAGE/REASON</th>
                <th class="text-center min-w-100px">CREATED</th>
                <th class="text-center min-w-100px">UPDATED</th>
                <th class="text-center min-w-100px">Actions</th>
            </tr>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody class="fw-semibold text-gray-600">
            @foreach ($payments as $payment)
                <!--begin::Table row-->
                <tr>
                    <!--begin::Order ID=-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $payment->reference }}</span>
                    </td>
                    <!--end::Order ID=-->
                    <!--begin::User=-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $payment->invoice_id }}</span>
                    </td>
                    <!--end::Method-->
                    <!--end::User=-->
                    <!--begin::Method-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $payment->method }}</span>
                    </td>
                    <!--end::Method-->
                    <!--begin::Amount=-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $payment->amount }}</span>
                    </td>
                    <!--end::Amount=-->
                    <!--begin::Status=-->
                    <td class="text-center pe-0">
                        <span
                            class="badge py-3 px-4 fs-7 badge-light-{{ App\Models\Payments::STATUSES_CLASSES[$payment->status] }}">{{ App\Models\Payments::STATUSES[$payment->status] }}</span>
                    </td>
                    <!--end::Status=-->
                    <!--begin::memo-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $payment->orderNo }}</span>
                    </td>
                    <!--end::memo-->
                    <!--begin::REASON-->
                    <td class="text-center pe-0">
                        <span class="fw-bold">{{ $payment->message }}</span>
                    </td>
                    <!--end::REASON-->
                    <!--begin::Date Modified=-->
                    <td class="text-center">
                        <span class="fw-bold">{{ $payment->created_at }}</span>
                    </td>
                    <!--end::Date Modified=-->
                    <!--begin::Date Modified=-->
                    <td class="text-center">
                        <span class="fw-bold">{{ $payment->created_at }}</span>
                    </td>
                    <!--end::Date Modified=-->
                    <!--begin::Action=-->

                    <!--end::Action=-->
                </tr>
                <!--end::Table row-->
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
</div>
<!--end::Table-->
