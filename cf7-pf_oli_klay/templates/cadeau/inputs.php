<param id="type_flag" value="cadeau"/>

<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Mein Betrag in CHF', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <input id="wert" type="number" step="0.01" required class="input-field" name="wert" value="<?php echo $_SESSION["fund_amount"] ?? '' ?>">
    </div>
</div>
<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Anlass', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <div class="select-wrapper">
            <select name="fonds" id="fonds" class="input-field">
                <option value="gift_birthday" <?php echo (isset($_SESSION["fund_code"]) && $_SESSION["fund_code"] == "gift_birthday") ? 'selected' : '' ?>><?php _e('Geburtstagsgeschenk', 'donation-form'); ?></option>
                <option value="gift_family" <?php echo (isset($_SESSION["fund_code"]) &&$_SESSION["fund_code"] == "gift_family") ? 'selected' : '' ?>><?php _e('Familiengeschenk', 'donation-form'); ?></option>
                <option value="gift_gen" <?php echo (isset($_SESSION["fund_code"]) && $_SESSION["fund_code"] == "gift_gen") ? 'selected' : '' ?>><?php _e('Allgemeines Geschenk', 'donation-form'); ?></option>
                <option value="gift_project" <?php echo (isset($_SESSION["fund_code"]) && $_SESSION["fund_code"] == "gift_project") ? 'selected' : '' ?>><?php _e('Geschenk ans Kinderzentrum', 'donation-form'); ?></option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Patenkindnummer', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <input name="refenfant" type="text" required pattern="^[a-zA-Z]{2}[0-9]{9}$" placeholder="<?php _e('ie : BO012301234', 'donation-form'); ?>" class="input-field" value="<?php echo $_SESSION["child_ref"] ?? ''?>">
    </div>
</div>
