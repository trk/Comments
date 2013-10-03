<?php
/**
 * Comment TagManager
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
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
     * Form validation result array.
     * Do validation only once
     *
     * array(
     * 		'form_name1' => TRUE,
     * 		'form_name2 => 	FALSE
     * );
     *
     * @var array
     *
     */
    protected static $fvr = array();
    
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

        /**
         * If user not have permission for create comment send error message
         * @TODO uncomment this when we can set rules for website visitors... For now allow visitors post comment
         */
//        if(!Authority::can('create', 'module/comments/admin'))
//        {
//            TagManager_Form::set_additional_error($form_name, lang('module_comments_permission_create'));
//        }

        if(TagManager_Form::validate($form_name))
        {
            self::load_model('article_model', '');
            self::load_model('comments_model', '');

            $article = self::$ci->article_model->get_row_array(array('id_article' => self::$ci->input->post('id_article')));

            // If for validation done continue
            if (!empty($article) && $article['comment_allow'] == 1 && self::$ci->comments_model->_check_expire($article))
            {
                $posted = self::$ci->input->post();

                self::_prepare_data();

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
                self::$data['ip']       = self::$ci->comments_model->get_client_ip();

                // Set Status
                self::$data['status']   = 0;

                // If article comment autovalid is active allow auto publish
                if($article['comment_autovalid'] == 1)
                    self::$data['status'] = 1;

                // Set Admin
                self::$data['admin']    = 0;

                // IF user logged in set status "1"
                if(User()->logged_in())
                {
                    $user = User()->get_user();

                    // 100
                    if($user['role_level'] >= 5000)
                    {
                        self::$data['status'] = 1;
                        self::$data['admin'] = 1;
                    }
                }

                // Get User information, if an user connected! Else use form data
                if(self::$ci->comments_model->_get_user() != FALSE)
                {
                    $user = self::$ci->comments_model->_get_user();

                    self::$data['author']   = $user['author'];
                    self::$data['email']    = $user['email'];
                }

                self::$ci->comments_model->save(self::$data);

                /**
                 * If send mail is true send mail to user and admin
                 *
                 * @TODO send mail to user and administrator
                 */
                // TagManager_Email::send_form_emails($tag, $form_name, $posted);

                $message = TagManager_Form::get_form_message('success');
                TagManager_Form::set_additional_success($form_name, $message);

                // Alternative : Set the message by using directly one lang translated key :
                // TagManager_Form::set_additional_success($form_name, lang('form_message_success'));

                $redirect = TagManager_Form::get_form_redirect();
                if ($redirect !== FALSE) redirect($redirect);
            }
            else
            {
                self::$fvr[$form_name] = FALSE;
                log_message('error', 'From error');
                TagManager_Form::set_additional_error($form_name, lang('module_comments_permission_create'));
            }
        }
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