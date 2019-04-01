<?php
/**
 * Template to send and display after a successful recommendation.
 *
 * Needs the child's post info as $child (from WP's get_post().
 */
?>
<div class="alert_recommendation_submitted">
    <?=
    /* translators: The placeholder references the child's name. */
    sprintf(__('Ihre Nachricht wurde gesendet. Danke, dass Sie sich für %s einsetzen', 'compassion-posts'), $child->post_title)
    ?>
</div>