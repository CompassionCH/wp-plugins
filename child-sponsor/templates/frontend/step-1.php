<?php
$child_data = get_child_meta($session_data['childID']);

// muskathlons
$msk = isset($_SESSION['child-sponsor']['msk_participant_name']) || isset($_SESSION['msk_participant_name']);

$wapr = isset($_SESSION['utm_source']) && $_SESSION['utm_source']=='wrpr';

// Partner must be younger than this limit for Write&Pray sponsorship
$wapr_age_limit = 25;

if ($msk) {
    $_SESSION['child-sponsor']['consumer_source'] = $_SESSION['consumer_source'];
    $_SESSION['child-sponsor']['consumer_source_text'] = $_SESSION['consumer_source_text'];
    $_SESSION['child-sponsor']['msk_participant_name'] = $_SESSION['msk_participant_name'];
}
?>

<div class="section background-white step-1 child-sponsor">
    <div class="row">

        <form method="POST" action="?step=2" class="large-8 large-centered medium-10 medium-centered column">

            <div class="progress-steps">
                <ul>
                    <li class="active">1</li>
                    <li>2</li>
                    <li>3</li>
                </ul>
<!--              Writeandpraystuff  -->
			<?php if (!$wapr) { ?>

                <p><?php echo sprintf( wp_kses( __('Mit 42 CHF pro Monat kannst du %s aus der Armut befreien!', 'child-sponsor-lang'), array('br' => []) ), $child_data['name'] ); ?></p>
           <?php } ?>

