<param id="type_flag" value="csp"/>

<div class="row">
    <div class="small-12 medium-4 columns">
        <!-- <label class="text-left middle"><?= __('Choix du don', 'donation-form') ?></label> -->
    </div>
    <div class="small-12 medium-8 columns">
        <div style="margin-bottom: 16px;">
            <label style="display:inline-block; margin-right:8px;">
                <input type="radio" name="choix_don_unique_mensuel" value="don_mensuel" id="don_mensuel" checked>
                <?= __('Monatlich', 'donation-form') ?>
            </label>
            <label style="display:inline-block">
                <input type="radio" name="choix_don_unique_mensuel" value="don_unique" id="don_unique">
                <?= __('Einmalige Spende', 'donation-form') ?>
            </label>
        </div>
    </div>
</div>
<div class="row don_mensuel">
    <div class="small-12 medium-4 columns">
        <!-- <label class="text-left middle"><?php _e('Je désire faire un don mensuel', 'donation-form'); ?></label> -->
    </div>
    <div class="small-12 medium-8 columns">
        <div class="select-wrapper">
            <select name="fonds" id="fonds" class="input-field">
                <option data-v="15" value="csp_mensuel_15" <?php echo ($_SESSION["fund_code"] == "mensuel 15") ? 'selected' : '' ?>><?php _e('Monatliche Spende von CHF 15.-', 'donation-form'); ?></option>
                <option data-v="30" value="csp_mensuel_30" <?php echo ($_SESSION["fund_code"] == "mensuel 30") ? 'selected' : '' ?>><?php _e('Monatliche Spende von CHF 30.-', 'donation-form'); ?></option>
                <option data-v="60" value="csp_mensuel_60" <?php echo ($_SESSION["fund_code"] == "mensuel 60") ? 'selected' : '' ?>><?php _e('Monatliche Spende von CHF 60.-', 'donation-form'); ?></option>
            </select>
        </div>
        <p class="small">
            <?php _e('Nach deiner ersten Spende wird dir Compassion Schweiz einen Einzahlungsschein für die weiteren Spenden zusenden.', 'donation-form'); ?>
        </p>
    </div>
</div>
<div class="row don_unique" style="display: none;">
    <div class="small-12 medium-4 columns">
        <!-- <label class="text-left middle"><?php _e('Je désire faire un don unique', 'donation-form'); ?></label> -->
    </div>
    <div class="small-12 medium-8 columns">
        <input id="wert" type="number" step="0.01" required class="input-field" name="wert" value="<?php echo $_SESSION["fund_amount"] ?>">
    </div>
</div>

<script>
    function select_monthly(jQuery) {
        jQuery('.don_mensuel').show();
        jQuery('.don_unique').hide();
        jQuery('input[name="wert"]').attr('required', false);
    }

    function select_unique(jQuery) {
        jQuery('.don_mensuel').hide();
        jQuery('.don_unique').show();
        jQuery('input[name="wert"]').attr('required', true);
    }

    jQuery(function () {
        jQuery('#don_unique').on('ifChanged', function () {
            if (jQuery(this).prop('checked')) {
                select_unique(jQuery);
            } else {
                select_monthly(jQuery);
            }
        });
        select_monthly(jQuery);
        if (jQuery('input[name="wert"]').val() !== '') {
            select_unique(jQuery);
        } else {
            select_monthly(jQuery);
        }
    });
</script>
