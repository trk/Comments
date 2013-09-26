<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Theme Forms configuration
|--------------------------------------------------------------------------
|
| This forms config array will be merged with /application/config/forms.php
| You can overwrite standard forms definition by creating your own deifnition
| for the form you wish to overwrite.
|
*/
$config['forms'] = array
(
    // Comment Form
    'comment' => array
    (
        // The method which will process the form
        // The function name has no importance, it must only be in the declared Tagmanager class
        // and be "public static"
        'process' => 'TagManager_Comment::process_data',

        // Redirection after process. Can be 'home' or 'referer' for the $_SERVER['HTTP_REFERER'] value.
        // If not set, doesn't redirect
        'redirect' => 'referer',

        // Messages Language index, as set in language/xx/form_lang.php
        'messages' => array(
            'success' => 'module_comments_form_success_message',
            'error' => 'module_comments_form_error_message',
        ),
        'emails' => array
        (
            /**
             * Administrator Mail Template
             */
            array
            (
                // Emails could be "contact,technical,info"
                'email' => 'contact',
                // Email subject message translatin
                'subject' => 'module_comments_mail_admin_subject',
                // View file to use for the email
                'view' => 'mail/comment/to_admin',
            ),
            /**
             * User Mail Template
             */
            array
            (
                'email' => 'form',
                'subject' => 'module_comments_mail_user_subject',
                'view' => 'mail/comment/to_user',
            ),
        ),
        // Comment Form Required Fields
        'fields' => array
        (
            'author' => array
            (
                'rules' => 'trim|required|min_length[3]|xss_clean',
                'label' => 'module_comments_label_author',
            ),
            'email' => array(
                'rules' => 'trim|required|valid_email|xss_clean',
                'label' => 'module_comments_label_email',
            ),
            'site' => array(
                'rules' => 'trim|xss_clean',
                'label' => 'module_comments_label_site',
            ),
            'content' => array(
                'rules' => 'trim|required|xss_clean',
                'label' => 'module_comments_label_content',
            )
        )
    )
);