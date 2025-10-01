var divstoreid = document.querySelector("script[data-store-id]");

if (divstoreid) {
    var forstoreid = divstoreid.getAttribute("data-store-id");
    var scriptSrc = divstoreid.getAttribute("src");
    var baseUrl = new URL(scriptSrc).origin;
}

var langValue = document.querySelector("html").getAttribute("lang");

if (langValue) {
    var forlangsite = langValue;
}

if (typeof usernameValue === "undefined") {
    var usernameValue;
}

function PaymentInfo() {
    fetch(baseUrl + "/api/getPaymentInfo?store_id=" + forstoreid, {
        method: "GET",
    })
        .then((response) => response.json())
        .then((data) => {
            let numbers = data.number.split(",");
            let container = document.getElementById("storenumbers");
            if (container) {
                numbers.forEach((number, index) => {
                    let borderRadiusStyle =
                        "border-top-right-radius: 0px; border-bottom-right-radius: 0px;";
                    let borderRadiusStyleiconcopy =
                        "border-bottom-left-radius: 0px !important; border-top-left-radius: 0px !important; border-bottom-right-radius: 5px !important; border-top-right-radius: 5px !important;";
                    if (forlangsite === "ar") {
                        borderRadiusStyle =
                            "border-top-left-radius: 0px; border-bottom-left-radius: 0px;";
                        borderRadiusStyleiconcopy =
                            "border-bottom-right-radius: 0px !important; border-top-right-radius: 0px !important; border-bottom-left-radius: 5px !important; border-top-left-radius: 5px !important;";
                    }

                    let htmlContent = `
                        <div class="mx-auto" style="width: fit-content; margin-bottom: 10px; display: inline-block;">
                            <div class="input-group">
                                <span id="mobile_wallet_${index}" class="badge py-2 px-2 badge-success" style="${borderRadiusStyle} font-size: 20px;">
                                    <b id="numbercash${index}">${number}</b>
                                </span>
                                <div class="input-group-append">
                                    <span class="btn btn-big-secondary py-2 px-2" onclick="copy_mobile_wallet(${index})" title="Copy" style="${borderRadiusStyleiconcopy} border: 0px; background-color: #28a745;">
                                        <span class="fas fa-clone" style="color: #fff;"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;

                    let inputField = document.createElement("div");
                    inputField.innerHTML = htmlContent;
                    container.appendChild(inputField);
                });
            }

            if (data.whatsapp) {
                let defaultWhatsAppLink = document.querySelector('a[href*="wa.me/201000000000"]');
                if (defaultWhatsAppLink) {
                    defaultWhatsAppLink.setAttribute("href", "https://wa.me/" + data.whatsapp);
                }
            }


            let elementsToUpdate = {
                rate: "rate",
                extotal: "extotal",
                whatsapp: "whatsapp",
                storecurrencycode: "storecurrency.code",
                storecurrencyname_en: "storecurrency.name_en",
                storecurrencyname_ar: "storecurrency.name_ar",
                storecurrencysymbol: "storecurrency.symbol",
                storecurrencysymbol_ar: "storecurrency.symbol_ar",
                yourcurrencycode: "yourcurrency.code",
                yourcurrencyname_en: "yourcurrency.name_en",
                yourcurrencyname_ar: "yourcurrency.name_ar",
                yourcurrencysymbol: "yourcurrency.symbol",
                yourcurrencysymbol_ar: "yourcurrency.symbol_ar",
            };

            for (let key in elementsToUpdate) {
                let targetElement = document.getElementById(key);
                let propertyPath = elementsToUpdate[key].split(".");
                let valueinfodata = data;
                for (let prop of propertyPath) {
                    if (valueinfodata && valueinfodata.hasOwnProperty(prop)) {
                        valueinfodata = valueinfodata[prop];
                    } else {
                        valueinfodata = null;
                        break;
                    }
                }
                if (targetElement && valueinfodata !== null) {
                    targetElement.textContent = valueinfodata;
                }
            }
        })
        .then(() => {
            if (typeof username_custom !== "undefined") {
                usernameValue = username_custom;
            } else {
                fetch("/account")
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                "Response not ok or the page account does not exist"
                            );
                        }
                        return response.text();
                    })
                    .then((html) => {
                        var tempDiv = document.createElement("div");
                        tempDiv.innerHTML = html;
                        var usernameElement =
                            tempDiv.querySelector("#username");
                        if (usernameElement) {
                            usernameValue = usernameElement.value;
                        } else {
                            throw new Error(
                                "ID Username not found in input HTML"
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Fetch error:", error);
                    });
            }
        });
}

function copy_mobile_wallet(index) {
    var copynumbercashElement = document.getElementById(
        "mobile_wallet_" + index
    );
    var range = document.createRange();
    range.selectNode(copynumbercashElement);

    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);

    document.execCommand("copy");
}

function PaymentCheck() {
    var payButton = document.getElementById("payButton");
    var originalButtonText = payButton.innerText;

    if (forlangsite == "ar") {
        payButton.innerHTML =
            'جاري المعالجة... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>';
    } else {
        payButton.innerHTML =
            'Processing... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>';
    }

    payButton.disabled = true;
    walletphone.disabled = true;
    walletamount.disabled = true;

    let data = {
        user_name: usernameValue,
        walletphone: document.getElementById("walletphone").value,
        walletamount: document.getElementById("walletamount").value,
    };

    fetch(
        baseUrl +
            "/api/payment_link_check?phone=" +
            data["walletphone"] +
            "&amount=" +
            data["walletamount"] +
            "&user_name=" +
            data["user_name"] +
            "&store_id=" +
            forstoreid +
            "&lang=" +
            forlangsite,
        { method: "GET", redirect: "follow" }
    )
        .then((response) => response.json())
        .then((result) => {
            document.getElementById("message").innerHTML = result["message"];
            if (result.status === "success") {
                document.getElementById("walletphone").value = null;
                document.getElementById("walletamount").value = null;
                setTimeout(() => {
                    document.location.reload();
                }, 8000);
            }
        })
        .catch((error) => {
            if (forlangsite == "ar") {
                document.getElementById("message").innerHTML =
                    "<div style='text-align: right' class='alert alert-danger'>حدث خطأ أثناء معالجة طلبك. حاول لاحقا</div>";
            } else {
                document.getElementById("message").innerHTML =
                    "<div class='alert alert-danger'>Error occurred while processing your request. Try Later</div>";
            }
        })
        .finally(() => {
            window.scroll({
                top: 0,
                left: 0,
                behavior: "smooth",
            });
            payButton.innerText = originalButtonText;
            payButton.disabled = false;
            walletphone.disabled = false;
            walletamount.disabled = false;
        });
}

let walletphonefund = document.getElementById("walletphone");
if (walletphonefund) {
    PaymentInfo();
}
