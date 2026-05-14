function getProductId() {

    const params = new URLSearchParams(
        window.location.search
    );

    return params.get("id");
}

/* =========================
   CHECK LOGIN
========================= */

async function checkLogin() {

    const res = await fetch("./api/me.php");

    const data = await res.json();

    if (!data.loggedIn) {

        window.location.href = "./login.html";

        return;
    }

    loadProduct();
}

checkLogin();

let currentProduct = null;

/* =========================
   LOAD PRODUCT
========================= */

async function loadProduct() {

    const id = getProductId();

    const res = await fetch("./api/getProducts.php");

    const products = await res.json();

    currentProduct = products.find(
        p => p.product_id == id
    );

    if (!currentProduct) {

        alert("Product not found");

        return;
    }

    /* PRODUCT IMAGE */

    document.querySelector(
        ".checkout-product-image"
    ).src = currentProduct.product_image;

    /* PRODUCT TITLE */

    document.querySelector(
        ".checkout-product-title"
    ).textContent =
        currentProduct.product_name_en;

    /* PRODUCT PRICE */

    document.querySelector(
        ".checkout-price"
    ).textContent =
        "$" + currentProduct.sell_price;

    /* OLD PRICE */

   if(parseInt(p.discount_percentage) > 0){
     document.querySelector(
        ".checkout-old-price"
    ).textContent =
        "$" + currentProduct.old_price;
   }
}

/* =========================
   SUBMIT ORDER
========================= */

async function submitOrder() {

    if (!currentProduct) {

        alert("Product not loaded");

        return;
    }

    /* PAYMENT METHOD */

    const selectedPayment =
        document.querySelector(
            'input[name="mbok"]:checked'
        );

    if (!selectedPayment) {

        alert("Select payment method");

        return;
    }

    /* PAYMENT PROOF */

    const proofFile =
        document.querySelector(
            ".js-payment-proof"
        ).files[0];

    if (!proofFile) {

        alert("Upload payment proof");

        return;
    }

    /* FORM DATA */

    const formData = new FormData();

    formData.append(
        "product_id",
        currentProduct.product_id
    );

    formData.append(
        "payment_method",
        selectedPayment.id
    );

    formData.append(
        "proof",
        proofFile
    );

    /* SEND */

    const res = await fetch(
        "./actions/createRequest.php",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await res.text();

    alert(result);

    window.location.href = "./index.html";
}

/* =========================
   BUTTON EVENT
========================= */

document.querySelector(
    ".js-submit-order"
).addEventListener(
    "click",
    submitOrder
);