<script>
    jQuery(function () {
        jQuery('.share_child_form').validate({
            submitHandler: function(form) {
                var $form = jQuery(form);
                $form.find('.alert_recommendation_error').remove();

                var submit_button = $form.find('.button_submit_recommend_friend').first();
                var submit_button_text = submit_button.text();
                submit_button.text('<?=__("Sending...", "compassion-posts")?>');

                jQuery.post($form.attr('action'), $form.serialize())
                    .done(function (data) {
                        jQuery('#share_child_accordion').replaceWith(data);
                    })
                    .fail(function (data) {
                        console.log('Recommend has failed: ' + data);
                        submit_button.text(submit_button_text);
                        submit_button.after('<div class="alert_recommendation_error">Could not send the recommendation !</div>')
                    });

                return false;
            },
            invalidHandler: function (event, validator) {
                var $form = jQuery(this);
                $form.find('.alert_recommendation_error').remove();
            }
        });

        // modification de la textarea en temps réel lorsqu'on modifie le prénom de l'ami
        jQuery('input[name="friend_lastname"]').on('keyup change', function() {
            var text = jQuery('textarea[name="text_email"]').first();
            var friend_lastname = jQuery(this).val();
            var r = new RegExp("^<?=__('Hallo,', 'compassion')?>?.*\n");
            if (friend_lastname == '') {
                text.val(text.val().replace(r, '<?=__("Hallo,", "compassion-posts")?>\n'));
            } else {
                text.val(text.val().replace(r, '<?=__("Hallo,", "compassion-posts")?>'.replace(',', ' ') + friend_lastname + ',\n'));
            }
        });
    });
</script>

<ul class="accordion" id="share_child_accordion" data-accordion>
    <li class="accordion-item<?= (isset($_GET['recommend'])) ? ' is-active' : '' ?>" data-accordion-item>
        <a href="#" class="button button-large button_recommend_friend">
            <?php
            /* translators: the placeholder reference the name of the child to recommend. */
            printf(__('Recommend %s to a friend', 'compassion-posts'), get_the_title());
            ?>
        </a>
        <div class="accordion-content" data-tab-content>
            <form class="share_child_form" action="<?= admin_url('admin-ajax.php'); ?>">
                <input name="action" type="hidden" value="recommend_child"/>
                <input name="child_id" type="hidden" value="<?= get_the_id() ?>"/>
                <label><?= __('Ihr Name und Nachname', 'compassion-posts') ?></label>
                <input name="coordinates" type="text" required data-msg="<?= __('Das Feld ist erforderlich.', 'compassion-posts') ?>"/>
                <label><?= __('Name Ihrer Freundin/ Ihres Freundes', 'compassion-posts') ?></label>
                <input name="friend_lastname" type="text" required data-msg="<?= __('Das Feld ist erforderlich.', 'compassion-posts') ?>"/>
                <label><?= __('E-Mail-Adresse Ihrer Freundin/ Ihres Freundes', 'compassion-posts') ?></label>
                <input name="friend_email" type="email" required data-msg="<?= __('Das Feld ist erforderlich.', 'compassion-posts') ?>"/>
                <label><?= __('Mitteilung an Ihren Freund/ Ihre Freundin', 'compassion-posts') ?></label>
                <textarea name="text_email" rows="5"  required data-msg="<?= __('Diese Nachricht ist leer.', 'compassion-posts') ?>"><?=
                   __( 'Hallo,', 'compassion-posts')." \n".__('Ich habe dieses Kind gefunden und denke, es könnte genau für dich sein!', 'compassion-posts')
                ?></textarea>
                <button type="submit" class="button button-small button_submit_recommend_friend">
                    <?= __('Senden', 'compassion-posts') ?>
                </button>
            </form>
        </div>
    </li>
</ul>