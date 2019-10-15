<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        /* Client-specific Styles */
        #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
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
        p {margin: 1em 0;}
        /** Hotmail header color reset: Hotmail replaces your header color styles with a green color on H2, H3, H4, H5, and H6 tags. In this example, the color is reset to black for a non-linked header, blue for a linked header, red for an active header (limited support), and purple for a visited header (limited support).  Replace with your choice of color. The !important is really what is overriding Hotmail's styling. Hotmail also sets the H1 and H2 tags to the same size.
        Bring inline: Yes.
        **/
        h1, h2, h3, h4, h5, h6 {color: black !important;}
        h4 {
            margin-top: 25px;
        }
        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
        h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
        }
        h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
            color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
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
        a {color: blue;}

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

            <h1 style="text-align: center; padding: 25px 0;">Ein grosses MERCI für dein Engagement	</h1>
			<?php $child_meta = get_child_meta($session_data['childID']);?>
			
			<div style="padding: 0 30px;">
			 <p>
			<?php echo ($session_data['salutation'] == 'Herr') ? __('Lieber', 'compassion-letters') : __('Liebe', 'compassion-letters');?> <?php echo $session_data['first_name']; ?> <br /><br />
			Du hast dich entschieden, <?php echo $child_meta['name']; ?> durch eine Patenschaft zu unterstützen. Vielen Dank, dass mit deiner Hilfe das Leben dieses Kindes verändert wird! Kannst du dir die Riesenfreude vorstellen, wenn unsere Mitarbeitenden vor Ort dem Kind mitteilen können, dass es jetzt auf der anderen Seite der Welt eine Patin oder einen Paten hat? DANKE im Namen von <?php echo $child_meta['name']; ?> und seiner/ihrer Familie!
			 </p>
			 <p>Du wirst bald per Post alle Informationen über deine Patenschaft erhalten. Überprüfe dazu bitte deine Angaben:</p>
			
				 						
          <div style="padding: 0 30px;">
	          
	          	<p>Ich übernehme die Patenschaft für: <strong><?php echo $child_meta['name']; ?></strong></p>

	          
                <h3>Patenkind</h3>
              
                <ul>
                    <li><?php _e('Name', 'child-sponsor-lang'); ?>: <?php echo $child_meta['name']; ?></li>
                    <li><?php _e('Land','child-sponsor-lang'); ?>: <?php echo $child_meta['country']; ?></li>
                    <li><?php _e('Nummer','child-sponsor-lang'); ?>: <?php echo $child_meta['number']; ?></li>
                </ul>

                <hr>

                <h3>Deine Angaben</h3>
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
                
				<?php    $wapr = isset($_SESSION['utm_source']) && $_SESSION['utm_source']=='wrpr';?> 

                <?php if ($wapr) { ?> 
				<h3>Patenschaft Write & Pray</h3>
               
                 <?php if (isset($session_data['writepray'])) {
	          echo _e('JA', 'child-sponsor-lang'); 
	          } else {echo _e('NEIN', 'child-sponsor-lang');}
           		?> 
		   	
		   	<?php } else { ?>
		   	<!--              END Writeandpraystuff  -->

				<h3>Patenschaft Plus</h3>
				  <?php if (isset($session_data['patenschaftplus'])) {
				  		echo _e('JA', 'child-sponsor-lang'); 
				  		} else {echo _e('NEIN', 'child-sponsor-lang');}
				  ?> 

				<h3>Zahlungsweise</h3>
				
					<?php
                        $zahlung = ($session_data['zahlungsweise']);	                        
	                        if ($zahlung == 'dauerauftrag'){
		                        echo _e('Monatlicher Dauerauftrag', 'child-sponsor-lang');
	                        } 
	                        elseif ($zahlung == 'lsv'){
		                        echo _e('Direct Debit - LSV', 'child-sponsor-lang');
		                        echo '&nbsp;<a class="lsv-box" href="https://www.compassion.ch/wp-content/uploads/documents_compassion/Formulaire_LSV_DD_DE.pdf">LSV Formular aufladen</a>';
	                        }
                                                 
                        ?>
                    <?php } ?>   

                <h3>Korrespondenz mit <?php echo $child_meta['name']; ?></h3>
                
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
				<h3>Wie hast du von Compassion erfahren?</h3>
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
                
                
                <h3>Sende mir mehr Informationen, wie ich mich für Kinder in Not einsetzen kann</h3>
						<?php if (isset($session_data['mithelfen'])) {
				  		echo _e('JA', 'child-sponsor-lang'); 
				  		} else {echo _e('NEIN', 'child-sponsor-lang');}
				  ?> 
				  
				    <hr>
                
               <p>Wenn du noch Fragen zu deiner Patenschaft hast, melde dich gerne bei uns: Tel : 031 552 21 21 (Montag bis Freitag von 8.00-16.00 Uhr) - Email: info@compassion.ch</p>

			   <p>Herzlich willkommen in der grossen internationalen Familie von Compassion!<br/>
				   Freundliche Grüsse,<br/>Carole Rochat und das Compassion Schweiz Team.</p>
            </div>
            
            <p style="text-align: center;padding-top:30px"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/compassion-logo-dark-de.png" width="242" height="93" alt="" /><p>


        </td>
    </tr>
</table>
<!-- End of wrapper table -->
</body>
</html>