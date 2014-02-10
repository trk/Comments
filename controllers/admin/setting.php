<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Comments Setting ADMIN CONTROLLER
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Setting extends Module_Admin
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
    protected $controller_folder = 'admin/setting/';

    /**
     * Constructor
     *
     * @access	public
     * @return	void
     */
    public function construct()
    {
        // Set Controller URL
        $this->controller_url = admin_url() . 'module/comments/setting/';
    }

    // ------------------------------------------------------------------------

	/**
	* Admin panel
	* Called from the modules list.
	*
	* @access	public
	* @return	parsed view
	*/
    public function index() {

        $this->output($this->controller_folder . 'index');
    }

    // ------------------------------------------------------------------------

    /**
     * Returns pages used for Comments
     * Used to display pages list.
     *
     * @access	public
     * @return	parsed view
     */
    function get_pages()
    {
        // Page model
        $this->load->model('page_model', '', TRUE);

        // Rss pages ID
        $pages_id = explode(',', config_item('module_comments_pages'));

        // All pages
        $pages = $this->page_model->get_lang_list(FALSE, Settings::get_lang('default'));

        // Used Rss pages (empty array)
        $rss_pages = array();

        // Get the real used pages
        foreach($pages_id as $id)
        {
            foreach($pages as $page)
            {
                if($id == $page['id_page'])
                {
                    $rss_pages[] = $page;
                }
            }
        }

        // Send Rss pages to template
        $this->template['pages'] = $rss_pages;

        $this->output($this->controller_folder . 'pages');
    }

    // ------------------------------------------------------------------------

    /**
     * Add one page to the Comments Config File
     * Called when the Admin drags a page to the Comments pages list.
     *
     * @access	public
     * @return	mixed
     */
    function add_page()
    {
        // Model used to write config.php
        $this->load->model('config_model', '', TRUE);

        // Already linked Rss Pages ID
        $pages_id = array();

        if(config_item('module_comments_pages') !== '')
            $pages_id = explode(',', config_item('module_comments_pages'));

        $id_page = $this->input->post('id_page');

        if( ! in_array($id_page, $pages_id))
        {
            $pages_id[] = $id_page;

            $pages_id = (count($pages_id) > 1) ? implode(',', $pages_id) : array_shift($pages_id);

            if($this->config_model->change('config.php', 'module_comments_pages', $pages_id, 'Comments') == FALSE)
            {
                // Error message
                $this->error(lang('module_comments_error_writing_config_file'));

                die();
            }
            else
            {
                $this->callback = array(
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_pages',
                            '',
                            array(
                                'update' => 'commentsPagesContainer'
                            )
                        )
                    ),
                    array(
                        'fn' => 'ION.notification',
                        'args' => array(
                            'success',
                            lang('ionize_message_operation_ok')
                        )
                    )
                );

                $this->response();
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Removes one page from the Comments Config File
     * Called when the Admin unlinks a page from the Comments pages list.
     *
     * @access	public
     * @return	mixed
     *
     */
    function remove_page()
    {
        // Model used to write config.php
        $this->load->model('config_model', '', TRUE);

        // Already linked Rss Pages ID
        $pages_id = explode(',', config_item('module_comments_pages'));

        // The page ID to remove
        $id_page = $this->input->post('id_page');

        if(in_array($id_page, $pages_id))
        {
            $new_array = array();

            foreach($pages_id as $id)
            {
                if($id !== $id_page)
                    $new_array[] = $id;
            }

            $pages_id = (count($new_array) > 1) ? implode(',', $new_array) : array_shift($new_array);

            if($pages_id == FALSE) $pages_id = '';

            if($this->config_model->change('config.php', 'module_comments_pages', $pages_id, 'Comments') == FALSE)
            {
                // Error message
                $this->error(lang('module_comments_error_writing_config_file'));

                die();
            }
            else
            {
                $this->callback = array(
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_pages',
                            '',
                            array(
                                'update' => 'commentsPagesContainer'
                            )
                        )
                    ),
                    array(
                        'fn' => 'ION.notification',
                        'args' => array(
                            'success',
                            lang('ionize_message_operation_ok')
                        )
                    )
                );

                $this->response();
            }
        }
    }

}