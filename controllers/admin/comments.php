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
     * Constructor
     *
     * @access	public
     * @return	void
     */
    public function construct()
    {
        // Models
//        $this->load->model(
//            array(
//                'article_model',
//                'comments_model'
//            ), '', TRUE);

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
     * Send data to get_list() for getting comments for article, if article we have article id correctly
     */
    function get_comments()
    {
        $id = $this->input->post('id_article');

        $id_article = explode('.', $id);

        if(! empty($id_article[1]))
        {
            // Remove deleted article from DOM
            $this->callback = array(
                array(
                    'fn' => 'ION.HTML',
                    'args' => array(
                        $this->controller_url . 'get_list',
                        array(
                            'id_article' => $id_article[1]
                        ),
                        array(
                            'update' => 'commentsArticleContainer'
                        )
                    ),
                ),
                array(
                    'fn' => 'ION.notification',
                    'args' => array('success', "Article comments listed")
                )
            );

            $this->response();
        }
        else
        {
            $this->callback = array(
                'fn' => 'ION.notification',
                'args' => array('error', "Can't get id_article, may be you tried dragging a page")
            );

            $this->response();
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get comments for requested article
     */
    function get_list()
    {
        $this->template['id_article'] = $this->input->post('id_article');

        $this->output($this->controller_folder . 'comments');
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
        $uri = $CI->uri->uri_string();

        // Send the article|page to the view
        $data['article'] = $object;

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