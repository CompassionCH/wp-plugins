<?php
$child_data = get_child_meta($session_data['childID']);

//vous identifiez la langue courante
$my_current_lang = apply_filters('wpml_current_language', NULL);


?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    // Validate the forms
    $.validator.addMethod("slashDate", function(value, element) {
        /*
          In order to be more flexible for Germans, we accept different
          separators: . (dot) - (hyphen) / (slash)
          and then reformat the date for odoo

          original regexp:
            /(0[1-9]|[1-2][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d\d\d\d)/
        */
        regexp = /^(0?[1-9]|[1-2][0-9]|3[01])[\.\/\-](0?[1-9]|1[0-2])[\.\/\-](\d\d\d\d)$/
        var match = regexp.test(value);
        if (!match)
          return false;

        value = value.replace(/[\.\-]/g, "/");
        value = value.replace(/^([1-9])\//, "0$1/");
        value = value.replace(/\/([1-9])\//, "/0$1/");
        $(element).val(value);
        return true;
    }, function(value, element){
        return $(element).data('default-msg')
    });

    $.validator.addMethod("wrprBirthdate", function(value, element) {
        var $el = $(element)
        var age_limit = $el.data('wrpr-age-limit');
        if( !$el.data('wrpr') || !age_limit ){
            return true;
        }
        // If it is a write&pray sponsorship, we need to check the user's age
        var parts = value.split("/");
        var date = new Date(parseInt(parts[2], 10),
                            parseInt(parts[1], 10) - 1,
                            parseInt(parts[0], 10));
        var age = Math.abs(new Date(Date.now() - date.getTime()).getUTCFullYear() - 1970);
        return !age_limit || age < age_limit;

    }, function(params, element) {
        // if he's older than age_limit we show him a link to the usual sponsorship page
        var href = window.location.href
        if (href.includes('utm_source')) {
            href = href.replace(/(utm_source=).*?($|&)/, '$1button$2')
        }else{
            href = href + '&utm_source=button'
        }
        return $("<a>", {
            href: href,
            style: 'color:white',
            text: $(element).data('wrpr-age-limit-msg')
        });
    });

    $('.child-sponsor form').validate({
        ignore: ".ignore, .ignore *",
        rules: {
            birthday: {
                slashDate: true,
                wrprBirthdate: true
            }
        },
        errorPlacement: function(error, element) {
            if((element.attr('type') === 'radio')){
                element.parent().before(error);
            }
            else{
                element.after(error);
            }
        }
    });

    $('input:radio[name="writepray"]').on('ifChecked', function(){
        if ($(this).val() == "WRPR+DON") {
            $("#writepray-contribution").removeClass('hide').find('input').removeClass('ignore')
        }else {
            $("#writepray-contribution").addClass('hide').find('input').addClass('ignore')
        }
    });

    // Show detail input based on user.
    $('#consumer_select').change( function() {
        var placeholder = $(this).find(':selected').data('placeholder');
        if (placeholder === undefined) {
            $('.consumer-source-text-wrapper').addClass('hide');
            $('.consumer-source-text-wrapper').find('input').addClass('ignore');
	} else {
      	    $('.place').attr('placeholder', placeholder);

	    $('.consumer-source-text-wrapper').removeClass('hide');
            $('.consumer-source-text-wrapper').find('input').removeClass('ignore');
	}
    });
});
</script>

<div class="section background-blue section_abgerissen_unten has_breadcrumb">
    <div class="row section_breadcrumb">
        <?php compassion_breadcrumb(false); ?>
    </div>

    <div class="row">
        <div class="child-image" style="background-image: url(<?php echo $child_data['portrait']; ?>);">

        </div>

        <?php
        if ($my_current_lang == "fr") {
            $msk = isset($_SESSION['msk_name']) && isset($_SESSION['msk_participant_name']);
            if ($msk) { ?>
                <h2 style="text-align: center;">
                    <?= __('Danke, dass du dich für', 'child-sponsor-lang') ?> <?= $child_data['name'] ?> <?= __('einsetzt. Die Patenschaft wird das Leben dieses Kindes nachhaltig verändern.', 'child-sponsor-lang'); ?>
                </h2>
            <?php } else { ?>
                <h2 style="text-align: center;"><?php _e('Schön, dass du ', 'child-sponsor-lang'); ?> <?php echo $child_data['name']; ?></h2>
            <?php }
        } elseif ($my_current_lang == "de") { ?>
            <h2 style="text-align: center;"><?php _e('Schön, dass du Pate von', 'child-sponsor-lang'); ?> <?php echo $child_data['name']; ?>
                <?php _e('werden möchtest', 'child-sponsor-lang'); ?></h2>
        <?php } elseif ($my_current_lang == "it") {
            ?>
            <h2 style="text-align: center;"><?php _e('Schön, dass du', 'child-sponsor-lang'); ?> <?php echo $child_data['name']; ?></h2>
        <?php } ?>
        <p style="text-align: center;" class="subtitle">
            <?php if ($msk) { ?>
                <?= $_SESSION['msk_participant_name'] ?>, <?= __('nimmt am', 'child-sponsor-lang') ?> <?= $_SESSION['msk_name'] ?><?= __(' teil.', 'child-sponsor-lang') ?> <?= __('und dankt Ihnen für Ihre Unterstützung!', 'child-sponsor-lang') ?>
            <?php } else {
                _e('Du wirst das Leben des Kindes für immer verändern.', 'child-sponsor-lang');
            } ?>
        <p>

    </div>

</div>
