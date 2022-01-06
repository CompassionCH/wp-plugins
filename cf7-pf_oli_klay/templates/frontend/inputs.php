<param id="type_flag" value="frontend"/>

<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Betrag deiner Spende in CHF', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <input id="wert" type="number" step="0.01" required class="input-field" name="wert" value="<?php echo $_SESSION["fund_amount"] ?>">
    </div>
</div>
<div class="row">
    <div class="small-12 medium-4 columns">
        <!-- <label class="text-left middle"><?= __('Choix du don', 'donation-form') ?></label> -->
    </div>
    <div class="small-12 medium-8 columns">
        <div style="margin-bottom: 16px;">
            <label style="display:inline-block; margin-right:8px;">
                <input type="radio" name="choix_don_unique_mensuel" value="monthly" id="don_mensuel" >
                <?= __('Monatlich', 'donation-form') ?>
            </label>
            <label style="display:inline-block">
                <input type="radio" name="choix_don_unique_mensuel" value="" id="don_unique" checked >
                <?= __('Einmalige Spende', 'donation-form') ?>
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Spendenzweck', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <div class="select-wrapper">
            <select name="fonds" id="fonds" class="input-field">
                <option value="humanitaire" <?php echo ($_SESSION["fund_code"] == "humanitaire") ? 'selected' : '' ?>><?php _e('Aktuelle Nothilfe', 'donation-form'); ?></option>
                <option value="noel" <?php echo ($_SESSION["fund_code"] == "noel") ? 'selected' : '' ?>><?php _e('Weihnachtsgeschenk', 'donation-form'); ?></option>
                <option value="wash" <?php echo ($_SESSION["fund_code"] == "wash") ? 'selected' : '' ?>><?php _e('Sauberes Wasser', 'donation-form'); ?></option>
                <option value="csp" <?php echo ($_SESSION["fund_code"] == "csp") ? 'selected' : '' ?>><?php _e('Babys und Müttern helfen', 'donation-form'); ?></option>
                <option value="sansparrain" <?php echo ($_SESSION["fund_code"] == "sansparrain") ? 'selected' : '' ?>><?php _e('Kinder, die ihren Paten verloren haben', 'donation-form'); ?></option>
                <option value="medical" <?php echo ($_SESSION["fund_code"] == "medical") ? 'selected' : '' ?>><?php _e('Medizinische Hilfe', 'donation-form'); ?></option>
                <option value="bible" <?php echo ($_SESSION["fund_code"] == "bible") ? 'selected' : '' ?>><?php _e('Bibelfonds', 'donation-form'); ?></option>
            </select>
        </div>
    </div>
</div>
