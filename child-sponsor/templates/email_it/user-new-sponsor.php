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
        p {color:black !important;margin: 1em 0;}
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

            <h1 style="text-align: center; padding: 25px 0;">Un grande GRAZIE per il vostro impegno</h1>
			<?php $child_meta = get_child_meta($session_data['childID']);?>

			<div style="padding: 0 30px;">
			 <p>
			<?php echo ($session_data['salutation'] == 'Herr') ? __('Lieber', 'compassion-letters') : __('Liebe', 'compassion-letters');?> <?php  $salutation = apply_filters( 'wpml_object_id', $session_data['salutation'], 'post', TRUE);
	                    echo _e($salutation, 'child-sponsor-lang');?> <?php echo $session_data['first_name']; ?> <?php echo $session_data['last_name']; ?> <br /><br />
			Avete deciso di sostenere <?php echo $child_meta['name']; ?>. Grazie del vostro impegno nel cambiare la vita di questo bambino! È difficile immaginare la gioia che i bambini sentono nel momento in cui i collaboratori dei Centri Compassion gli annunciano che dall'altra parte del globo c'è un sostenitore che si prende cura di loro. Oggi voi siete fonte di grande gioia! A nome di <?php echo $child_meta['name']; ?>, GRAZIE!
			 </p>
			 <p> Presto riceverete per posta tutte le informazioni per il vostro sostegno. Per questo, grazie di verificare i vostri dati e il vostro indirizzo postale.</p>


			<h4> Avete trasmetto le informazioni seguenti:</h4>

          <div style="padding: 0 30px;">

	          	<p>Prendo l'incarico di sostenere:<strong> <?php echo $child_meta['name']; ?></strong></p>


                <h3>Bambino</h3>

                <ul>
                    <li><?php _e('Name', 'child-sponsor-lang'); ?>: <?php echo $child_meta['name']; ?></li>
                    <li><?php _e('Land','child-sponsor-lang'); ?>: <?php echo $child_meta['country']; ?></li>
                    <li><?php _e('Nummer','child-sponsor-lang'); ?>: <?php echo $child_meta['number']; ?></li>
                </ul>

                <hr>

                <h3>Informazioni del sostenitore</h3>
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

        <!--              Writeandpraystuff  -->
        <?php
        $wapr = isset($_SESSION['utm_source']) && $_SESSION['utm_source']=='wrpr';
        if ($wapr) {
            echo "<h3>Sostegno Write & Pray</h3>";
            if (isset($session_data['writepray'])) {
                if ($session_data['writepray'] == 'WRPR'){
                  echo _e('Ich engagiere mich für mein Patenkind zu beten und ihm regelmässsig zu schreiben.  Ich habe verstanden, dass eine andere Person die Finanzierung dieser Patenschaft übernimmt und ich gegenüber dem Kind der/die offizielle Pate/Patin bin.', 'child-sponsor-lang');
                } else if($session_data['writepray'] == 'WRPR+DON'){
                  echo _e('Je m\'engage à [...] et je peux contribuer mensuellement à hauteur de : ', 'child-sponsor-lang');
                  echo '<b>' . $session_data['writepray-contribution'] . 'CHF</b>';
                }
            }
		   	} else {
        ?>
		   	<!--              END Writeandpraystuff  -->

				<h3>Sostegno plus</h3>
				  <?php if (isset($session_data['patenschaftplus'])) {
				  		echo _e('JA', 'child-sponsor-lang');
				  		} else {echo _e('NEIN', 'child-sponsor-lang');}
				  ?>

				<h3>Metodo di pagamento</h3>

					<?php
                        $zahlung = ($session_data['zahlungsweise']);
	                        if ($zahlung == 'dauerauftrag'){
		                        echo _e('Monatlicher Dauerauftrag', 'child-sponsor-lang');
	                        }
	                        elseif ($zahlung == 'lsv'){
		                        echo _e('Direct Debit - LSV', 'child-sponsor-lang');
		                        echo '&nbsp;<a class="lsv-box" href="https://www.compassion.ch/wp-content/uploads/documents_compassion/Formulaire_LSV_DD_IT.pdf">' . _e("Téléchargez le formulaire de demande LSV", "child-sponsor-lang") . '</a>';
	                        }

                        ?>
                      <?php } ?>
                <h3>Scambio di lettere con <?php echo $child_meta['name']; ?></h3>

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

				<h3>La vostra risposta alla questione: Come ha conosciuto Compassion?</h3>
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

				<h3>Inviatemi maggiori informazioni su come posso aiutare i bambini nel bisogno.</h3>
						<?php if (isset($session_data['mithelfen'])) {
				  		echo _e('JA', 'child-sponsor-lang');
				  		} else {echo _e('NEIN', 'child-sponsor-lang');}
				  ?>

                <hr>

               <p>Se avete domande sul vostro sostegno, siamo volentieri a vostra disposizione: <br/>
	               Tel: 031 552 21 24(il martedì e il giovedì: 8h00-16h00)<br/>
	               o per email a: info@compassion.ch</p>

			   <p>Vi diamo il benvenuto nella grande famiglia internazionale di Compassion.
				  Grazie con tutto il cuore per il vostro impegno concreto che cambia la vita di un bambino.
				  <br/>Carole Rochat per il team di Compassion Svizzera</p>
            </div>

            <p style="text-align: center;padding-top:30px"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/compassion-logo-dark-it.png" width="242" height="93" alt="" /><p>


        </td>
    </tr>
</table>
<!-- End of wrapper table -->
</body>
</html>
