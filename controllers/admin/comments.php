<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Comments MODULE ADMIN CONTROLLER
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Comments extends Module_Admin
{
    /**
     * Controller URL
     *
     * @var string (with admin url)
     */
    protected $controller_url;

    /**
     * Controller View Folder
     *
     * @var string
     */
    protected $controller_folder = 'admin/comments/';

    /**
     * Default Model Name
     *
     * @var string
     */
    protected $default_model = 'comments_model';

    /**
     * Constructor
     *
     * @access	public
     * @return	void
     */
    public function construct()
    {
        // Models
        $this->load->model(
            array(
                'article_model',
                'comments_model'
            ), '', TRUE);

        // Set Controller URL
        $this->controller_url = admin_url() . 'module/comments/comments/';
    }

    // ------------------------------------------------------------------------

    /**
     * Index of comment module
     */
    public function index() {

        $this->output($this->controller_folder . 'index');
    }

    // ------------------------------------------------------------------------

    /**
     * Get article comments list
     *
     * @param bool $id_article
     * @param bool $rel
     */
    function article_comments($id_article = FALSE, $rel = FALSE)
    {
        // If we have article id and rel data get comments list
        if($id_article != FALSE && $rel != FALSE)
        {
            // Get article data
            $this->template['article'] = $this->article_model->get_by_id($id_article);

            // Get article lang data
            $this->article_model->feed_lang_template($id_article, $this->template['article']);

            // Set article and page id for go back to article edit : id_article.id_page
            $this->template['rel'] = $rel;

            $this->template['comments'] = self::get_list($id_article);

            // Send data to view file
            $this->output($this->controller_folder . 'comments');
        }
        // Return Error Notification Message
        else
        {
            $this->callback = array(
                'fn' => 'ION.notification',
                'args' => array('error', lang('module_comments_notification_cant_get_article_id'))
            );

            $this->response();
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get comments for requested article
     *
     * @param $id_article
     * @return array
     */
    function get_list($id_article)
    {
        // Get comments for current article
        $article_comments = $this->{$this->default_model}->get_list(array('id_article' => $id_article));

        // Create an empty array for seperate comments
        $comments = array(
            'published' => array(),
            'pending'   => array()
        );

        // Set comments for status published / pending
        foreach($article_comments as $article_comment)
            if($article_comment['status']==1)
                $comments['published'][] = $article_comment;
            else
                $comments['pending'][] = $article_comment;

        // Return comments
        return $comments;
    }

    // ------------------------------------------------------------------------

    function get_form()
    {

    }

    // ------------------------------------------------------------------------

    function edit()
    {

    }

    // ------------------------------------------------------------------------

    function save()
    {


    }

    // ------------------------------------------------------------------------

    function delete()
    {

    }

    // ------------------------------------------------------------------------

    function switch_online()
    {

    }

    // ------------------------------------------------------------------------

    /**
     * Adds "Addons" to core panels
     * When set, this function will be automatically called for each core panel.
     *
     * One addon is a view from the module which will be displayed in a core panel,
     * to add some interaction with the current edited element (page, article)
     *
     *
     * Core Panels which accepts addons :
     *  - article : Article Edition Panel
     *  - page : Page Edition Panel
     *  - media : Media Edition Panel
     *
     * Placeholders :
     * In each "Core Panel", some placeholder are defined :
     *  - 'options_top' : 		Options panel, Top
     *  - 'options_bottom' : 	Options panel, Bottom
     *  - 'main_top' : 			Main Panel, Top
     *  - 'main_bottom' : 		Main Panel, Bottom (Not implemented)
     *  - 'toolbar' : 			Top toolbar (Not implemented)
     *
     * @param	Array			The current edited object (page, article, ...)
     *
     */
    public function _addons($object = array())
    {

        $CI =& get_instance();
//        $uri = $CI->uri->uri_string();

        // Send the article|page to the view
        $data['article'] = $object;

        // Load comments model
        $CI->load->model('comments_model', '', TRUE);

        $data['count'] = $CI->comments_model->count_article_comments($data['article']['id_article']);

        // Options panel Top Addon
        $CI->load_addon_view(
            'comments', // Module folder
            'article',							// Parent panel code
            'options_top',						// Placehoder
            'admin/comments/_addons/article/options', 	// View to display in the placeholder
            $data								// Data send to the view
        );
    }

}