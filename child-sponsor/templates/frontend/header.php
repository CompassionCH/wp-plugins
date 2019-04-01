<?php
$child_data = get_child_meta($session_data['childID']);

//vous identifiez la langue courante
$my_current_lang = apply_filters('wpml_current_language', NULL);


?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    // Validate the forms
    $.validator.addMethod("slashDate", function(value, element) {
        return /(0[1-9]|[1-2][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d\d\d\d/.test(value);
    }, "Please enter a valid date");

    $('.child-sponsor form').validate({
        ignore: ".ignore, .ignore *",
        rules: {
            birthday: {
                slashDate: true
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
        <div class="child-image" style="background-image: url(<?php echo $child_data['portrait']; ?>);"></div>

        <h2 style="text-align: center;">
            <?php
            /* translators: %s references the child's name. */
            printf(__('Schön, dass Sie Pate von %s werden möchten', 'compassion'), $child_data['name'])
            ?>
        </h2>

        <p style="text-align: center;" class="subtitle">
            <?php
            _e('Sie werden das Leben des Kindes für immer verändern.', 'child-sponsor-lang');
            ?>
        <p>
    </div>
</div>
