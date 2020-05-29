<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        /* Client-specific Styles */
        #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
        body{background-color:white !important;width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
        /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
        .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
        /* End reset */
        /* Some sensible defaults for images
        1. "-ms-interpolation-mode: bicubic" works to help ie properly resize images in IE. (if you are resizing them using the width and height attributes)
        2. "border:none" removes border when linking images.
        3. Updated the common Gmail/Hotmail image display fix: Gmail and Hotmail unwantedly adds in an extra space below images when using non IE browsers. You may not always want all of your images to be block elements. Apply the "image_fix" class to any image you need to fix.
        Bring inline: Yes.
        */
        img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        .image_fix {display:block;}
        /** Yahoo paragraph fix: removes the proper spacing or the paragraph (p) tag. To correct we set the top/bottom margin to 1em in the head of the document. Simple fix with little effect on other styling. NOTE: It is also common to use two breaks instead of the paragraph tag but I think this way is cleaner and more semantic. NOTE: This example recommends 1em. More info on setting web defaults: http://www.w3.org/TR/CSS21/sample.html or http://meiert.com/en/blog/20070922/user-agent-style-sheets/
        Bring inline: Yes.
        **/
        p {color:black !important;margin: 1em 0; line-height: 1.5;}
        /** Hotmail header color reset: Hotmail replaces your header color styles with a green color on H2, H3, H4, H5, and H6 tags. In this example, the color is reset to black for a non-linked header, blue for a linked header, red for an active header (limited support), and purple for a visited header (limited support).  Replace with your choice of color. The !important is really what is overriding Hotmail's styling. Hotmail also sets the H1 and H2 tags to the same size.
        Bring inline: Yes.
        **/
        h1, h2, h3, h4, h5, h6 {color: #005eb8 !important;}
        h4 {
            margin-top: 25px;
        }
        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: black !important; text-decoration: underline !important}
        h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: white !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
        }
        h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
            color: white !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
        }
        /** Outlook 07, 10 Padding issue: These "newer" versions of Outlook add some padding around table cells potentially throwing off your perfectly pixeled table.  The issue can cause added space and also throw off borders completely.  Use this fix in your header or inline to safely fix your table woes.
        More info: http://www.ianhoar.com/2008/04/29/outlook-2007-borders-and-1px-padding-on-table-cells/
        http://www.campaignmonitor.com/blog/post/3392/1px-borders-padding-on-table-cells-in-outlook-07/
        H/T @edmelly
        Bring inline: No.
        **/
        table td {border-collapse: collapse;}
        /** Remove spacing around Outlook 07, 10 tables
        More info : http://www.campaignmonitor.com/blog/post/3694/removing-spacing-from-around-tables-in-outlook-2007-and-2010/
        Bring inline: Yes
        **/
        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
        /* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email, bring your styles inline.  Your link colors will be uniform across clients when brought inline.
        Bring inline: Yes. */
        a.lsv-box{padding:5px 8px;margin:10px 0 10px 10px; background-color:red; color:white !important;}

        a {color:#005eb8; text-decoration: underline}

        ul li {
            line-height: 22px;
        }
        /***************************************************
        ****************************************************
        MOBILE TARGETING
        Use @media queries with care.  You should not bring these styles inline -- so it's recommended to apply them AFTER you bring the other stlying inline.
        Note: test carefully with Yahoo.
        Note 2: Don't bring anything below this line inline.
        ****************************************************
        ***************************************************/
        /* NOTE: To properly use @media queries and play nice with yahoo mail, use attribute selectors in place of class, id declarations.
        table[class=classname]
        Read more: http://www.campaignmonitor.com/blog/post/3457/media-query-issues-in-yahoo-mail-mobile-email/
        */
        @media only screen and (max-device-width: 480px) {
            /* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.
            Inspired by Campaign Monitor's article on using phone numbers in email: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/.
            Step 1 (Step 2: line 224)
            */

            p {color:black !important;margin: 2em 0; line-height: 1.5;}

            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: black; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important; /* or whatever your want */
                pointer-events: auto;
                cursor: default;
            }
        }
        /* More Specific Targeting */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            /* You guessed it, ipad (tablets, smaller screens, etc) */
            /* Step 1a: Repeating for the iPad */
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: blue; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
        @media only screen and (-webkit-min-device-pixel-ratio: 2) {
            /* Put your iPhone 4g styles in here */
        }
        /* Following Android targeting from:
        http://developer.android.com/guide/webapps/targeting.html
        http://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/  */
        @media only screen and (-webkit-device-pixel-ratio:.75){
            /* Put CSS for low density (ldpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1){
            /* Put CSS for medium density (mdpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1.5){
            /* Put CSS for high density (hdpi) Android layouts in here */
        }
        /* end Android targeting */
    </style>

    <!-- Targeting Windows Mobile -->
    <!--[if IEMobile 7]>
    <style type="text/css">
    </style>
    <![endif]-->

    <!-- ***********************************************
    ****************************************************
    END MOBILE TARGETING
    ****************************************************
    ************************************************ -->

    <!--[if gte mso 9]>
    <style>
        /* Target Outlook 2007 and 2010 */
    </style>
    <![endif]-->
