<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Betrag deiner Spende in CHF', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <input type="text" placeholder="<?php _e('bitte nur Zahlen', 'donation-form'); ?>" required data-msg="<?php _e('Betrag erforderlich', 'donation-form'); ?>" class="input-field" name="wert" value="<?php echo $_SESSION["fund_amount"]?>">
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
        <input name="fonds" id="fonds" type="hidden" value="<?php echo $fonds ?>">
        <label class="text-left middle"><?php echo $bank_transfer_reason; ?></label>
    </div>
</div>
