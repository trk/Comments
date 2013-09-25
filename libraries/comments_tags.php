<?php

/**
 * Comments Module's TagManager
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Comments_Tags extends TagManager {

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
        "comments:comments"                         => "tag_comments",
        'comments:comments:id_article_comment'      => 'tag_comments_simple_value',
        'comments:comments:id_article'              => 'tag_comments_simple_value',
        'comments:comments:author'                  => 'tag_comments_simple_value',
        'comments:comments:email'                   => 'tag_comments_simple_value',
        'comments:comments:site'                    => 'tag_comments_simple_value',
        'comments:comments:content'                 => 'tag_comments_simple_value',
        'comments:comments:ip'                      => 'tag_comments_simple_value',
        'comments:comments:status'                  => 'tag_comments_simple_value',
        'comments:comments:created'                 => 'tag_comments_simple_date',
        'comments:comments:updated'                 => 'tag_comments_simple_date',
        'comments:comments:admin'                   => 'tag_comments_simple_value',
        "comments:count"                            => "tag_count",

        // @TODO Rewrite theese methods
        "comments:comment_save"                     => "tag_comment_save", // Save new comment
        "comments:gravatar"                         => "tag_gravatar", // Display avatar, using gravatar site
        "comments:comments_allowed"                 => "tag_comments_allowed", // Display nested content if comments allowed
        "comments:comments_admin"                   => "tag_comments_admin", // Display admin options & save change
        "comments:message"                          => "tag_message", 
        "comments:success_message"                  => "tag_success_message", // Display success flash message
        "comments:error_message"                    => "tag_error_message", // Display error flash message
        "comments:comments_allowed"                 => "tag_comments_allowed",  // Display error flash message 
        "comments:author_site"                      => 'tag_author_site'
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
    public static function tag_comments(FTL_Binding $tag)
    {
        // Returned string
        $str = '';

        // Model load
        self::load_model('comments_model', '');

        $article = $tag->get('article');

        // Prepare where
        $where['id_article']    = $article['id_article'];

        // @TODO Get user and if user is admin show all comments
        // $user = User()->get_user();

        $where['status']        = 1;

        // Comments array
        $article_comments = self::$ci->comments_model->get_list($where);

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
        $field = $tag->getAttribute('field', 'published');

        // Model load
        self::load_model('comments_model', '');

        $article = $tag->get('article');

        // Count Comments array [pending,published,all]
        $count_article_comments = self::$ci->comments_model->count_article_comments($article['id_article']);

        if ( ! is_null($field) && array_key_exists($field, $count_article_comments))
        {
            // Get the count result
            $count = $count_article_comments[$field];

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
    // @TODO Check under lines!!
    // ------------------------------------------------------------------------

    /*     * *********************************************************************
     * Save the new entry, if "POST" detected
     *
     */

    public static function tag_comment_save(FTL_Binding $tag) {
        // get CodeIgniter instance
        $CI = & get_instance();

        // Comment was posted, saving it
        if ($content = $CI->input->post('content')) {
            // Loads the comments module model
            if (!isset($CI->comment_model))
                $CI->load->model('comments_comment_model', 'comment_model', true);

            // Save comment 
            if ($CI->comment_model->insert_comment($tag->locals->article['id_article']))   
                $CI->locals->showSuccessFlashMessage = true;
            else
                $CI->locals->showErrorFlashMessage = true;
        }


        return;
    }


    /*     * **********************************************************************
     * Display comment's author's gravatar
     *
     * Attributes :
     * default : 	can be "mm" (people shadow), "identicon" (default), 
      "monsterid", "wavatar", "retro"
     * 				or link to a public accessible default image 
     * TODO :
     * - Allow to define the size
     */

    public static function tag_gravatar(FTL_Binding $tag) {
        // Using "identicon" if no other default avatar is specified 
        $default_avatar = isset($tag->attr['default']) ? $tag->attr['default'] : 'identicon';

        $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($tag->locals->comment["email"]))) . "?s=80&d=" . $default_avatar;
        return $grav_url;
    }

    /*     * ***********************************************************************
     * Display toolbar for admin : allow to configure comments for an article
     *
     */

    public static function tag_comments_admin(FTL_Binding $tag) {

        $CI = & get_instance();
        $allowed = Authority::can('access', 'admin');

// Display tag content & apply modifications if needed (only if the user is member of "admins+" group)
        if ($allowed) {

            // Loading comments model if needed
            if (!isset($CI->comment_model))
                $CI->load->model('comments_comment_model', 'comment_model', true);

            // Checking if comments should be enabled/disabled (POST) should be done
            if ($CI->input->post("comments_article_update") == "1") {
                $tag->locals->article['comment_allow'] = $CI->comment_model->update_article($tag->locals->article['id_article']);
                $tag->locals->showFlashMessage = true;
                //$CI->locals->showFlashMessage = true;
                //$CI->locals->showSuccessFlashMessage = true;
            }

            if ($CI->input->post("comment_delete") == "1") {
                $CI->comment_model->delete($CI->input->post("id_article_comment"));
                $tag->locals->showFlashMessage = true;
            }

            return $tag->expand();
        }
    }

    /*     * *************************************************************************
     * Display a flash message to inform admin that action was completed
     *
     */

    public static function tag_message(FTL_Binding $tag) {

        if ($tag->locals->showFlashMessage == true) {
            $class = isset($tag->attr['class']) ? ' class="' . $tag->attr['class'] . '"' : '';
            $id = isset($tag->attr['id']) ? ' id="' . $tag->attr['id'] . '"' : '';
            $tag_open = isset($tag->attr['tag']) ? "<" . $tag->attr['tag'] . $id . $class . ">" : '';
            $tag_close = isset($tag->attr['tag']) ? "</" . $tag->attr['tag'] . ">" : '';

            return $tag_open . $tag->expand() . $tag_close;
        }
    }

    /*     * *************************************************************************
     * Display a flash message to inform user that action was completed
     *
     */

    public static function tag_success_message(FTL_Binding $tag) {
        $CI = & get_instance();

        // Build flash message "success"
        if (isset($CI->locals->showSuccessFlashMessage) && $CI->locals->showSuccessFlashMessage == true) {
            $class = isset($tag->attr['class']) ? ' class="' . $tag->attr['class'] . '"' : '';
            $id = isset($tag->attr['id']) ? ' id="' . $tag->attr['id'] . '"' : '';
            $tag_open = isset($tag->attr['tag']) ? "<" . $tag->attr['tag'] . $id . $class . ">" : '';
            $tag_close = isset($tag->attr['tag']) ? "</" . $tag->attr['tag'] . ">" : '';

            return $tag_open . $tag->expand() . $tag_close;
        }
    }

    /*     * *************************************************************************
     * Display a flash error message to inform user that action wasn't completed
     *
     */

    public static function tag_error_message(FTL_Binding $tag) {
        $CI = & get_instance();

        // Build flash message "success"
        if (isset($CI->locals->showErrorFlashMessage) && $CI->locals->showErrorFlashMessage == true) {
            $class = isset($tag->attr['class']) ? ' class="' . $tag->attr['class'] . '"' : '';
            $id = isset($tag->attr['id']) ? ' id="' . $tag->attr['id'] . '"' : '';
            $tag_open = isset($tag->attr['tag']) ? "<" . $tag->attr['tag'] . $id . $class . ">" : '';
            $tag_close = isset($tag->attr['tag']) ? "</" . $tag->attr['tag'] . ">" : '';

            return $tag_open . $tag->expand() . $tag_close;
        }
    }

    /*     * *************************************************************************
     * Expands the tag (display tag content) if comments are allowed
     *
     */
    public static function tag_comments_allowed(FTL_Binding $tag) {
        $result = $tag->locals->article['comment_allow'] == "1" ? $result = $tag->expand() : $result = "";
        return $result;
    }
}
