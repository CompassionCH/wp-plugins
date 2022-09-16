<param id="type_flag" value="single"/>

<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Betrag deiner Spende in CHF', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <input id="wert" type="number" step="0.01" required class="input-field" name="wert" value="<?php echo $_SESSION["fund_amount"] ?? '' ?>">
    </div>
</div>

<?php
if($fonds=="noel"){ ; ?>
<div class="row" style="display:none">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?= __('Choix du don', 'donation-form') ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <div style="margin-bottom: 16px;">
            <label style="display:inline-block; margin-right:8px;">
                <input type="radio" name="choix_don_unique_mensuel" value="monthly" id="don_mensuel"  >
                <?= __('Monatlich', 'donation-form') ?>
            </label>
            <label style="display:inline-block">
                <input type="radio" name="choix_don_unique_mensuel" value="" id="don_unique" checked >
                <?= __('Einmalige Spende', 'donation-form') ?>
            </label>
        </div>
    </div>
</div>
<?php } else {  ?>
<div class="row">
    <div class="small-12 medium-4 columns">
        <!-- <label class="text-left middle"><?= __('Choix du don', 'donation-form') ?></label> -->
    </div>
    <div class="small-12 medium-8 columns">
        <div style="margin-bottom: 16px;">
            <label style="display:inline-block; margin-right:8px;">
                <input type="radio" name="choix_don_unique_mensuel" value="monthly" id="don_mensuel" checked >
                <?= __('Monatlich', 'donation-form') ?>
            </label>
            <label style="display:inline-block">
                <input type="radio" name="choix_don_unique_mensuel" value="" id="don_unique"  >
                <?= __('Einmalige Spende', 'donation-form') ?>
            </label>
        </div>
    </div>
</div>
<?php } ?>


<div class="row">
    <div class="small-12 medium-4 columns">
        <label class="text-left middle"><?php _e('Spendenzweck', 'donation-form'); ?></label>
    </div>
    <div class="small-12 medium-8 columns">
        <input name="fonds" id="fonds" type="hidden" value="<?php echo $fonds ?>">
        <label class="text-left middle"><?php echo $bank_transfer_reason; ?></label>
    </div>
</div>
