<?php
/**
 * This template use variables that must be declared before it is included:
 *  - $donation_inputs_template : the absolute path to template which specify the fields needed for a particular donation.
 *  - $bank_transfer_comment (optional)
 *  - $bank_transfer_reason (optional)
 *  - CF7PF_PLUGIN_DIR_URL
 */
?>
<form id="donation_form" method="POST" action="?step=redirect" class="">
    <div class="row">
        <div class="small-12 medium-4 columns">
            <label class="text-left middle"><?php _e("Méthode de versement", "donation-form"); ?></label>
        </div>
        <div class="small-12 medium-8 columns">
            <div style="margin-bottom: 16px;">
                <label style="display:inline-block; margin-right:8px;">
                    <input id="payment_method_online" name="payment_method" type="radio" value="online" checked>
                    <?php _e("En ligne", "donation-form"); ?>
                </label>
                <label style="display:inline-block">
                    <input name="payment_method" type="radio" value="slip">
                    <?php _e("Par bulletin", "donation-form"); ?>
                </label>
            </div>
        </div>
    </div>

    <?php include($donation_inputs_template); ?>

    <div class="row">
        <div class="small-12 medium-12 columns">
            <h4 class="text-uppercase"><?php _e("Meine persönlichen Daten", "child-sponsor-lang"); ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="small-12 medium-4 columns">
            <label class="text-left middle">
                <?php _e("Vorname, Nachname", "donation-form"); ?>
            </label>
        </div>
        <div class="small-12 medium-8 columns">
            <input name="pname" type="text" required class="input-field" value="<?php echo $_SESSION["pname"] ?? ''?>">
        </div>
    </div>
    <div class="row">
        <div class="small-12 medium-4 columns">
            <label class="text-left middle">
                <?php _e("Strasse/Hausnr.", "child-sponsor-lang"); ?>
            </label>
        </div>
        <div class="small-12 medium-8 columns">
            <input name="street" type="text" required class="input-field" value="<?php echo $_SESSION["pstreet"] ?? ''?>">
        </div>
    </div>
    <div class="row">
        <div class="small-12 medium-4 columns">
            <label class="text-left middle">
                <?php _e("PLZ/Ort", "child-sponsor-lang"); ?>
            </label>
        </div>
        <div class="small-6 medium-2 columns">
            <input name="zipcode" type="text" required class="input-field"  value="<?php echo $_SESSION["pzip"] ?? ''?>">
        </div>
        <div class="small-6 medium-6 columns">
            <input name="city" type="text" required class="input-field" value="<?php echo $_SESSION["pcity"] ?? ''?>">
        </div>
    </div>
    <div class="row">
        <div class="small-12 medium-4 columns">
            <label class="text-left middle">
                <?php _e("Land", "child-sponsor-lang"); ?>
            </label>
        </div>
        <div class="mall-12 medium-8 columns">
            <select name="country" required class="input-field" >
                <?php include "countries_options.php" ?>
            </select>
        </div>
    </div>
    <div class="row online">
        <div class="small-12 medium-4 columns">
            <label class="text-left middle">
                <?php _e("E-Mail-Adresse", "child-sponsor-lang"); ?>
            </label>
        </div>
        <div class="small-12 medium-8 columns">
            <?php /* the original html5 email validation algorithm doesnt satify our needs. */ ?>
            <input name="email" type="email" required pattern="^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9+_.-]+\.[a-zA-Z]{2,}$" class="input-field" value="<?php echo $_SESSION["email"] ?? ''?>">
        </div>
    </div>
    <div class="row text-center">
        <button id="submit_button" type="button" class="button button-blue button-small click_donate"></button>
    </div>
    <div class="row text-center">
        <p>
            <?php _e("Deine Spende an Compassion ist in der Schweiz steuerabzugsberechtigt.", "donation-form")?>
        </p>
    </div>
</form>

<div class="row">
    <div id="qr_bill" class="text-center" hidden>
        <div id="qr_bill_svg"></div>
        <button id="qr_bill_print" type="button" class="button button-blue button-small click_donate"><?php _e("Imprimer", "donation-form"); ?></button>
        <p>
            <i>
                <?php _e("Vous pouvez également scanner le code QR directement sur votre écran", "donation-form"); ?>
            </i>
        </p>
    </div>
</div>

<script type="text/javascript">
// Set the reason for the donnation.
if(window.location.hash) {
    let hashParams = window.location.hash.substr(1).split("&"); // substr(1) to remove the `#`
    for(let i = 0; i < hashParams.length; i++) {
        let p = hashParams[i].split("=");
        document.getElementById(p[0]).value = decodeURIComponent(p[1]);
    }
}

