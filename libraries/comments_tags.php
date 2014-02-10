<?php

/**
 * Comments Module's TagManager
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Comments_Tags extends TagManager {

    protected static $SEC_IN_MINUTE   = 60; // How many seconds are in a minute
    protected static $SEC_IN_HOUR     = 3600; // How many seconds are in an hour
    protected static $SEC_IN_DAY      = 86400; // How many seconds are in a day
    protected static $SEC_IN_WEEK     = 604800; // How many seconds are in a week
    protected static $SEC_IN_MONTH    = 2630880; // How many seconds are in a month
    protected static $SEC_IN_YEAR     = 31556926; // How many seconds are in a year

    /**
     * Tags declaration
     * To be available, each tag must be declared in this static array.
     *
     * @var array
     *
     * @usage	"<tag scope>" => "<method_in_this_class>"
     * 			Examples :
     * 			"articles:hello" => "my_hello_method" : The tag "hello" will be usable as child of "articles"
     * 			"comments:comments" => "my_comments_method"
     */
    public static $tag_definitions = array
        (
            'comments:view'                     => 'tag_view',
            'comments:list'                     => 'tag_list',
            'comments:list:id_article_comment'  => 'tag_comments_simple_value',
            'comments:list:id_article'          => 'tag_comments_simple_value',
            'comments:list:author'              => 'tag_comments_simple_value',
            'comments:list:email'               => 'tag_comments_simple_value',
            'comments:list:site'                => 'tag_comments_simple_value',
            'comments:list:content'             => 'tag_comments_simple_value',
            'comments:list:ip'                  => 'tag_comments_simple_value',
            'comments:list:status'              => 'tag_comments_simple_value',
            'comments:list:created'             => 'tag_comments_simple_date',
            'comments:list:updated'             => 'tag_comments_simple_date',
            'comments:list:admin'               => 'tag_comments_simple_value',
            'comments:list:time_ago'            => 'tag_time_ago',
            "comments:count"                    => "tag_count",
            "comments:gravatar"                 => "tag_gravatar",
            "comments:can"                      => "tag_can",
        );

    // ------------------------------------------------------------------------

    /**
     * Base module tag
     * The index function of this class refers to the <ion:#module_name /> tag
     * In other words, this function makes the <ion:#module_name /> tag
     * available as main module parent tag for all other tags defined
     * in this class.
     *
     * @usage	<ion:comments >
     *			...
     *			</ion:comments>
     *
     */
    public static function index(FTL_Binding $tag)
    {
        $str = $tag->expand();
        return $str;
    }

    // ------------------------------------------------------------------------

    /**
     * Loads a partial view from a FTL tag
     * Callback function linked to the tag <ion:partial />
     *
     * @param	FTL_Binding
     * @return 	string
     *
     */
    /**
    -     * Loads the main Front module's view
    -     * Because the parent tag (index) is expanded, the result of this method will be displayed
    -     *
    -     * @param FTL_Binding $tag
    -     *
    -     * @return mixed
    -     */
    public static function tag_view(FTL_Binding $tag)
    {
        $file       = $tag->getAttribute('file');
        $allowed    = $tag->getAttribute('allowed', TRUE);
        $show       = $tag->getAttribute('show', FALSE);
        $error      = $tag->getAttribute('error', FALSE);

        $article = $tag->get('article');

        if($allowed)
        {

            // Model load
            self::load_model('comments_model', '');

            if($article['comment_allow'] == 0 || !self::$ci->comments_model->_check_expire($article))
            {
                if($show)
                {
                    return self::_view($tag, $file);
                }
                if($error)
                {
                    if(!self::$ci->comments_model->_check_expire($article))
                        $alert_text = lang('module_comments_comments_expired');
                    else
                        $alert_text = lang('module_comments_comments_not_allowed');

                    $error_file = Theme::load('article_comment_error');
                    return $tag->parse_as_nested($error_file, array('alert_text' => $alert_text));
                }
                return '';
            }
            else
            {
                return self::_view($tag, $file);
            }
        }
    }

    public static function _view(FTL_Binding $tag, $file)
    {
        if (!is_null($file) && @file_exists(MODPATH.'Comments/views/' . $file . EXT))
        {
            if( $tag->getAttribute('php') == TRUE)
            {
                $data = $tag->getAttribute('data', array());
                return self::$ci->load->view($file, $data, TRUE);
            }
            else
            {
                $load_file = Theme::load($file);
                return $tag->parse_as_nested($load_file);
            }
        }
        if(!is_null($file))
            return self::show_tag_error(
                $tag,
                'View file <b>"'. $file.EXT .'"</b> could not found.'
            );
        else
            return self::show_tag_error(
                $tag,
                'Please specify <b>"the file name"</b>, which want to use.'
            );
    }

    // ------------------------------------------------------------------------

    /**
     * Comments Tag : Loops through comments
     *
     * @param FTL_Binding $tag
     * @return string
     *
     * @usage	<ion:comments>
     *              <ion:comments>
     *				    ...
     *              <ion:comments>
     *			</ion:comments>
     *
     */
    public static function tag_list(FTL_Binding $tag)
    {
        // Returned string
        $str = '';

        // Model load
        self::load_model('comments_model', '');

        $article = $tag->get('article');
        $order_by = $tag->getAttribute('order_by');
        if(! empty($order_by))
            $where['order_by'] = $order_by;

        // Prepare where
        $where['id_article']    = $article['id_article'];

        // @TODO Get user and if user is admin show all comments
        // $user = User()->get_user();

        $user = USER()->get_user();

        if(empty($user) && ($user['role_code'] != 'role_code' || $user['role_code'] != 'role_code'))
            $where['status']        = 1;

        // Comments array
        $article_comments = self::$ci->comments_model->get_list($where);
        $tag->set('article_comments', $article_comments);

        foreach($article_comments as $article_comment)
        {
            // Set the local tag var "article_comment"
            $tag->set('article_comment', $article_comment);

            // Tag expand : Process of the children tags
            $str .= $tag->expand();
        }

        return $str;
    }

    // ------------------------------------------------------------------------

    /**
     * Connect to "core" for "tag_simple_date" function
     *
     * @param FTL_Binding $tag
     * @return Mixed|string
     */
    public static function tag_comments_simple_date(FTL_Binding $tag)
    {
        $tag->setAttribute('from', 'article_comment');

        return self::tag_simple_date($tag);
    }

    // ------------------------------------------------------------------------

    /**
     * Connect to "core" for "tag_simple_value" function
     * @param FTL_Binding $tag
     * @return null|string
     */
    public static function tag_comments_simple_value(FTL_Binding $tag)
    {
        $tag->setAttribute('from', 'article_comment');

        return self::tag_simple_value($tag);
    }

    // ------------------------------------------------------------------------

    /**
     * Count tag
     *
     * @param		FTL_Binding		Tag object
     * @return		String			Tag attribute or ''
     *
     * @usage		<ion:comments />
     *					<ion:count field="pending|published|all" />
     * 				</ion:comments>
     *
     */
    public static function tag_count(FTL_Binding $tag)
    {
        // Returns the field value or if NULL set value "published"
        $field  = $tag->getAttribute('field', 'published');
        $lang   = $tag->getAttribute('lang');

        // Model load
        self::load_model('comments_model', '');

        $article = $tag->get('article');

        // Count Comments array [pending,published,all]
        $count_article_comments = self::$ci->comments_model->count_article_comments($article['id_article']);

        if ( ! is_null($field) && array_key_exists($field, $count_article_comments))
        {
            // Get the count result
            $count = $count_article_comments[$field];

            if(! empty($lang))
                return lang($lang, $count);

            return $count;
        }

        // Here we have the choice :
        // - Ether return nothing if the field attribute isn't set or doesn't exist
        // - Ether silently return ''
        return self::show_tag_error(
            $tag,
            'The attribute <b>"field"</b> is not set or the field doesn\'t exists.'
        );

        // return '';
    }

    // ------------------------------------------------------------------------

    /**
     * If author have Gravatar
     * //=> Attributes :
     *      default : 	can be "mm" (people shadow), "identicon" (default)
     *      "monsterid", "wavatar", "retro" or link to a public accessible default image
     *
     * @TODO Allow to define the size
     *
     * @param FTL_Binding $tag
     * @return string
     */
    public static function tag_gravatar(FTL_Binding $tag) {

        // Using "identicon" if no other default avatar is specified
        $default_avatar = isset($tag->attr['default']) ? $tag->attr['default'] : 'identicon';

        $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($tag->locals->article_comment["email"]))) . "?s=80&d=" . $default_avatar;

        return $grav_url;

    }

    // ------------------------------------------------------------------------

    /**
     * Check user permissions
     *
     * @param FTL_Binding $tag
     *
     * @return string
     */
    public static function tag_can(FTL_Binding $tag)
    {

        $is     = $tag->getAttribute('is', TRUE);
        $role   = $tag->getAttribute('role');

        // If user is visitor allow visitor to see comments and allow visitor write a comment
//        if(! empty($role) && !User()->logged_in())
//        {
//            if($role == 'view' || $role == 'create') { return $tag->expand(); }
//            else { return ''; }
//        }

//        log_message('error', 'USER //=> ' . User()->logged_in());

        if (! empty($role) && Authority::can($role, 'module/comments/admin') == $is)
        {
            return $tag->expand();
        }
        else
        {
            return '';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * <ion:time_ago />
     *
     * @param FTL_Binding $tag
     * @return string
     */
    public static function tag_time_ago(FTL_Binding $tag)
    {
        $comment = $tag->get('article_comment');

        return self::time_passed($comment['created']);
    }

    // ------------------------------------------------------------------------

    /**
     *
     * This function calculates how long ago a certain
     * date passed in was.
     *
     */
    function time_passed($date) {

        /**
         * This code block checks to see what type of date is
         * passed in and then obtains the difference in
         * seconds.
         */

        if (empty($date)) {
            return lang('module_comments_label_no_date_provided');
        }

        if ($date instanceof DateTime) {
            $c = new DateTime();
            $cTime = $c->getTimestamp();
            $dTime = $date->getTimestamp();
            $diff = $cTime-$dTime;
        } elseif (is_array($date) && isset($date["mon"])) {
            $date = $date[0];
            $c = time();
            $diff = $c-$date;
        } elseif (is_string($date)) {
            $date = strtotime($date);
            $c = time();
            $diff = $c-$date;
        } else {
            $c = time();
            $diff = $c-$date;
        }

        $agostate = ($diff>=0) ? lang('module_comments_label_time_ago') : lang('module_comments_label_from_now');

        $diff = abs($diff);

        /**
         * This section of code converts the seconds in
         * single units based on whether it is a year, month,
         * week, day, hour, minute or second
         */

        if ($diff>=self::$SEC_IN_YEAR) {
            $diff = floor($diff / self::$SEC_IN_YEAR);
            $suffix = lang('module_comments_label_year');
        } elseif ($diff>=self::$SEC_IN_MONTH) {
            $diff = floor($diff / self::$SEC_IN_MONTH);
            $suffix = lang('module_comments_label_month');
        } elseif ($diff>=self::$SEC_IN_WEEK) {
            $diff = floor($diff / self::$SEC_IN_WEEK);
            $suffix = lang('module_comments_label_week');
        } elseif ($diff>=self::$SEC_IN_DAY) {
            $diff = floor($diff / self::$SEC_IN_DAY);
            $suffix = lang('module_comments_label_day');
        } elseif ($diff>=self::$SEC_IN_HOUR) {
            $diff = floor($diff / self::$SEC_IN_HOUR);
            $suffix = lang('module_comments_label_hour');
        } elseif ($diff>=self::$SEC_IN_MINUTE) {
            $diff = floor($diff / self::$SEC_IN_MINUTE);
            $suffix = lang('module_comments_label_minute');
        } elseif ($diff>0) {
            $suffix = lang('module_comments_label_second');
        } else {
            return(lang('module_comments_label_just_now'));
        }

        $return = (($diff==1) ? "{$diff} {$suffix} {$agostate}" : "{$diff} {$suffix}" . lang('module_comments_label_time_ago_plural') . " {$agostate}");

        return $return;
    }
}