<!--       emd Writeandpraystuff  -->
                            </div>

            <hr>

            <h4 class="text-uppercase"><?php _e('Meine persönlichen Daten', 'child-sponsor-lang'); ?></h4>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Anrede', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns radio-wrapper1">
                    <input id="radio_frau" required data-msg="<?php _e('Anrede erforderlich', 'child-sponsor-lang'); ?>" type="radio" name="salutation" value="Frau" <?php echo (isset($session_data['salutation']) && $session_data['salutation'] == 'Frau') ? 'checked' : ''; ?>><label for="radio_frau"><?php _e('Frau', 'child-sponsor-lang'); ?></label>
                    <input id="radio_herr" required data-msg="<?php _e('Anrede erforderlich', 'child-sponsor-lang'); ?>" type="radio" name="salutation" value="Herr" <?php echo (isset($session_data['salutation']) && $session_data['salutation'] == 'Herr') ? 'checked' : ''; ?>><label for="radio_herr"><?php _e('Herr', 'child-sponsor-lang'); ?></label>
                    <input id="radio_familie" required data-msg="<?php _e('Anrede erforderlich', 'child-sponsor-lang'); ?>" type="radio" name="salutation" value="Familie" <?php echo (isset($session_data['salutation']) && $session_data['salutation'] == 'Familie') ? 'checked' : ''; ?>><label for="radio_herr"><?php _e('Familie', 'child-sponsor-lang'); ?></label>
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Nachname', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" required data-msg="<?php _e('Nachname erforderlich', 'child-sponsor-lang'); ?>" class="input-field" name="last_name" value="<?php echo (isset($session_data['last_name'])) ? $session_data['last_name'] : ''; ?>">
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Vorname', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" required data-msg="<?php _e('Vorname erforderlich', 'child-sponsor-lang'); ?>" class="input-field" name="first_name" value="<?php echo (isset($session_data['first_name'])) ? $session_data['first_name'] : ''; ?>">
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Strasse/Hausnr.', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" required data-msg="<?php _e('Strasse erforderlich', 'child-sponsor-lang'); ?>" class="input-field" name="street" value="<?php echo (isset($session_data['street'])) ? $session_data['street'] : ''; ?>">
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('PLZ/Ort', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-2 columns">
                    <input type="text" required data-msg="<?php _e('PLZ erforderlich', 'child-sponsor-lang'); ?>" class="input-field" name="zipcode" value="<?php echo (isset($session_data['zipcode'])) ? $session_data['zipcode'] : ''; ?>">
                </div>
                <div class="small-6 columns no-padding-left">
                    <input type="text" required data-msg="<?php _e('Stadt erforderlich', 'child-sponsor-lang'); ?>" class="input-field" name="city" value="<?php echo (isset($session_data['city'])) ? $session_data['city'] : ''; ?>">
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Land', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
	                <input type="text" required data-msg="<?php _e('Länd erforderlich', 'child-sponsor-lang'); ?>" class="input-field" name="land" value="<?php echo (isset($session_data['land'])) ? $session_data['land'] : ''; ?>">
<!--

                    <div class="select-wrapper">
                        <select name="country" class="input-field">
	                         <option value="Schweiz" <?php echo (isset($session_data['country']) && $session_data['country'] == "Schweiz") ? 'selected' : '' ?>><?php _e('Schweiz', 'child-sponsor-lang'); ?></option>
                            <option value="Deutschland" <?php echo (isset($session_data['country']) && $session_data['country'] == "Deutschland") ? 'selected' : '' ?>><?php _e('Deutschland', 'child-sponsor-lang'); ?></option>
                            <option value="Österreich" <?php echo (isset($session_data['country']) && $session_data['country'] == "Österreich") ? 'selected' : '' ?>><?php _e('Österreich', 'child-sponsor-lang'); ?></option>
                        </select>
                    </div>
-->
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Geburtsdatum', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text"
                           id="datepicker"
                           name="birthday"
                           placeholder="31/12/2000"
                           class="input-field"
                           required
                           value="<?php echo (isset($session_data['birthday'])) ? $session_data['birthday'] : ''; ?>"
                           data-default-msg="<?php _e('Geburtsdatum erforderlich', 'child-sponsor-lang'); ?>"
                           data-wrpr="<?= $wapr ? "true" : "false"; ?>"
                           data-wrpr-age-limit="<?= $wapr_age_limit; ?>"
                           data-wrpr-age-limit-msg="<?php _e("Write&Pray Sponsorship are reserved for people under 25. Click here to reach the general sponsorship page", 'child-sponsor-lang'); ?>"
                    />
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('E-Mail-Adresse', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="email" class="input-field" required data-msg="<?php _e('E-Mail-Adresse erforderlich', 'child-sponsor-lang'); ?>" name="email" value="<?php echo (isset($session_data['email'])) ? $session_data['email'] : ''; ?>">
                </div>
            </div>

            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Telefon', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" class="input-field" required data-msg="<?php _e('Telefon erforderlich', 'child-sponsor-lang'); ?>" name="phone" value="<?php echo (isset($session_data['phone'])) ? $session_data['phone'] : ''; ?>">
                </div>
            </div>
              <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Kirchgemeinde', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" class="input-field" name="kirchgemeinde" value="<?php echo (isset($session_data['kirchgemeinde'])) ? $session_data['kirchgemeinde'] : ''; ?>">
                </div>
            </div>
                  <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?php _e('Beruf', 'child-sponsor-lang'); ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" class="input-field" name="Beruf" value="<?php echo (isset($session_data['Beruf'])) ? $session_data['Beruf'] : ''; ?>">
                </div>
            </div>

			<hr>

			<!--              Writeandpraystuff  -->

<?php if (!$wapr) { ?>

            <h4 class="text-uppercase" id="bank"><?php _e('Zahlungsweise', 'child-sponsor-lang'); ?></h4>
				<div class="row">
					 <div class="small-12 columns radio-wrapper">
						   <label><input type="radio" required data-msg="<?php _e('Zahlungsweise erforderlich', 'child-sponsor-lang'); ?>" name="zahlungsweise" value="dauerauftrag"> <?php _e('Monatlicher Dauerauftrag', 'child-sponsor-lang') ?></label>
                           <label><input type="radio" required data-msg="<?php _e('Zahlungsweise erforderlich', 'child-sponsor-lang'); ?>" name="zahlungsweise" value="lsv"> <?php _e('Direct Debit - LSV', 'child-sponsor-lang') ?></label>
					 </div>
					<div class="small-12 columns zahlung">
						<p class="marg-top-10"><?php _e('Wenn du eine andere Zahlungsart wünschst, dann rufe uns bitte an unter 031 552 21 21.', 'child-sponsor-lang' )?></p>
					</div>
				</div>
            <hr>

             <h4 class="text-uppercase" id="Patenschaftplus"><?php _e('Patenschaft plus', 'child-sponsor-lang'); ?></h4>
             	<div class="row">
                <div class="small-12 columns">
                <input class="" type="checkbox" <?php echo (isset($session_data['patenschaftplus']) && $session_data['patenschaftplus']['checkbox'] == 'on') ? 'checked' : ''; ?> name="patenschaftplus[checkbox]"> <span class="marg-left-10 strong-statment">  <?php _e('JA', 'child-sponsor-lang'); ?></span>

                  <p class="marg-top-10"><?php _e('Patenschaft "Plus" beinhaltet die Patenschaft "Basis" von CHF 42.00 und eine Spende von CHF 8.00 pro Monat zusätzlich. Sie erlaubt Compassion, Projekte zu finanzieren um die Umgebung des Patenkindes zu verändern. Die Spenden, die Compassion durch die Patenschaften "Plus" bekommt, gehen in eine gemeinsame Kasse. Dadurch kann Compassion mehrere Projekte im Jahr unterstützen. 50.00 CHF/Monat', 'child-sponsor-lang')?></p>

                </div>
                </div>
<?php } else { ?>
       <h4 class="text-uppercase" id="Patenschaftplus"><?php _e('Write & Pray', 'child-sponsor-lang'); ?></h4>
            <div class="row">
                <div class="small-12 columns radio-wrapper">
                    <label><input type="radio" required data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>" name="writepray" value="WRPR">
                      <?php _e('Ich engagiere mich für mein Patenkind zu beten und ihm regelmässsig zu schreiben.  Ich habe verstanden, dass eine andere Person die Finanzierung dieser Patenschaft übernimmt und ich gegenüber dem Kind der/die offizielle Pate/Patin bin.', 'child-sponsor-lang')?></label>
                    <label><input type="radio" required data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>" name="writepray" value="WRPR+DON">
                        <?php _e('Je m\'engage à [...] et je peux contribuer mensuellement à hauteur de :', 'child-sponsor-lang')?></label>
                </div>
            </div>
            <div class="row hide" id="writepray-contribution" >
                <div class="small-4 columns marg-top-10">
                    <input class="ignore" type="number" min='1' max='42' placeholder="20.- CHF" required data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>" name="writepray-contribution" value="">
                </div>
            </div>

<?php } ?>

          <!--        end Writeandpraystuff  -->


			<hr>

            <h4 class="text-uppercase" id="briefwechsel"><?php echo sprintf( wp_kses( __('Briefwechsel mit %s', 'child-sponsor-lang'), array('br' => []) ), $child_data['name'] ); ?></h4>
            	<div class="row">
	            	<div class="small-12 columns">
						<p><?php _e('Selbstverständlich übersetzen wir deine Briefe gerne, du kannst deine Briefe aber auch direkt in der Sprache des Kindes oder auf Englisch schreiben. Dies spart Zeit und nimmt unseren freiwilligen Übersetzern Arbeit ab. Welche der folgenden Sprachen verstehst du?', 'child-sponsor-lang')?></p>
	            	</div>
            	</div>
           	<div class="row">
                <div class="small-12 medium-6 columns language">
	                 <ul>
					 <li><input id="language" type="checkbox" name="language[]"  value="französich" <?php echo (isset($session_data['language']) && $session_data['language'] == 'französich') ? 'checked' : ''; ?>><label><?php _e('Französisch', 'child-sponsor-lang') ?></label>
		            </li>
					<li><input id="language" type="checkbox" name="language[]"   value="italienisch" <?php echo (isset($session_data['language']) && $session_data['language'] == 'italienisch') ? 'checked' : ''; ?>><label><?php _e('Italienisch', 'child-sponsor-lang') ?></label>
		            </li>

	                 </ul>

		        </div>
                <div class="small-12 medium-6 columns language " >
	                <ul>
		          <li><input id="language" type="checkbox"   name="language[]" value="spanisch" <?php echo (isset($session_data['language']) && $session_data['language'] == 'spanisch') ? 'checked' : ''; ?>><label><?php _e('Spanisch', 'child-sponsor-lang') ?></label>
		            </li>
	                 <li><input id="language" type="checkbox" name="language[]"  value="englisch" <?php echo (isset($session_data['language']) && $session_data['language'] == 'englisch') ? 'checked' : ''; ?>><label><?php _e('Englisch', 'child-sponsor-lang') ?></label>
		            </li>
					<li><input id="language" type="checkbox" name="language[]"  value="portugiesisch" <?php echo (isset($session_data['language']) && $session_data['language'] == 'portugiesisch') ? 'checked' : ''; ?>><label><?php _e('Portugiesisch', 'child-sponsor-lang') ?></label>
		            </li>

	                </ul>
				</div>

			</div>


            <hr>

            <h4 class="text-uppercase" id="bank"><?= __('WIE HAST DU VON COMPASSION ERFAHREN?', 'child-sponsor-lang') ?></h4>
            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?= __('Ich bin aufmerksam geworden durch', 'child-sponsor-lang') ?></label>
                </div>
                <div class="small-8 columns">
                    <?php if (!$msk) { ?>
                    <div class="select-wrapper">
                        <select name="consumer_source" id="consumer_select" required data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>" class="input-field">
                            <option value=""><?php _e('Bitte wählen', 'child-sponsor-lang'); ?></option>
                            <option value="Konzert/Veranstaltung" data-placeholder="<?php _e('Geben Sie das Konzert/Event an', 'child-sponsor-lang'); ?>"<?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Konzert") ? 'selected' : '' ?>><?php _e('Konzert/Veranstaltung', 'child-sponsor-lang'); ?></option>
                            <option value="Kontakt durch Pate/Botschafter"  data-placeholder="<?php _e('Geben Sie Vor- und Nachnamen an', 'child-sponsor-lang'); ?>" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Kontakt durch Pate/Botschafter") ? 'selected' : '' ?>><?php _e('Kontakt durch Pate/Botschafter', 'child-sponsor-lang'); ?></option>
                            <option value="Kontakt durch Compassion Advokate" data-placeholder="<?php _e('Geben Sie Vor- und Nachnamen an', 'child-sponsor-lang'); ?>" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Kontakt durch Compassion Advokate") ? 'selected' : '' ?>><?php _e('Kontakt durch Compassion Advokat', 'child-sponsor-lang'); ?></option>
                            <option value="Gottesdienst/Kirche" data-placeholder="<?php _e('Geben Sie den Namen der Kirche an', 'child-sponsor-lang'); ?>"<?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Gottesdienst/Kirche") ? 'selected' : '' ?>><?php _e('Gottesdienst/Kirche', 'child-sponsor-lang'); ?></option>
                            <option value="Freunde & Verwandte" data-placeholder="<?php _e('Geben Sie Vor- und Nachnamen an', 'child-sponsor-lang'); ?>"<?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Freunde & Verwandte") ? 'selected' : '' ?>><?php _e('Freunde & Verwandte', 'child-sponsor-lang'); ?></option>
                            <option value="Compassion Magazin" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Compassion Magazin") ? 'selected' : '' ?>><?php _e('Compassion Magazin', 'child-sponsor-lang'); ?></option>

                            <option value="Anzeige in Zeitschrift" data-placeholder="<?php _e('Geben Sie das Magazin/die Broschüre an', 'child-sponsor-lang'); ?>"<?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Anzeige in Zeitschrift") ? 'selected' : '' ?>><?php _e('Anzeige in Zeitschrift', 'child-sponsor-lang'); ?></option>
                            <option value="Facebook, Youtube, Vimeo…" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Facebook, Youtube, Vimeo…") ? 'selected' : '' ?>><?php _e('Facebook, Youtube, Vimeo…', 'child-sponsor-lang'); ?></option>
                            <option value="Internet" data-placeholder="<?php _e('Geben Sie die Website an', 'child-sponsor-lang'); ?>" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Internet") ? 'selected' : '' ?>><?php _e('Internet', 'child-sponsor-lang'); ?></option>
                            <option value="Unacceptable" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "unacceptable") ? 'selected' : '' ?>><?php _e('unacceptable', 'child-sponsor-lang'); ?></option>

                            <option value="Muskathlon" data-placeholder="<?php _e('Geben Sie den Namen des Läufers an', 'child-sponsor-lang'); ?>" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Muskathlon") ? 'selected' : '' ?>><?php _e('Muskathlon', 'child-sponsor-lang'); ?></option>
<!--                             <option value="Librairies" data-placeholder="<?php _e('nom de la librairie', 'child-sponsor-lang'); ?>" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Librairies") ? 'selected' : '' ?>><?php _e('Librairies', 'child-sponsor-lang'); ?></option> -->

                            <option value="Andere" data-placeholder="<?php _e('Noch genauer', 'child-sponsor-lang'); ?>" <?php echo (isset($session_data['consumer_source']) && $session_data['consumer_source'] == "Andere") ? 'selected' : '' ?>><?php _e('Andere', 'child-sponsor-lang'); ?></option>
                        </select>
                    </div>
                    <div class="consumer-source-text-wrapper hide">
                        <input type="text" class="input-field place ignore"  name="consumer_source_text" required data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>" value="">
                    </div>
                    <?php } else { ?>
                    <div class="select-wrapper">
                        <select name="consumer_source_info" required disabled selected data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>" class="input-field">
                            <option value="<?= $_SESSION['consumer_source'] ?>">Muskathlon</option>
                        </select>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php if ($msk) { ?>
            <div class="row">
                <div class="small-4 columns">
                    <label class="text-left middle"><?= __('Name des Teilnehmers', 'child-sponsor-lang') ?></label>
                </div>
                <div class="small-8 columns">
                    <input type="text" class="input-field place ignore"
                           name="consumer_source_text_info" required disabled
                           data-msg="<?php _e('Angabe erforderlich', 'child-sponsor-lang'); ?>"
                           value="<?= $_SESSION['msk_participant_name'] ?>"
                    />
                </div>
            </div>
            <?php } ?>
            <hr>

             <h4 class="text-uppercase" id="Patenschaftplus"><?php _e('Mithelfen', 'child-sponsor-lang'); ?></h4>
             	<div class="row">
                <div class="small-12 columns">
	            <input class="" type="checkbox" <?php echo (isset($session_data['mithelfen']) && $session_data['mithelfen']['checkbox'] == 'on') ? 'checked' : ''; ?> name="mithelfen[checkbox]"> <span class="marg-left-10 strong-statment">  <?php _e('JA', 'child-sponsor-lang'); ?></span>
	             <p class="marg-top-10"><?php _e('Senden Sie mir mehr Informationen, wie ich mich für Kinder in Not einsetzen kann', 'child-sponsor-lang')?></p>
                </div>
                </div>
            <hr>

            <div class="form-action">
<!--                 <a href="?step=" class="button button-beige button-small"><?php _e('Zurück', 'child-sponsor-lang'); ?></a> -->
                <input type="submit" class="button button-blue button-small" value="<?php _e('Weiter', 'child-sponsor-lang'); ?>"/>
            </div>

        </form>
    </div>

</div>

<script>
    jQuery(document).ready(function($) {
        $.datepicker.setDefaults({
            changeYear: true,
            yearRange : "c-70:c+0",
            dateFormat: "dd/mm/yy",
            constrainInput: false
        });
        $("#datepicker").datepicker({
          dateFormat: "dd/mm/yy",
        });
    });
</script>
