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

        $user = USER()->get_user();

        if(empty($user) && ($user['role_code'] != 'role_code' || $user['role_code'] != 'role_code'))
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
}
