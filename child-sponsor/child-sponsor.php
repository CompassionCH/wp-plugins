<?php

/*
 * Plugin Name: Compassion Child Sponsor
 * Version:     0.0.1
 * Author:      giftGRUEN GmbH
*/
defined('ABSPATH') || die();

define('COMPASSION_CHILD_SPONSOR_DIR_URL', plugin_dir_url(__FILE__));
$wapr = isset($_SESSION['utm_source']) && $_SESSION['utm_source']=='wrpr';
add_action('plugins_loaded', 'sponsor_load_textdomain');
function sponsor_load_textdomain()
{
    load_plugin_textdomain('child-sponsor-lang', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}


class ChildSponsor {
    private $step;

    public function __construct()
    {
        add_action('init', [$this, '__init']);
        register_activation_hook(__FILE__, array($this, 'activation'));
    }

    /**
     * Called on plugin activation.
     */
    public function activation(): void
    {
        $this->check_dependencies();
    }

    public function check_dependencies(): void
    {
        if(!class_exists('CompassionOdooConnector')) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( sprintf(__( 'Please install and activate: %s.', 'compassion' ), 'compassion-odoo'), 'Plugin dependency check', array( 'back_link' => true ) );
        }
    }

    public function __init(): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        add_shortcode('child-sponsor', array($this, 'shortcode'));

        // load styles
        wp_enqueue_style('child-sponsor', plugin_dir_url(__FILE__) . '/assets/stylesheets/screen.css', array(), null);

    }

    /**
     * Load email template
     *
     * @param $template
     * @param $data
     * @return string
     */
    private function get_email_template($template, $data): string
    {

        $my_current_lang = apply_filters('wpml_current_language', NULL);
        ob_start();
        $session_data = $data;
        if ($my_current_lang == "fr") {
            include('templates/email/' . $template);
        } elseif ($my_current_lang == "de") {
            include('templates/email_de/' . $template);
        } elseif ($my_current_lang == "it") {
            include('templates/email_it/' . $template);
        }
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * Load email template
     *
     * @param $data
     * @return bool|string
     */
    private function send_data($data): bool|string
    {
        ob_start();
        $session_data = $data;
        /**
         * deactivate child
         */
        $my_current_lang = apply_filters('wpml_current_language', NULL);
        if ($my_current_lang == "fr") {
            $postupdate = apply_filters('wpml_object_id', $session_data['childID'], 'post', FALSE, 'de');
            $postupdate1 = apply_filters('wpml_object_id', $session_data['childID'], 'post', FALSE, 'it');
        } elseif ($my_current_lang == "de") {
            $postupdate = apply_filters('wpml_object_id', $session_data['childID'], 'post', FALSE, 'fr');
            $postupdate1 = apply_filters('wpml_object_id', $session_data['childID'], 'post', FALSE, 'it');

        } elseif ($my_current_lang == "it") {
            $postupdate = apply_filters('wpml_object_id', $session_data['childID'], 'post', FALSE, 'fr');
            $postupdate1 = apply_filters('wpml_object_id', $session_data['childID'], 'post', FALSE, 'de');
        }
        wp_update_post([
            'ID' => $postupdate,
            'post_status' => 'Trash'
        ]);
        wp_update_post([
            'ID' => $postupdate1,
            'post_status' => 'Trash'
        ]);
        wp_update_post([
            'ID' => $session_data['childID'],
            'post_status' => 'Trash'
        ]);

        // JSON-RPC call to Odoo to insert Sponsorship
        $child_meta = get_child_meta($session_data['childID']);
        $utm_source = false;
        $utm_medium = false;
        $utm_campaign = false;
        if(isset($_SESSION) AND isset($_SESSION['utm_source'])) {
            $utm_source = $_SESSION['utm_source'];
        }
        if(isset($_SESSION) AND isset($_SESSION['utm_medium'])) {
            $utm_medium = $_SESSION['utm_medium'];
        }
        if(isset($_SESSION) AND isset($_SESSION['utm_campaign'])) {
            $utm_campaign = $_SESSION['utm_campaign'];
        }
        try {
            $odoo = new CompassionOdooConnector();
            $result = $odoo->call_method(
                'recurring.contract', 'create_sponsorship',
                array($child_meta['number'], $session_data, $my_current_lang, $utm_source, $utm_medium, $utm_campaign)
            );
            // Debug the $result variable
            error_log('$result: ' . print_r($result, true));
            if (!$result) {
                $this->send_fail_email($data);
            }
        } catch (Exception $e) {
            // Log the exception details
            error_log('Exception caught: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $this->send_fail_email($data);
        }

        ob_end_clean();
        return true;
    }

    private function send_fail_email($data): void
    {
        // Send info in case of failure
        $email = new PHPMailer\PHPMailer\PHPMailer();
        $email->isSMTP();                                      // Set mailer to use SMTP
        $email->Host = 'mail.infomaniak.com';  // Specify main and backup SMTP servers
        $email->SMTPAuth = true;                               // Enable SMTP authentication
        $email->Username = 'postmaster@filmgottesdienst.ch';                 // SMTP username
        $email->Password = TEST_SMTP_KEY;                           // SMTP password
        $email->Port = 587;
        $email->CharSet = 'UTF-8';
        $email->From = 'wordpress@compassion.ch';
        $email->FromName = 'Compassion Website';
        $email->Subject = 'Error while processing sponsorship from the website';
        $email->Body = $this->get_email_template('user-new-sponsor.php', $data);
        $email->isHTML(true);
        $email->AddAddress('ecino@compassion.ch');
        $email->AddCC('ecino@compassion.ch');
        $email->addCustomHeader('X-SMTPAPI', '{"filters": {"subscriptiontrack" : {"settings" : {"enable" : 0}}}}');
        $email->Send();
    }

    /**
     * Process form data
     *
     * @param array $data
     */
    private function process_form_data(array $data): void
    {
        $session_data = $_SESSION['child-sponsor'];

        switch ($this->step) {
            case 1:
                if (!isset($session_data['childID']) || isset($_GET['childid'])) {
                    $_SESSION['child-sponsor'] = [
                        'childID' => $_GET['childid']
                    ];
                }
                break;
            case 3:
                $this->send_data($session_data);
                break;
            default:
                $_SESSION['child-sponsor'] = array_merge($session_data, $data);
                break;
        }

    }

    /**
     * Generate shortcode
     *
     * Process form data and load next template
     *
     * @return string
     */
    public function shortcode(): string
    {
        $this->step = (isset($_GET['step'])) ? intval($_GET['step']) : 1;

        /**
         * Check if childID is set
         */
        if (($this->step == 1 && (!(isset($_GET['childid']) && get_post_type($_GET['childid']) == 'child')) && !(isset($_SESSION['child-sponsor']['childID']) && get_post_type($_SESSION['child-sponsor']['childID']) == 'child')) ||
            ($this->step != 1 && !(isset($_SESSION['child-sponsor']['childID']) && get_post_type($_SESSION['child-sponsor']['childID']) == 'child'))
        ) {
            return '<div class="section background-white"><h2 class="text-center">' . __('Es ist ein Fehler aufgetreten', 'compassion') . '</h2></div>';
        }

        /**
         * check if child is public
         */
        if ($this->step == 1 && isset($_GET['childid']) && get_post_status($_GET['childid']) != 'publish') {
            return '<div class="section background-white"><h2 class="text-center">' . __('Es ist ein Fehler aufgetreten', 'compassion') . '</h2></div>';
        }

        /**
         * process form data
         */
        $this->process_form_data($_POST);

        $session_data = $_SESSION['child-sponsor'];

        /**
         * load template
         */
        ob_start();


        include("templates/frontend/header.php");
        include("templates/frontend/step-$this->step.php");
        $content = ob_get_contents();
        ob_end_clean();

        /**
         * return shortcode
         */
        return $content;
    }

}

new ChildSponsor();