let type_flag = document.getElementById("type_flag").value;
let language = "<?php echo substr(get_bloginfo("language"), 0, 2) ?>";
let available_languages = ["en", "fr", "de", "it"];
let donation_form = document.getElementById("donation_form");
let submit_button = document.getElementById("submit_button");
let text_submit_button_online = "<?php _e("Jetzt spenden", "donation-form"); ?>";
let text_submit_button_slip = "<?php _e("Générer le bulletin", "donation-form"); ?>";

let qr_bill = document.getElementById("qr_bill");
let qr_bill_svg = document.getElementById("qr_bill_svg");
let qr_bill_print = document.getElementById("qr_bill_print");
let qr_bill_url = "<?php echo CF7PF_PLUGIN_DIR_URL . "templates/qr_bill.php" ?>";

let payment_method = document.getElementsByName("payment_method")[1];
let payment_parent = payment_method.parentElement
let email = document.getElementsByName("email")[0];


jQuery('#payment_method_online').on('ifChanged', function () {
    if (jQuery(this).prop('checked')) {
        set_form_online()
    } else {
        set_form_slip()
    }
});

function set_form_online() {
    jQuery('.online').show()
    jQuery('input[name="email"]').attr('required', true);
    submit_button.innerHTML = text_submit_button_online;
}

function set_form_slip() {
    jQuery('.online').hide()
    jQuery('input[name="email"]').attr('required', false);
    submit_button.innerHTML = text_submit_button_slip;
}

set_form_online()


window.addEventListener("DOMContentLoaded", (event) => {
    const observer = new MutationObserver((e)=> {
        let is_slip = payment_method.checked;
        if(is_slip)
            set_form_slip();
        else
            set_form_online();
    });
    observer.observe(payment_parent, {attributes:true,subtree: true});
});

qr_bill_print.addEventListener("click", (e) => {
    let el = document.createElement("div");
    el.innerHTML = qr_bill_svg.innerHTML;
    el.style.border = "1px dashed black";
    let content = "<html><body>" + el.outerHTML + "</body></html>";

    let print_window = window.open("");
    print_window.document.write(content);
    print_window.document.close();
    print_window.focus();
    print_window.print();
    print_window.close();
});


async function fetch_payment_slip() {
    let additional_informations = "";
    let amount = 0;

    if(type_flag == "csp" && jQuery('input[name="wert"]').attr('required') != 'required')
    {
        amount = parseFloat(donation_form.fonds.selectedOptions[0].dataset.v);
        additional_informations += donation_form.fonds.selectedOptions[0].innerText;
    }
    else
    {
        amount = parseFloat(donation_form.wert.value);
    }

    if(type_flag == "frontend" || type_flag == "cadeau")
    {
        additional_informations += donation_form.fonds.selectedOptions[0].innerText;
    }
    if(type_flag == "cadeau")
    {
        additional_informations += " " + donation_form.refenfant.value;
    }


    data = {
        "debtor": {
            "name": donation_form.pname.value,
            "street": donation_form.street.value,
            "no": "",
            "zip": donation_form.zipcode.value,
            "city": donation_form.city.value,
            "country": donation_form.country.value,
        },
        "amount": amount,
        "additional_informations": additional_informations,
        "language": available_languages.includes(language) ? language : "en",
    };

    options = {
        method: "POST",
        mode: "cors",
        cache: "no-cache",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json"
        },
        redirect: "follow",
        referrerPolicy: "no-referrer",
        body: JSON.stringify(data)
    };

    const response = await fetch(qr_bill_url, options)
    .then(response => response.text())
    .then(function(data){
        qr_bill.hidden = false;
        qr_bill_svg.innerHTML = data;
        let svg = qr_bill_svg.children[0];
        svg.style.width = "90%";
        svg.style.height = "auto";
        qr_bill_svg.scrollIntoView({ behavior: "smooth", block: "center", inline: "center"});
    });
}

submit_button.addEventListener("click", (e) => {

    if(!donation_form.checkValidity()) {
        donation_form.reportValidity();
        return;
    }

    if(donation_form.payment_method.value == "online") {
        donation_form.submit();
    }
    else if (donation_form.payment_method.value == "slip") {
        fetch_payment_slip();
    }

});

// donation_form.pname.setCustomValidity("<?php _e("Name erforderlich", "child-sponsor-lang"); ?>");
// donation_form.street.setCustomValidity("<?php _e("Strasse erforderlich", "child-sponsor-lang"); ?>");
// donation_form.zipcode.setCustomValidity("<?php _e("PLZ erforderlich", "child-sponsor-lang"); ?>");
// donation_form.city.setCustomValidity("<?php _e("Stadt erforderlich", "child-sponsor-lang"); ?>");
// donation_form.country.setCustomValidity(" <?php _e("Länd erforderlich", "child-sponsor-lang"); ?>");
// donation_form.email.setCustomValidity("<?php _e("E-Mail-Adresse erforderlich", "child-sponsor-lang"); ?>");
</script>
