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
                    <form id="kt_account_profile_details_form" class="form">
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
                                            <input type="text" name="fname"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                placeholder="First name" value="Max" />
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="lname"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Last name" value="Smith" />
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
                                    <input type="text" name="company"
                                        class="form-control form-control-lg form-control-solid" placeholder="Company name"
                                        value="Keenthemes" />
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
                                    <input type="tel" name="phone"
                                        class="form-control form-control-lg form-control-solid" placeholder="Phone number"
                                        value="044 3276 454 935" />
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
                                    <input type="text" name="website"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Company website" value="keenthemes.com" />
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
                                        @foreach ($countries as $key => $country)
                                        <option value="{{ $key }}">{{ $country }}</option>
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
                                    <select name="timezone" aria-label="Select a Timezone" data-control="select2"
                                        data-placeholder="Select a timezone.."
                                        class="form-select form-select-solid form-select-lg">
                                        <option value="">Select a Timezone..</option>
                                        <option data-bs-offset="-39600" value="International Date Line West">(GMT-11:00)
                                            International Date Line West</option>
                                        <option data-bs-offset="-39600" value="Midway Island">(GMT-11:00) Midway Island
                                        </option>
                                        <option data-bs-offset="-39600" value="Samoa">(GMT-11:00) Samoa</option>
                                        <option data-bs-offset="-36000" value="Hawaii">(GMT-10:00) Hawaii</option>
                                        <option data-bs-offset="-28800" value="Alaska">(GMT-08:00) Alaska</option>
                                        <option data-bs-offset="-25200" value="Pacific Time (US & Canada)">(GMT-07:00)
                                            Pacific Time (US & Canada)</option>
                                        <option data-bs-offset="-25200" value="Tijuana">(GMT-07:00) Tijuana</option>
                                        <option data-bs-offset="-25200" value="Arizona">(GMT-07:00) Arizona</option>
                                        <option data-bs-offset="-21600" value="Mountain Time (US & Canada)">(GMT-06:00)
                                            Mountain Time (US & Canada)</option>
                                        <option data-bs-offset="-21600" value="Chihuahua">(GMT-06:00) Chihuahua</option>
                                        <option data-bs-offset="-21600" value="Mazatlan">(GMT-06:00) Mazatlan</option>
                                        <option data-bs-offset="-21600" value="Saskatchewan">(GMT-06:00) Saskatchewan
                                        </option>
                                        <option data-bs-offset="-21600" value="Central America">(GMT-06:00) Central
                                            America</option>
                                        <option data-bs-offset="-18000" value="Central Time (US & Canada)">(GMT-05:00)
                                            Central Time (US & Canada)</option>
                                        <option data-bs-offset="-18000" value="Guadalajara">(GMT-05:00) Guadalajara
                                        </option>
                                        <option data-bs-offset="-18000" value="Mexico City">(GMT-05:00) Mexico City
                                        </option>
                                        <option data-bs-offset="-18000" value="Monterrey">(GMT-05:00) Monterrey</option>
                                        <option data-bs-offset="-18000" value="Bogota">(GMT-05:00) Bogota</option>
                                        <option data-bs-offset="-18000" value="Lima">(GMT-05:00) Lima</option>
                                        <option data-bs-offset="-18000" value="Quito">(GMT-05:00) Quito</option>
                                        <option data-bs-offset="-14400" value="Eastern Time (US & Canada)">(GMT-04:00)
                                            Eastern Time (US & Canada)</option>
                                        <option data-bs-offset="-14400" value="Indiana (East)">(GMT-04:00) Indiana (East)
                                        </option>
                                        <option data-bs-offset="-14400" value="Caracas">(GMT-04:00) Caracas</option>
                                        <option data-bs-offset="-14400" value="La Paz">(GMT-04:00) La Paz</option>
                                        <option data-bs-offset="-14400" value="Georgetown">(GMT-04:00) Georgetown</option>
                                        <option data-bs-offset="-10800" value="Atlantic Time (Canada)">(GMT-03:00)
                                            Atlantic Time (Canada)</option>
                                        <option data-bs-offset="-10800" value="Santiago">(GMT-03:00) Santiago</option>
                                        <option data-bs-offset="-10800" value="Brasilia">(GMT-03:00) Brasilia</option>
                                        <option data-bs-offset="-10800" value="Buenos Aires">(GMT-03:00) Buenos Aires
                                        </option>
                                        <option data-bs-offset="-9000" value="Newfoundland">(GMT-02:30) Newfoundland
                                        </option>
                                        <option data-bs-offset="-7200" value="Greenland">(GMT-02:00) Greenland</option>
                                        <option data-bs-offset="-7200" value="Mid-Atlantic">(GMT-02:00) Mid-Atlantic
                                        </option>
                                        <option data-bs-offset="-3600" value="Cape Verde Is.">(GMT-01:00) Cape Verde Is.
                                        </option>
                                        <option data-bs-offset="0" value="Azores">(GMT) Azores</option>
                                        <option data-bs-offset="0" value="Monrovia">(GMT) Monrovia</option>
                                        <option data-bs-offset="0" value="UTC">(GMT) UTC</option>
                                        <option data-bs-offset="3600" value="Dublin">(GMT+01:00) Dublin</option>
                                        <option data-bs-offset="3600" value="Edinburgh">(GMT+01:00) Edinburgh</option>
                                        <option data-bs-offset="3600" value="Lisbon">(GMT+01:00) Lisbon</option>
                                        <option data-bs-offset="3600" value="London">(GMT+01:00) London</option>
                                        <option data-bs-offset="3600" value="Casablanca">(GMT+01:00) Casablanca</option>
                                        <option data-bs-offset="3600" value="West Central Africa">(GMT+01:00) West Central
                                            Africa</option>
                                        <option data-bs-offset="7200" value="Belgrade">(GMT+02:00) Belgrade</option>
                                        <option data-bs-offset="7200" value="Bratislava">(GMT+02:00) Bratislava</option>
                                        <option data-bs-offset="7200" value="Budapest">(GMT+02:00) Budapest</option>
                                        <option data-bs-offset="7200" value="Ljubljana">(GMT+02:00) Ljubljana</option>
                                        <option data-bs-offset="7200" value="Prague">(GMT+02:00) Prague</option>
                                        <option data-bs-offset="7200" value="Sarajevo">(GMT+02:00) Sarajevo</option>
                                        <option data-bs-offset="7200" value="Skopje">(GMT+02:00) Skopje</option>
                                        <option data-bs-offset="7200" value="Warsaw">(GMT+02:00) Warsaw</option>
                                        <option data-bs-offset="7200" value="Zagreb">(GMT+02:00) Zagreb</option>
                                        <option data-bs-offset="7200" value="Brussels">(GMT+02:00) Brussels</option>
                                        <option data-bs-offset="7200" value="Copenhagen">(GMT+02:00) Copenhagen</option>
                                        <option data-bs-offset="7200" value="Madrid">(GMT+02:00) Madrid</option>
                                        <option data-bs-offset="7200" value="Paris">(GMT+02:00) Paris</option>
                                        <option data-bs-offset="7200" value="Amsterdam">(GMT+02:00) Amsterdam</option>
                                        <option data-bs-offset="7200" value="Berlin">(GMT+02:00) Berlin</option>
                                        <option data-bs-offset="7200" value="Bern">(GMT+02:00) Bern</option>
                                        <option data-bs-offset="7200" value="Rome">(GMT+02:00) Rome</option>
                                        <option data-bs-offset="7200" value="Stockholm">(GMT+02:00) Stockholm</option>
                                        <option data-bs-offset="7200" value="Vienna">(GMT+02:00) Vienna</option>
                                        <option data-bs-offset="7200" value="Cairo">(GMT+02:00) Cairo</option>
                                        <option data-bs-offset="7200" value="Harare">(GMT+02:00) Harare</option>
                                        <option data-bs-offset="7200" value="Pretoria">(GMT+02:00) Pretoria</option>
                                        <option data-bs-offset="10800" value="Bucharest">(GMT+03:00) Bucharest</option>
                                        <option data-bs-offset="10800" value="Helsinki">(GMT+03:00) Helsinki</option>
                                        <option data-bs-offset="10800" value="Kiev">(GMT+03:00) Kiev</option>
                                        <option data-bs-offset="10800" value="Kyiv">(GMT+03:00) Kyiv</option>
                                        <option data-bs-offset="10800" value="Riga">(GMT+03:00) Riga</option>
                                        <option data-bs-offset="10800" value="Sofia">(GMT+03:00) Sofia</option>
                                        <option data-bs-offset="10800" value="Tallinn">(GMT+03:00) Tallinn</option>
                                        <option data-bs-offset="10800" value="Vilnius">(GMT+03:00) Vilnius</option>
                                        <option data-bs-offset="10800" value="Athens">(GMT+03:00) Athens</option>
                                        <option data-bs-offset="10800" value="Istanbul">(GMT+03:00) Istanbul</option>
                                        <option data-bs-offset="10800" value="Minsk">(GMT+03:00) Minsk</option>
                                        <option data-bs-offset="10800" value="Jerusalem">(GMT+03:00) Jerusalem</option>
                                        <option data-bs-offset="10800" value="Moscow">(GMT+03:00) Moscow</option>
                                        <option data-bs-offset="10800" value="St. Petersburg">(GMT+03:00) St. Petersburg
                                        </option>
                                        <option data-bs-offset="10800" value="Volgograd">(GMT+03:00) Volgograd</option>
                                        <option data-bs-offset="10800" value="Kuwait">(GMT+03:00) Kuwait</option>
                                        <option data-bs-offset="10800" value="Riyadh">(GMT+03:00) Riyadh</option>
                                        <option data-bs-offset="10800" value="Nairobi">(GMT+03:00) Nairobi</option>
                                        <option data-bs-offset="10800" value="Baghdad">(GMT+03:00) Baghdad</option>
                                        <option data-bs-offset="14400" value="Abu Dhabi">(GMT+04:00) Abu Dhabi</option>
                                        <option data-bs-offset="14400" value="Muscat">(GMT+04:00) Muscat</option>
                                        <option data-bs-offset="14400" value="Baku">(GMT+04:00) Baku</option>
                                        <option data-bs-offset="14400" value="Tbilisi">(GMT+04:00) Tbilisi</option>
                                        <option data-bs-offset="14400" value="Yerevan">(GMT+04:00) Yerevan</option>
                                        <option data-bs-offset="16200" value="Tehran">(GMT+04:30) Tehran</option>
                                        <option data-bs-offset="16200" value="Kabul">(GMT+04:30) Kabul</option>
                                        <option data-bs-offset="18000" value="Ekaterinburg">(GMT+05:00) Ekaterinburg
                                        </option>
                                        <option data-bs-offset="18000" value="Islamabad">(GMT+05:00) Islamabad</option>
                                        <option data-bs-offset="18000" value="Karachi">(GMT+05:00) Karachi</option>
                                        <option data-bs-offset="18000" value="Tashkent">(GMT+05:00) Tashkent</option>
                                        <option data-bs-offset="19800" value="Chennai">(GMT+05:30) Chennai</option>
                                        <option data-bs-offset="19800" value="Kolkata">(GMT+05:30) Kolkata</option>
                                        <option data-bs-offset="19800" value="Mumbai">(GMT+05:30) Mumbai</option>
                                        <option data-bs-offset="19800" value="New Delhi">(GMT+05:30) New Delhi</option>
                                        <option data-bs-offset="19800" value="Sri Jayawardenepura">(GMT+05:30) Sri
                                            Jayawardenepura</option>
                                        <option data-bs-offset="20700" value="Kathmandu">(GMT+05:45) Kathmandu</option>
                                        <option data-bs-offset="21600" value="Astana">(GMT+06:00) Astana</option>
                                        <option data-bs-offset="21600" value="Dhaka">(GMT+06:00) Dhaka</option>
                                        <option data-bs-offset="21600" value="Almaty">(GMT+06:00) Almaty</option>
                                        <option data-bs-offset="21600" value="Urumqi">(GMT+06:00) Urumqi</option>
                                        <option data-bs-offset="23400" value="Rangoon">(GMT+06:30) Rangoon</option>
                                        <option data-bs-offset="25200" value="Novosibirsk">(GMT+07:00) Novosibirsk
                                        </option>
                                        <option data-bs-offset="25200" value="Bangkok">(GMT+07:00) Bangkok</option>
                                        <option data-bs-offset="25200" value="Hanoi">(GMT+07:00) Hanoi</option>
                                        <option data-bs-offset="25200" value="Jakarta">(GMT+07:00) Jakarta</option>
                                        <option data-bs-offset="25200" value="Krasnoyarsk">(GMT+07:00) Krasnoyarsk
                                        </option>
                                        <option data-bs-offset="28800" value="Beijing">(GMT+08:00) Beijing</option>
                                        <option data-bs-offset="28800" value="Chongqing">(GMT+08:00) Chongqing</option>
                                        <option data-bs-offset="28800" value="Hong Kong">(GMT+08:00) Hong Kong</option>
                                        <option data-bs-offset="28800" value="Kuala Lumpur">(GMT+08:00) Kuala Lumpur
                                        </option>
                                        <option data-bs-offset="28800" value="Singapore">(GMT+08:00) Singapore</option>
                                        <option data-bs-offset="28800" value="Taipei">(GMT+08:00) Taipei</option>
                                        <option data-bs-offset="28800" value="Perth">(GMT+08:00) Perth</option>
                                        <option data-bs-offset="28800" value="Irkutsk">(GMT+08:00) Irkutsk</option>
                                        <option data-bs-offset="28800" value="Ulaan Bataar">(GMT+08:00) Ulaan Bataar
                                        </option>
                                        <option data-bs-offset="32400" value="Seoul">(GMT+09:00) Seoul</option>
                                        <option data-bs-offset="32400" value="Osaka">(GMT+09:00) Osaka</option>
                                        <option data-bs-offset="32400" value="Sapporo">(GMT+09:00) Sapporo</option>
                                        <option data-bs-offset="32400" value="Tokyo">(GMT+09:00) Tokyo</option>
                                        <option data-bs-offset="32400" value="Yakutsk">(GMT+09:00) Yakutsk</option>
                                        <option data-bs-offset="34200" value="Darwin">(GMT+09:30) Darwin</option>
                                        <option data-bs-offset="34200" value="Adelaide">(GMT+09:30) Adelaide</option>
                                        <option data-bs-offset="36000" value="Canberra">(GMT+10:00) Canberra</option>
                                        <option data-bs-offset="36000" value="Melbourne">(GMT+10:00) Melbourne</option>
                                        <option data-bs-offset="36000" value="Sydney">(GMT+10:00) Sydney</option>
                                        <option data-bs-offset="36000" value="Brisbane">(GMT+10:00) Brisbane</option>
                                        <option data-bs-offset="36000" value="Hobart">(GMT+10:00) Hobart</option>
                                        <option data-bs-offset="36000" value="Vladivostok">(GMT+10:00) Vladivostok
                                        </option>
                                        <option data-bs-offset="36000" value="Guam">(GMT+10:00) Guam</option>
                                        <option data-bs-offset="36000" value="Port Moresby">(GMT+10:00) Port Moresby
                                        </option>
                                        <option data-bs-offset="36000" value="Solomon Is.">(GMT+10:00) Solomon Is.
                                        </option>
                                        <option data-bs-offset="39600" value="Magadan">(GMT+11:00) Magadan</option>
                                        <option data-bs-offset="39600" value="New Caledonia">(GMT+11:00) New Caledonia
                                        </option>
                                        <option data-bs-offset="43200" value="Fiji">(GMT+12:00) Fiji</option>
                                        <option data-bs-offset="43200" value="Kamchatka">(GMT+12:00) Kamchatka</option>
                                        <option data-bs-offset="43200" value="Marshall Is.">(GMT+12:00) Marshall Is.
                                        </option>
                                        <option data-bs-offset="43200" value="Auckland">(GMT+12:00) Auckland</option>
                                        <option data-bs-offset="43200" value="Wellington">(GMT+12:00) Wellington</option>
                                        <option data-bs-offset="46800" value="Nuku'alofa">(GMT+13:00) Nuku'alofa</option>
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
                        <!--begin::Email Address-->
                        <div class="d-flex flex-wrap align-items-center">
                            <!--begin::Label-->
                            <div id="kt_signin_email">
                                <div class="fs-6 fw-bold mb-1">Email Address</div>
                                <div class="fw-semibold text-gray-600">support@keenthemes.com</div>
                            </div>
                            <!--end::Label-->
											<!--begin::Edit-->
											<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
												<!--begin::Form-->
												<form id="kt_signin_change_email" class="form" novalidate="novalidate">
													<div class="row mb-6">
														<div class="col-lg-6 mb-4 mb-lg-0">
															<div class="fv-row mb-0">
																<label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New Email Address</label>
																<input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="emailaddress" value="support@keenthemes.com" />
															</div>
														</div>
														<div class="col-lg-6">
															<div class="fv-row mb-0">
																<label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
																<input type="password" class="form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" />
															</div>
														</div>
													</div>
													<div class="d-flex">
														<button id="kt_signin_submit" type="button" class="btn btn-primary me-2 px-6">Update Email</button>
														<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
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
                                <form id="kt_signin_change_password" class="form" novalidate="novalidate">
                                    <div class="row mb-1">
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="currentpassword" id="currentpassword" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="newpassword" id="newpassword" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm
                                                    New Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="confirmpassword" id="confirmpassword" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text mb-5">Password must be at least 8 character and contain symbols
                                    </div>
                                    <div class="d-flex">
                                        <button id="kt_password_submit" type="button"
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
