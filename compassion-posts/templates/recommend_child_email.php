<?php
/**
 * Email to send to the friend to which the child has been recommended.
 *
 * Needs the child's id as $child_id, the child's thumbnail as $child_image and the recommendation text as $post_data['text_email'].
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- $lang, $post_data(friend_lastname, coordinates), $child_id -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        #outlook a {
            padding: 0;
        }
        body {
            background-color: white !important;
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }
        .ExternalClass {
            width: 100%;
        }
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
            line-height: 100%;
        }
        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }
        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        a img {
            border: none;
        }
        .image_fix {
            display: block;
        }
        p {
            color: black !important;
            margin: 1em 0;
            font-size: 16px;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #0054a6 !important;
        }
        h4 {
            margin-top: 25px;
        }
        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
            color: black !important;
            text-decoration: underline !important
        }
        h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: white !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
        }
        h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
            color: white !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
        }
        table td {
            border-collapse: collapse;
        }
        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        a.lsv-box {
            padding: 5px 8px;
            margin: 10px 0 10px 10px;
            background-color: red;
            color: white !important;
        }
        a {
            color: #0054a6;
            text-decoration: underline
        }
        ul li {
            line-height: 22px;
            list-style-type: none;
        }
        @media only screen and (max-device-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: black; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                color: orange !important; /* or whatever your want */
                pointer-events: auto;
                cursor: default;
            }
        }
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: blue; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
    </style>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
        <td>
            <h1 style="text-align: center; padding: 25px 0;"><?= __('Un enfant pour vous !'); ?></h1>
            <?php $child_meta = get_child_meta($child_id); ?>

            <div style="padding: 0 30px;">
                <p><?= nl2br(htmlspecialchars($post_data['text_email'])) ?></p>

                <h3>
                    <?=
                    /* translators: %s is the name of the child that is recommended. */
                    sprintf(__('A propos de %s', 'compassion-posts'), $child_meta['name']);
                    ?>
                </h3>

                <p style="text-align: center;padding-top:30px"><?= $child_image ?></p>

                <ul>
                    <li><?php _e('Name', 'compassion-posts'); ?>: <?php echo $child_meta['name']; ?></li>
                    <li><?php _e('Land', 'compassion-posts'); ?>: <?php echo $child_meta['country']; ?></li>
                    <li><?php _e('Nummer', 'compassion-posts'); ?>: <?php echo $child_meta['number']; ?></li>
                </ul>

                <p>
                    <a href="<?= get_home_url() . '?p=' . $child_id ?>">
                        <?=
                        /* translators: %s is the name of the child that is recommended. */
                        sprintf(__('Plus d\'infos sur %s', 'compassion-posts'), $child_meta['name']);
                        ?>
                    </a>
                </p>

                <hr>

                <p>
                    <?= __('Si vous avez des questions au sujet du parrainage, nous restons volontiers à votre
                        disposition: Téléphone: 0800 784 773 (lundi à vendredi de 9h00 à 12h00 - 13h00 à 16h00) –
                        Adresse e-mail: info@compassion.ch', 'compassion-posts') ?>
                </p>
                <p>
                    <?= __('En espérant que vous ferez bientôt partie de la grande famille internationale de Compassion.', 'compassion-posts') ?>
                </p>
            </div>

            <p style="text-align: center;padding-top:30px">
                <img src="<?= get_template_directory_uri() ?>/assets/img/compassion-logo-dark-fr.png"
                     width="242" height="93" alt=""/>
            <p>
        </td>
    </tr>
</table>
</body>
</html>