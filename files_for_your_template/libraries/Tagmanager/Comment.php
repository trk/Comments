<?php
/**
 * Comment TagManager
 */
class TagManager_Comment extends TagManager
{
    /**
     * Fields on wich the htmlspecialchars function will not be used before saving
     *
     * @var array
     */
    protected static $no_htmlspecialchars = array();

    /**
     * Data array representing one category
     *
     * @var array
     */
    protected static $data = array();

    /**
     * Default Database Table
     *
     * @var string
     */
    protected static $table = 'article_comment';
    
	/**
	 * Processes the form POST data.
	 *
	 * @param FTL_Binding		'init' tag (not the user one because this method is run before any tag parsing)
	 *							This tag is supposed to be only used to send Emails.
	 * 							With this tag, Emails views have access to the global tags, but not to any other
	 * 							object tag.
	 *
	 * @return void
	 *
	 */
	public static function process_data(FTL_Binding $tag)
	{
		// Name of the form : Must be send to identify the form.
		$form_name = self::$ci->input->post('form');

		// Because Form are processed before any tag rendering, we have to run the validation
		if (TagManager_Form::validate($form_name))
		{
			//
			// ... Here you do what you want with the data ...
			//
			// For the example, we will send one email to the address the user gave in the form
			//

			// Posted data
			// To see the posted array, uncomment trace($posted)
			// If you prefer to see these data through one log file,
			// uncomment log_message(...) and be sure /application/config/config.php contains :
			// $config['log_threshold'] = 1;
			// The log files are located in : /application/logs/log-YYYY-MM-DD.php
			// We prefer to log our 'dev' data as 'error' to not see the all CodeIgniter 'debug' messages.

			$posted = self::$ci->input->post();

            self::_prepare_data();

            self::load_model('comments_model', '');

            /**
             * Get article data from TAGS
             * @TODO Check here find solution for getting data from parent tags
             */
//            $article = $tag->getParent('article');
//            // Set "id_article"
//            self::$data['id_article'] = $article['id_article'];

            // Set "id_article_comment" empty for new comment
            self::$data['id_article_comment']   = '';
            // Get Cliend IP
            self::$data['ip']           = self::$ci->comments_model->get_client_ip();
            // Set Status
            self::$data['status']       = 0;

            // Get User information, if an user connected! Else use form data
            if(self::$ci->comments_model->_get_user() != FALSE)
            {
                $user = self::$ci->comments_model->_get_user();

                self::$data['author']   = $user['author'];
                self::$data['email']    = $user['email'];
            }

            // log_message('error', 'Comment Form DATA //=> ' . print_r(self::$data, TRUE));

            self::$ci->comments_model->save(self::$data);

			// trace($posted);


			// Send the posted data to the Email library and send the Email
			// as defined in /themes/your_theme/config/forms.php
            // @TODO Send email to user and admin when a comment receive
			// TagManager_Email::send_form_emails($tag, $form_name, $posted);

			// Add one custom Success message
			// Get the messages key defined in : /themes/your_theme/config/forms.php
			// You can also set directly one lang translated key
			$message = TagManager_Form::get_form_message('success');
			TagManager_Form::set_additional_success($form_name, $message);

			// Alternative : Set the message by using directly one lang translated key :
			// TagManager_Form::set_additional_success($form_name, lang('form_message_success'));

			// Use of the 'redirect' option of the form config.
			// If no redirect after processing, the form data can be send again if the user refreshes the page
			// To avoid that, we use the redirection directive as set in the config file:
			// /themes/your_theme/config/forms.php
			$redirect = TagManager_Form::get_form_redirect();
			if ($redirect !== FALSE) redirect($redirect);
		}
		/*
		// Normally, nothing should be done here, because the validation process refill the form
		// and doesn't redirect, so the user's filled in data can be used to fill the form again.
		// Remember : If you redirect here, the form refill will not be done, as the data are lost
		// (no access to the posted data anymore after redirection)
		else
		{
			// ... Do something here ...
		}
		*/
	}

    /**
     * Prepares data before saving
     */
    function _prepare_data()
    {

        // Standard fields
        $fields = self::$ci->db->list_fields(self::$table);

        // Set the data to the posted value.
        foreach ($fields as $field)
        {
            if (self::$ci->input->post($field) !== FALSE)
            {
                if ( ! in_array($field, self::$no_htmlspecialchars))
                    self::$data[$field] = htmlspecialchars(self::$ci->input->post($field), ENT_QUOTES, 'utf-8');
                else
                    self::$data[$field] = self::$ci->input->post($field);
            }
        }

    }
}