</head>
<body>
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
        <td>
            <?php $child_meta = get_child_meta($session_data['childID']);
            $wapr = isset($_SESSION['utm_source']) && $_SESSION['utm_source']=='wrpr'; ?>


            <?php
            if ($wapr) {
            ?>
            <h1 style="text-align: center; padding: 25px 0;">Un grand MERCI pour ton engagement</h1>


			<div style="padding: 0 30px;">
			 <p>
                 <?php  echo ($session_data['salutation'] == 'Herr') ? __('Lieber', 'compassion-letters') : __('Liebe', 'compassion-letters');?> <?php echo $session_data['first_name']; ?>, <br /><br />
			Bienvenue dans la grande famille de Compassion. <br/> Tu as décidé de parrainer <?php echo $child_meta['name']; ?>. Merci de t'engager à changer la vie de cet enfant! C’est un jour de fête pour chaque enfant et sa famille lorsque les collaborateurs d’un centre d’accueil l’informent qu’un parrain s’intéresse à lui et a choisi de le soutenir. Tu es aujourd’hui la source d’une très grande joie! Au nom de <?php echo $child_meta['name']; ?>, MERCI !
			 </p>
			 <p> Tu recevras dans les prochains jours toutes les informations concernant ton parrainage, par poste. Pour cela, merci de bien vérifier tes données ainsi que ton adresse postale.</p>


			<h4> Tu nous a transmis les informations suivantes:</h4>
                <?php
                }  else {
                ?>
                <h1 style="text-align: center; padding: 25px 0;">Un grand MERCI pour votre engagement</h1>}

                <div style="padding: 0 30px;">
                    <p>
                        <?php echo ($session_data['salutation'] == 'Herr') ? __('Lieber', 'compassion-letters') : __('Liebe', 'compassion-letters');?> <?php  $salutation = apply_filters( 'wpml_object_id', $session_data['salutation'], 'post', TRUE);
                        echo _e($salutation, 'child-sponsor-lang');?> <?php echo $session_data['first_name']; ?> <?php echo $session_data['last_name']; ?> <br /><br />
                        Bienvenue dans la grande famille de Compassion. Vous avez décidé de parrainer <?php echo $child_meta['name']; ?>. Merci de vous engager à changer la vie de cet enfant! C’est un jour de fête pour chaque enfant et sa famille lorsque les collaborateurs d’un centre d’accueil l’informent qu’un parrain s’intéresse à lui et a choisi de le soutenir. Vous êtes aujourd’hui la source d’une très grande joie! Au nom de <?php echo $child_meta['name']; ?>, MERCI !
                    </p>
                    <p> Vous recevrez dans les tous prochains jours toutes les informations concernant votre parrainage, par poste. Pour cela, merci de bien vérifier vos données ainsi que votre adresse postale.</p>


                    <h4> Vous nous avez transmis les informations suivantes:</h4>
                    <?php
                    }

                    ?>

          <div style="padding: 0 30px;">

	          	<p>Je prends en charge le parrainage de:  <strong><?php echo $child_meta['name']; ?></strong></p>


                <h3>Enfant</h3>

                <ul>
                    <li><?php _e('Name', 'child-sponsor-lang'); ?>: <?php echo $child_meta['name']; ?></li>
                    <li><?php _e('Land','child-sponsor-lang'); ?>: <?php echo $child_meta['country']; ?></li>
                    <li><?php _e('Nummer','child-sponsor-lang'); ?>: <?php echo $child_meta['number']; ?></li>
                </ul>

                <hr>

                <h3>Coordonnées du parrain</h3>
                <ul>
                    <li><?php _e('Anrede', 'child-sponsor-lang'); ?>:   <?php
	                    $salutation = apply_filters( 'wpml_object_id', $session_data['salutation'], 'post', TRUE);
	                    echo _e($salutation, 'child-sponsor-lang');?></li>
                    <li><?php _e('Vorname', 'child-sponsor-lang'); ?>: <?php echo $session_data['first_name']; ?></li>
                    <li><?php _e('Nachname', 'child-sponsor-lang'); ?>: <?php echo $session_data['last_name']; ?></li>
                    <li><?php _e('Strasse', 'child-sponsor-lang'); ?>: <?php echo $session_data['street']; ?></li>
                    <li><?php _e('Stadt', 'child-sponsor-lang'); ?>: <?php echo $session_data['city']; ?></li>
                    <li><?php _e('PLZ', 'child-sponsor-lang'); ?>: <?php echo $session_data['zipcode']; ?></li>
                    <li><?php _e('Land', 'child-sponsor-lang'); ?>: <?php echo $session_data['land']; ?></li>
                    <li><?php _e('Geburtstag', 'child-sponsor-lang'); ?>: <?php echo $session_data['birthday']; ?></li>
                    <li><?php _e('E-Mail', 'child-sponsor-lang'); ?>: <?php echo $session_data['email']; ?></li>
                    <li><?php _e('Telefon', 'child-sponsor-lang'); ?>: <?php echo $session_data['phone']; ?></li>
					<li><?php _e('Kirchgemeinde', 'child-sponsor-lang'); ?>: <?php echo $session_data['kirchgemeinde']; ?></li>
                    <li><?php _e('Beruf', 'child-sponsor-lang'); ?>: <?php echo $session_data['Beruf']; ?></li>

                </ul>

				<?php
        if ($wapr) {
            echo "<h3>Parrainage Write & Pray</h3>";
            if (isset($session_data['writepray'])) {
                if ($session_data['writepray'] == 'WRPR'){
                  echo _e('Ich engagiere mich für mein Patenkind zu beten und ihm regelmässsig zu schreiben.  Ich habe verstanden, dass eine andere Person die Finanzierung dieser Patenschaft übernimmt und ich gegenüber dem Kind der/die offizielle Pate/Patin bin.', 'child-sponsor-lang');
                } else if($session_data['writepray'] == 'WRPR+DON'){
                  echo _e('Ich erkläre mich bereit, regelmässig für mein Patenkind zu beten und zu schreiben, und ich kann das Kind monatlich mit folgenden Betrage unterstützen: ', 'child-sponsor-lang');
                  echo '<b>' . $session_data['writepray-contribution'] . ' CHF</b><br/><br/>';
                  echo _e('Ich habe verstanden, dass eine andere Person den Rest der Finanzierung für diese Patenschaft übernimmt, dass ich aber der offizielle Pate/ die Patin des Kindes bin.', 'child-sponsor-lang');
                }
            }
		   	} else {
        ?>

				<h3>Parrainage plus</h3>
				  <?php if (isset($session_data['patenschaftplus'])) {
				  		echo _e('JA', 'child-sponsor-lang');
				  		} else {echo _e('NEIN', 'child-sponsor-lang');}
				  ?>

				<h3>Méthode de paiement</h3>

					<?php
                        $zahlung = ($session_data['zahlungsweise']);
	                        if ($zahlung == 'dauerauftrag'){
		                        echo _e('Monatlicher Dauerauftrag', 'child-sponsor-lang');
	                        }
	                        elseif ($zahlung == 'lsv'){
		                        echo _e('Direct Debit - LSV', 'child-sponsor-lang');
		                        echo '&nbsp;<a class="lsv-box" href="https://www.compassion.ch/wp-content/uploads/documents_compassion/Formulaire_LSV_DD_FR.pdf">Téléchargez le formulaire de demande LSV</a>';
	                        }

                        ?>
                     	    <?php } ?>

                <h3>Correspondance avec <?php echo $child_meta['name']; ?></h3>

                <?php
	            if(!empty($session_data['language'])) {
				foreach($session_data['language'] as $check) {
				echo'<ul>';
				echo  '<li>';
				switch ($check) {

				case 'französich':
				echo _e('Französisch','child-sponsor-lang');
				break;

				case 'italienisch':
				echo _e('Italienisch','child-sponsor-lang');
				break;

				case 'spanisch':
				echo _e('Spanisch','child-sponsor-lang');
				break;

				case 'englisch':
				echo _e('Englisch','child-sponsor-lang');
				break;

				case 'portugiesisch':
				echo _e('Portugiesisch','child-sponsor-lang');
				break;
				}
				echo'</li></ul> ';
				}
				}
				?>
              <?php
              if ($wapr) {
              ?>
              <h3>Ta réponse à la question : Comment as-tu connu Compassion ?</h3>
              <?php
              } else {
                  ?>
              <h3>Votre réponse à la question : Comment avez-vous connu Compassion ?</h3>
             <?php
              }
              ?>


              <ul>
                   <li>
                       <?php
                       if (strpos($session_data['consumer_source'], 'msk_') !== false) {
                           echo _e('Muskathlon', 'child-sponsor-lang').' : ';
                           echo $session_data['msk_participant_name'];
                       } else {
                           echo _e($session_data['consumer_source'], 'child-sponsor-lang').' : ';
                           echo _e($session_data['consumer_source_text'], 'child-sponsor-lang');
                       }?>
                   </li>
                </ul>

				<h3>Envoyez-moi des informations sur les autres possibilités d'engagement au profit des enfants démunis.</h3>
						<?php if (isset($session_data['mithelfen'])) {
				  		echo _e('JA', 'child-sponsor-lang');
				  		} else {echo _e('NEIN', 'child-sponsor-lang');}
				  ?>

                <hr>
              <?php
              if ($wapr) {
                  ?>
                  <p>Si tu as des questions au sujet de ton parrainage, nous restons volontiers à ta disposition: Téléphone: 024 434 21 24 (lundi à vendredi de 8h00 à 16h00) – Adresse e-mail:
                      info@compassion.ch ou Whatsapp: 079 622 31 97</p>
                  <?php
              } else{
              ?>
              <p>Si vous avez des questions au sujet de votre parrainage, nous restons volontiers à votre disposition: Téléphone: 024 434 21 24 (lundi à vendredi de 8h00 à 16h00) – Adresse e-mail: info@compassion.ch</p>
              <?php
              }
              ?>


              <p>Merci du fond du cœur d’avoir choisi d’investir dans la vie d’un enfant. Michelle aux Philippines a grandi dans un quartier pauvre où régnait trafic et consommation de drogue et prostitution. Parrainée, elle a pu aller à l’école, suivre des études. Aujourd’hui, elle dirige l’ONG qu’elle a créée et vient en aide aux femmes victimes d’esclavage moderne. Votre parrainage va transformer une vie durablement.<br/><br/>
				   Très cordialement,<br/>Carole Rochat pour l’équipe de Compassion Suisse</p>
            </div>

            <p style="text-align: center;padding-top:30px"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/compassion-logo-dark-fr.png" width="242" height="93" alt="" /><p>


        </td>
    </tr>
</table>
<!-- End of wrapper table -->
</body>
</html>
