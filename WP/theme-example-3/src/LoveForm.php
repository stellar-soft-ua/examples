<?php

namespace THEME\Theme;

use THEME\Framework\Enqueues\EnqueueScript;
use THEME\Framework\Enqueues\EnqueueStyle;
use THEME\Framework\Enqueues\Script;
use THEME\Framework\Enqueues\Style;
use THEME\Framework\Hooks\ActionHook;

class LoveForm
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('wp_ajax_loveform_action', [$this, 'loveform_action_function']);
        add_action('wp_ajax_nopriv_loveform_action', [$this, 'loveform_action_function']);
    }

    function loveform_action_function()
    {
        check_ajax_referer('loveform', 'security');
        $keys = array();
        $result = array();

        $post = get_post($_POST['page_id']);
        //$pattern = get_shortcode_regex();
        $pattern = "\[(\[?)(et_pb_theme_form)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)";
        if (preg_match_all('/' . $pattern . '/s', $post->post_content, $matches)) {
            foreach ($matches[0] as $key => $value) {
                // $matches[3] return the shortcode attribute as string
                // replace space with '&' for parse_str() function

                $get = str_replace(" ", "&", $matches[3][$key]);
                $get = str_replace('"', "", $get);
                parse_str($get, $output);

                //get all shortcode attribute keys
                $keys = array_unique(array_merge($keys, array_keys($output)));
                $result[] = $output;
            }
            if ($keys && $result) {
                // Loop the result array and add the missing shortcode attribute key
                foreach ($result as $key => $value) {
                    // Loop the shortcode attribute key
                    foreach ($keys as $attr_key) {


                        $result[$key][$attr_key] = isset($result[$key][$attr_key]) ? $result[$key][$attr_key] : NULL;

                    }
                    //sort the array key
                    ksort($result[$key]);
                }
            }
        }


//        global $et_pb_contact_form_num;
        $et_pb_contact_form_num = $_POST['form_unique_id'];//$this->shortcode_callback_num();


        $email = $result[$et_pb_contact_form_num]['email'];
        $title = $_POST['title'];
        $subject = $_POST['subject'];
        $submit_txt = $_POST['submit_txt'];
        $sender_name = $_POST['sender_name'];
        $sender_mail = $_POST['sender_mail'];
        $replyto_namefield = $_POST['replyto_namefield'];
        $replyto_mailfield = $_POST['replyto_mailfield'];
        $custom_message = $_POST['custom_message'];
        $use_redirect = $_POST['use_redirect'];
        $redirect_url = $_POST['redirect_url'];
        $success_message = $_POST['success_message'];

        $success_message = '' !== $success_message ? $success_message : esc_html__('Thanks for contacting us', 'theme');


        $content = $this->shortcode_content;

        $et_error_message = '';
        $et_contact_error = false;
        $current_form_fields = isset($_POST['et_pb_contact_email_fields_' . $et_pb_contact_form_num]) ? $_POST['et_pb_contact_email_fields_' . $et_pb_contact_form_num] : '';


        $contact_email = '';
        $processed_fields_values = array();

        if ('' !== $current_form_fields) {
            $fields_data_json = str_replace('\\', '', $current_form_fields);
            $fields_data_array = json_decode($fields_data_json, true);
            // check all fields on current form and generate error message if needed

            if ((isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) and $result[$et_pb_contact_form_num]['captcha'] !== 'off') {

                //your site secret key
                $secret = get_option('recaptcha_secret');
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if ($responseData->success) {
                } else {
                    $return = array(
                        'sent' => false,
                        'captcha' => false,
                        'message' => 'wrong captcha',
                    );
                    wp_send_json($return);
                }
            } elseif ($result[$et_pb_contact_form_num]['captcha'] === 'off') {

                // keine captcha validierung
            } else {
                $return = array(
                    'sent' => false,
                    'captcha' => false,
                    'message' => 'wrong captcha',
                );
                wp_send_json($return);
            }
            if (!empty($fields_data_array)) {
                foreach ($fields_data_array as $index => $value) {
                    // check all the required fields, generate error message if required field is empty
                    if ($value['field_type'] === "checkbox") {
                        // TODO check if min. one radio of group is checked
                    } elseif ($value['field_type'] === "radiogroup") {
                        // TODO check if min. one radio of group is checked
                    } elseif ($value['field_type'] === "file") {
                        // TODO check if min. one radio of group is checked
                    } else {
                        if ('required' === $value['required_mark'] && empty($_POST[$value['field_id']])) {
                            $et_error_message .= sprintf('<p class="et_pb_contact_error_text">%1$s</p>', esc_html__('Make sure you fill in all required fields.', 'theme') . $_POST[$value['field_id']]);
                            $et_contact_error = true;
                            continue;
                        }
                    }

                    // additional check for email field
                    if ('email' === $value['field_type'] && 'required' === $value['required_mark'] && !empty($_POST[$value['field_id']])) {
                        $contact_email = sanitize_email($_POST[$value['field_id']]);
                        if (!is_email($contact_email)) {
                            $et_error_message .= sprintf('<p class="et_pb_contact_error_text">%1$s</p>', esc_html__('Invalid Email.', 'theme'));
                            $et_contact_error = true;
                        }
                    }
                }
            }
        }
        if (get_option('love_form_framework') == 'materialize') {

            foreach ($_POST as $key => $value) {
                if (substr($key, -5) != '_name' && (0 === strpos($key, 'theme_form_'))) {

                    // check if filed is required

                    // Do validation
                    $processed_fields_values[$_POST[$key . '_name']] = $value;
                }
            }
        } else {
            $current_form_fields = isset($_POST['et_pb_contact_email_fields_' . $et_pb_contact_form_num]) ? $_POST['et_pb_contact_email_fields_' . $et_pb_contact_form_num] : '';
            if ('' !== $current_form_fields) {
                $fields_data_json = str_replace('\\', '', $current_form_fields);
            }
            $fields_data_array = json_decode($fields_data_json, true);
            foreach ($_POST as $key => $value) {

                if (0 === strpos($key, 'theme_form_')) {

                    $current_form_field_key = array_search($key, array_column($fields_data_array, 'field_id'));
                    // check if filed is required

                    // Do validation
                    $processed_fields_values[$fields_data_array[$current_form_field_key]['field_label']] = $value;
                }
            }
        }


        $error = false;
        $files = array();

        $uploaddir = plugin_dir_path(__DIR__) . 'loveuploads/';

        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        foreach ($_FILES as $file) {
            if (move_uploaded_file($file['tmp_name'], $uploaddir . basename($file['name']))) {

                $file_type = $file['type']; //returns the mimetype
                // only allow good files

                $allowed = array("image/jpeg", "image/png", "application/pdf", "application/msword", "application/zip");
                if (in_array($file_type, $allowed)) {
                    $files[] = $uploaddir . $file['name'];
                } else {
                    $et_contact_error = true;
                    $et_error_message .= sprintf('<p class="et_pb_contact_error_text">%1$s</p>', esc_html__('File type not allowed.', 'theme'));
                }
            } else {

                $et_contact_error = true;
                $et_error_message .= sprintf('<p class="et_pb_contact_error_text">%1$s</p>', esc_html__('Can\'t upload file.', 'theme'));
            }
        }
        $nonce_result = isset($_POST['_wpnonce-et-pb-contact-form-submitted']) && wp_verify_nonce($_POST['_wpnonce-et-pb-contact-form-submitted'], 'et-pb-contact-form-submit') ? true : false;

        if (!$et_contact_error && $nonce_result) {
            $et_email_to = '' !== $email
                ? $email
                : get_site_option('admin_email');

            $et_site_name = get_option('blogname');
            // Todo: im shortcode sollte anwählbar sein, welches feld der Name ist...
            $contact_name = isset($processed_fields_values['Name']) ? stripslashes(sanitize_text_field($processed_fields_values['Name'])) : '';

            if ('' !== $custom_message) {
                $message_pattern = $custom_message;
                // insert the data from contact form into the message pattern
                foreach ($processed_fields_values as $key => $value) {
                    $message_pattern = str_ireplace("%%{$key}%%", $value['value'], $message_pattern);
                }
            } else {
                // use default message pattern if custom pattern is not defined
                $message_pattern = isset($processed_fields_values['message']['value']) ? $processed_fields_values['message']['value'] : '';


                // Add all custom fields into the message body by default
                foreach ($processed_fields_values as $key => $value) {
                    if (is_array($value)) {
                        // checkboxes

                        $message_pattern .= "\r\n";
                        $message_pattern .= sprintf(
                            '%1$s: %2$s',
                            $key,
                            implode(",", $value)
                        );
                    } else {
                        if (!in_array($key, array('message', 'name', 'email'))) {
                            $message_pattern .= "\r\n";
                            $message_pattern .= sprintf(
                                '%1$s: %2$s',
                                $key,
                                $value
                            );
                        }
                    }
                }
            }

            if (substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.') {
                $domain = substr($_SERVER['HTTP_HOST'], 4);
            } else {
                $domain = $_SERVER['HTTP_HOST'];
            }

            $sender_name = empty($sender_name) ? 'no-reply@' . $domain : $sender_name;
            $sender_mail = empty($sender_mail) ? 'no-reply@' . $domain : $sender_mail;

            $subject = empty($subject) ? __('New Message From %1$s', 'theme') : $subject;

            // $contact_name = isset( $processed_fields_values[$replyto_namefield] ) ? stripslashes( sanitize_text_field( $processed_fields_values[$replyto_namefield] ) ) : $sender_name;
            // $contact_mail = isset( $processed_fields_values[$replyto_mailfield] ) ? stripslashes( sanitize_text_field( $processed_fields_values[$replyto_mailfield] ) ) : $sender_mail;
            $contact_name = empty($replyto_namefield) ? $sender_name : $replyto_namefield;
            $contact_mail = empty($replyto_mailfield) ? $sender_mail : $replyto_mailfield;

            $headers[] = 'From: "' . $sender_name . '" <' . $sender_mail . '>';
            $headers[] = 'Reply-To: "' . $contact_name . '" <' . $contact_mail . '>';

            $mailer = wp_mail(apply_filters('et_contact_page_email_to', $et_email_to),
                $subject,
                stripslashes(wp_strip_all_tags($message_pattern)), apply_filters('et_contact_page_headers', $headers, $contact_name, $contact_email),
                $files);


            foreach ($files as $fileToDelete) {

                unlink($fileToDelete);
            }
            if ($mailer) {
                $return = array(
                    'sent' => true,
                    'captcha' => true,
                    'message' => $custom_message,
                );
            } else {
                $return = array(
                    'sent' => false,
                    'captcha' => true,
                    'message' => $custom_message,
                );
            }

            wp_send_json($return);
            //$et_error_message = sprintf( '<p>%1$s</p>', esc_html( $success_message ) );
        } else {
            $et_error_message .= sprintf('<p class="et_pb_contact_error_text">%1$s</p>', esc_html__('Capcha invalid.', 'theme'));
            $et_contact_error = true;

            $return = array(
                'sent' => false,
                'message' => $et_error_message,
                'captcha' => true,
            );
            wp_send_json($return);
        }

    }
}