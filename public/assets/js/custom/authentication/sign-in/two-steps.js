"use strict";

// Class Definition
var KTSigninTwoSteps = function () {
    // Elements
    var form;
    var submitButton;

    // Handle form
    var handleForm = function (e) {
        // Handle form submit
        submitButton.addEventListener('click', function (e) {


            var validated = true;
            var finalCode = '';

            var inputs = [].slice.call(form.querySelectorAll('input[maxlength="1"]'));
            inputs.map(function (input) {
                if (input.value === '' || input.value.length === 0) {
                    validated = false;
                }
                finalCode += input.value;
            });

            if (validated === false) {
                e.preventDefault();
                swal.fire({
                    text: "برجاء إدخال كود التحقق الذي تم إرساله إلى هاتفك.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "حسناً",
                    customClass: {
                        confirmButton: "btn fw-bold btn-light-primary"
                    }
                }).then(function () {
                    KTUtil.scrollTop();
                });
            } else {
                $('#finalCode').val(finalCode);
            }
        });
    }

    var handleType = function () {
        var input1 = form.querySelector("[name=code_1]");
        var input2 = form.querySelector("[name=code_2]");
        var input3 = form.querySelector("[name=code_3]");
        var input4 = form.querySelector("[name=code_4]");
        var input5 = form.querySelector("[name=code_5]");
        var input6 = form.querySelector("[name=code_6]");

        input1.focus();

        input1.addEventListener("keyup", function () {
            if (this.value.length === 1) {
                input2.focus();
            }
        });

        input2.addEventListener("keyup", function () {
            if (this.value.length === 1) {
                input3.focus();
            }
        });

        input3.addEventListener("keyup", function () {
            if (this.value.length === 1) {
                input4.focus();
            }
        });

        input4.addEventListener("keyup", function () {
            if (this.value.length === 1) {
                input5.focus();
            }
        });

        input5.addEventListener("keyup", function () {
            if (this.value.length === 1) {
                input6.focus();
            }
        });

        input6.addEventListener("keyup", function () {
            if (this.value.length === 1) {
                input6.blur();
            }
        });
    }

    // Public functions
    return {
        // Initialization
        init: function () {
            form = document.querySelector('#kt_sing_in_two_steps_form');
            submitButton = document.querySelector('#kt_sing_in_two_steps_submit');

            handleForm();
            handleType();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTSigninTwoSteps.init();
});
