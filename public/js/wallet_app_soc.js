var divstoreid = document.querySelector("script[data-store-id]");

if (divstoreid) {
    var forstoreid = divstoreid.getAttribute("data-store-id");
    var scriptSrc = divstoreid.getAttribute("src");
    var baseUrl = new URL(scriptSrc).origin;
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
                        "border-top-right-radius: 0px;border-bottom-right-radius: 0px;border-top-left-radius: 10px;border-bottom-left-radius: 10px;background-color: #28a745;padding: 3px 10px 7px;color: #fff;";
                    let borderRadiusStyleiconcopy =
                        "border-top-right-radius: 10px;border-bottom-right-radius: 10px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;background-color: #28a745;padding: 8px 5px;";

                    let htmlContent = `
                        <div class="mx-auto" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <span id="mobile_wallet_${index}" style="${borderRadiusStyle}">
                                    <b id="numbercash${index}">${number}</b>
                                </span>
                                <div class="input-group-append" style="display: contents;">
                                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNSAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzY2ODk6MjUwMjkpIj4KPHJlY3QgeD0iNCIgeT0iMC41IiB3aWR0aD0iMTEiIGhlaWdodD0iMTEiIHJ4PSIzIiBmaWxsPSIjQUZDMEQ1Ii8+CjxwYXRoIG9wYWNpdHk9IjAuNSIgZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0zIDQuNVY5LjVDMyAxMS4xNTY5IDQuMzQzMTUgMTIuNSA2IDEyLjVIMTFDMTEgMTQuMTU2OSA5LjY1Njg1IDE1LjUgOCAxNS41SDNDMS4zNDMxNSAxNS41IDAgMTQuMTU2OSAwIDEyLjVWNy41QzAgNS44NDMxNSAxLjM0MzE1IDQuNSAzIDQuNVoiIGZpbGw9IiNBRkMwRDUiLz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF82Njg5OjI1MDI5Ij4KPHJlY3Qgd2lkdGg9IjE1IiBoZWlnaHQ9IjE1IiBmaWxsPSJ3aGl0ZSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCAwLjUpIi8+CjwvY2xpcFBhdGg+CjwvZGVmcz4KPC9zdmc+Cg==" onclick="copy_mobile_wallet(${index})" title="Copy" style="${borderRadiusStyleiconcopy}">
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
                fetch("/api/user")
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                "Response not ok or the page does not exist"
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.login) {
                            usernameValue = data.login;
                        } else {
                            throw new Error(
                                "Login value not found in response data"
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
    payButton.innerHTML =
        'Processing... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>';

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
            forstoreid,
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
            document.getElementById("message").innerHTML =
                "<div class='alert alert-danger'>Error occurred while processing your request. Try Later</div>";
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

let walletPhoneFound = false;
let intervalId = setInterval(function () {
    let walletPhoneElement = document.getElementById("walletphone");
    if (walletPhoneElement && !walletPhoneFound) {
        PaymentInfo();
        walletPhoneFound = true;
    } else if (!walletPhoneElement) {
        walletPhoneFound = false;
    }
}, 500);
