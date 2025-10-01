@extends('front.layouts.app', ['title' => __('Integration'), 'current' => 'integration'])
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <form method="post" action="" id="change_api" class="form d-flex flex-column flex-lg-row" data-kt-redirect="#"
                enctype="multipart/form-data">
                @csrf
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Integration</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-0 fv-row">
                                <textarea name="" id="" cols="170" rows="50">
                                    <div class="row" style="align-items: center;">
                                        <div>


                                        </div>
                                        <div>
                                            <h5 style="font-family: 'Poppins', sans-serif; color:#ffb500; text-align: center;">
                                                <p style="color: rgb(223, 224, 225); font-family: " helvetica="" neue",="" helvetica,="" arial,="" sans-serif;"=""><br><br></p>
                                            </h5>
                                            <h5 style="font-family: 'Poppins', sans-serif; color:#ffb500; text-align: center;"><b>
                                                </b></h5>
                                        </div>



                                        <div class="col-lg-12">
                                            <div id="message"></div>
                                            <p style="text-align: center;"><img src="https://cdn.mypanel.link/imkqah/gdibq0zfwhf9tzsi.png" style="display: inline-block; width: 267px; max-width: 100%;" class="img-responsive"><font color="#295218"><b><br></b></font></p><p style="text-align: center;"><br></p><p style="text-align: center;"><b>&nbsp;بعد التحويل قم بتاكيد التحويل من خلال كتابة رقم الهاتف الذي قمت بالتحويل من خلاله في خانه رقم الهاتف</b></p><p style="text-align: center;"><b>وكتابة المبلغ الذي قمت بتحويله بالجنيه المصري في خانة المبلغ</b></p><p style="text-align: center;"><b><br></b></p><p style="text-align: center;"><b>الرجاء الانتظار 5 دقائق في حالة فشل التاكيد والمحاولة مره اخري</b></p><p style="text-align: center;"><br></p><div><br></div>


                                            <br>

                                            <div class="form-group" style="display: block;">
                                              <label for="rate" class="control-label">
                                                <span id="rate_label">سعر دولار الشحن اليوم</span>
                                                <span id="rate_label" class="hidden"></span>
                                              </label>
                                              <span class="btn btn-block btn-big-primary" id="rate">N/A</span>
                                            </div>

                                            <br>

                                            <div class="form-group" style="display: block;" id="numberInputsContainer">
                                                <label for="mobile_wallet" class="control-label"><span id="phone_label">رقم المحفظة (فودافون كاش)</span><span id="mobile_wallet_label" class="hidden"></span></label>
                                              </div>

                                            <div class="form-group" style="display: block;">
                                                <label for="phone" class="control-label"><span id="phone_label">رقم الهاتف</span> <span id="phone_label" class="hidden"></span></label>
                                                <input class="form-control" name="phone" value="" placeholder="01000000000" type="text" id="phone">
                                            </div>
                                            <div class="form-group" style="display: block;">
                                                <label for="amount" class="control-label"><span id="amount_label">المبلغ</span> <span id="amount_label" class="hidden"></span></label>
                                                <input class="form-control" name="amount" value="" type="number" id="amount">
                                            </div>

                                    <a href="javascript:;" id="payButton" onclick="goto();" class="btn btn-block btn-big-primary">Pay</a>

                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js"></script>
                                    <script>
                                        var requestOptions = {
                                            method: 'GET',
                                            redirect: 'follow'
                                        };

                                        fetch("{{ route('front.home') }}/api/stores/payment_info/{{ $store->id }}", requestOptions)
                                            .then(response => response.json())
                                            .then(result => {

                                                // Extracting the numbers from the response
                                                var numbers = result.number;
                                                var rateValue = result.rate;

                                                // Displaying each number in a separate input field
                                                var container = document.getElementById("numberInputsContainer");

                                                numbers.forEach(function (number, index) {
                                                    var inputField = document.createElement("div");
                                                    inputField.className = "mx-auto";
                                                    inputField.style = "width: fit-content;margin-bottom: 10px;";
                                                    inputField.innerHTML = `
                                                        <div class="input-group">
                                                                <span id="mobile_wallet_${index}" name="mobile_wallet_${index}" class="badge py-2 px-2 badge-success" style="border-top-right-radius: 0px; border-bottom-right-radius: 0px; font-size: 20px;">
                                                                    <b id="numbercash0">${number}</b>
                                                                </span>
                                                                <div class="input-group-append">
                                                                    <span class="btn btn-big-secondary py-2 px-2" data-clip="true" title="" data-clipboard-action="copy" data-clipboard-target="#mobile_wallet_${index}" data-original-title="" style="border: 0px; background-color: #28a745;">
                                                                        <span class="fas fa-clone" style="color: #fff;"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            `;
                                                    container.appendChild(inputField);
                                                });
                                                  document.getElementById('rate').innerText = '1 USD = ' + rateValue + ' LYD';
                                            })
                                            .catch(error => console.log('error', error));
                                    </script>

                                    <script>
                                        function addTranslateAttribute() {
                                          var element = document.querySelector('.totals-block__count-value');
                                          element.setAttribute('translate', 'no');
                                        }

                                        const lang = document.documentElement.lang;

                                        let usernameValue;
                                        fetch("/account")
                                            .then(response => {
                                                return response.text();
                                            })
                                            .then(html => {
                                                var tempDiv = document.createElement("div");
                                                tempDiv.innerHTML = html;
                                                var usernameElement = tempDiv.querySelector("#username");
                                                if (usernameElement) {
                                                    usernameValue = usernameElement.value;
                                                }
                                            });
                                        function goto() {
                                            const payButton = document.getElementById('payButton');
                                            payButton.setAttribute('disabled', 'disabled');

                                            let data = {
                                                user_name: usernameValue,
                                                phone: document.getElementById('phone').value,
                                                amount: document.getElementById('amount').value,
                                            };

                                            console.log(data);

                                            const url = "{{ route('front.home') }}/api/stores/payment_link_check?phone=${data['phone']}&amount=${data['amount']}&user_name=${data['user_name']}&store_id={{ $store->id }}&lang=${lang}";

                                            fetch(url, { method: 'GET', redirect: 'follow' })
                                                .then(response => response.json())
                                                .then(result => {
                                                    document.getElementById('message').innerHTML = result['message'];
                                                    if (document.getElementById('message').innerHTML === "<div class=\"alert alert-primary\">Success Transaction<\/div>") {
                                                        setTimeout(() => {
                                                            document.location.reload();
                                                        }, 5000);
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error(error);
                                                    document.getElementById('message').innerHTML = "Error occurred while processing your request.";
                                                });

                                            document.getElementById('phone').value = null;
                                            document.getElementById('amount').value = null;

                                        }
                                    </script>

                                    </div>

                                    </div>

                                </textarea>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!--end::Input group-->
                        </div>
                        <!--end::Card header-->




                    </div>
                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('js')
    <script src="{{ url('assets/js/custom/apps/customers/list/export.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script src="{{ url('assets/js/custom/apps/customers/add.js') }}"></script>
@endpush
