<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Comments MODULE ADMIN CONTROLLER
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Comments extends Module_Admin
{
    /**
     * Fields on wich the htmlspecialchars function will not be used before saving
     *
     * @var array
     */
    protected $no_htmlspecialchars = array('content');

    /**
     * Fields on wich no XSS filtering is done
     *
     * @var array
     */
    protected $no_xss_filter = array('content');

    /**
     * Fields which required
     *
     * @var array
     */
    protected $required_fields  = array('author', 'email', 'content');

    /**
     * Data array representing one category
     *
     * @var array
     */
    protected $data = array();

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
     * Default Database Table
     *
     * @var string
     */
    protected $table = 'article_comment';

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
    public function index()
    {

        if(Authority::can('access', 'module/comments/admin'))
        {
            $this->output($this->controller_folder . 'index');
        }
        else
        {
            self::_alert('danger', lang('module_comments_permission_warning'), lang('module_comments_permission_access'));
        }
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
        if(Authority::can('access', 'module/comments/admin'))
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
        else
        {
            self::_alert('danger', lang('module_comments_permission_warning'), lang('module_comments_permission_access'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get comments for requested article
     */
    function get_list()
    {
        if(Authority::can('access', 'module/comments/admin'))
        {
            // Get posted data
            $id_article = $this->input->post('id_article');
            $status     = $this->input->post('status');

            // Prepare where
            $where      = array(
                'id_article' => $id_article,
                'status' => $status
            );

            // Send data to template
            $this->template['status']           = $status;
            $this->template['comment_type']     = (($status == 0) ? 'pending' : 'published');

            $this->template['article_comments'] = $this->{$this->default_model}->get_list($where);

            $this->output($this->controller_folder . 'list');
        }
        else
        {
            self::_alert('danger', lang('module_comments_permission_warning'), lang('module_comments_permission_access'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Create new comment
     */
    public function get_form($id_article)
    {
        if(Authority::can('create', 'module/comments/admin'))
        {
            $this->{$this->default_model}->feed_blank_template($this->template);

            $user = User()->get_user();

            // Send data to view file
            $this->template['id_article']   = $id_article;
            $this->template['site']         = base_url();
            $this->template['author']       = $user['screen_name'];
            $this->template['email']        = $user['email'];
            $this->template['status']       = 1;
            $this->template['ip']           = $this->{$this->default_model}->get_client_ip();

            $this->output($this->controller_folder . 'comment');
        }
        else
        {
            self::_alert('danger', lang('module_comments_permission_warning'), lang('module_comments_permission_create'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Edit comment
     *
     * @param $id_article_comment
     */
    public function edit($id_article_comment)
    {
        if(Authority::can('edit', 'module/comments/admin'))
        {
            $this->{$this->default_model}->feed_template($id_article_comment, $this->template);

            $this->output($this->controller_folder . 'comment');
        }
        else
        {
            self::_alert('danger', lang('module_comments_permission_warning'), lang('module_comments_permission_edit'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * View comment
     *
     * @param $id_article_comment
     */
    public function view($id_article_comment)
    {
        if(Authority::can('view', 'module/comments/admin'))
        {
            $this->{$this->default_model}->feed_template($id_article_comment, $this->template);

            $this->output($this->controller_folder . 'view');
        }
        else
        {
            self::_alert('danger', lang('module_comments_permission_warning'), lang('module_comments_permission_view'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Save / Update Comment
     */
    function save()
    {
        if(Authority::can('save', 'module/comments/admin'))
        {
            if($this->_check_before_save() == TRUE)
            {
                $id_article = $this->input->post('id_article');

                // Clear the cache
                Cache()->clear_cache();

                // Prepare Form Datas
                $this->_prepare_data();

                // Save data
                $this->{$this->default_model}->save($this->data);

                // Send Success Message
                $this->callback = array(
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_list',
                            array(
                                'id_article' => $id_article,
                                'status' => 0
                            ),
                            array(
                                'update' => 'pendingCommentsContainer'
                            )
                        ),
                    ),
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_list',
                            array(
                                'id_article' => $id_article,
                                'status' => 1
                            ),
                            array(
                                'update' => 'publishedCommentsContainer'
                            )
                        ),
                    ),
                    // Send success message
                    array(
                        'fn' => 'ION.notification',
                        'args' => array('success', lang('module_comments_notification_comment_saved'))
                    )
                );

                $this->response();
            }

            else
            {
                $this->error(lang('module_comments_notification_comment_nsaved'));
            }
        }
        else
        {
            $this->callback = array(
                'fn' => 'ION.notification',
                'args' => array('error', lang('module_comments_permission_save'))
            );

            $this->response();
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Delete item
     * @param $id_article_comment
     * @param $id_article
     */
    function delete($id_article_comment, $id_article)
    {
        if(Authority::can('delete', 'module/comments/admin'))
        {
            // Clear the cache
            Cache()->clear_cache();

            if ($this->{$this->default_model}->delete($id_article_comment) > 0)
            {
                // Reload container after change status, because we have tabs need to move item
                $this->callback = array(
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_list',
                            array(
                                'id_article' => $id_article,
                                'status' => 0
                            ),
                            array(
                                'update' => 'pendingCommentsContainer'
                            )
                        ),
                    ),
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_list',
                            array(
                                'id_article' => $id_article,
                                'status' => 1
                            ),
                            array(
                                'update' => 'publishedCommentsContainer'
                            )
                        ),
                    ),
                    // Send success message
                    array(
                        'fn' => 'ION.notification',
                        'args' => array('success', lang('module_comments_notification_comment_deleted'))
                    )
                );

                $this->response();
            }
            else
            {
                // Send error message
                $this->callback = array(
                    'fn' => 'ION.notification',
                    'args' => array('error', lang('module_comments_notification_comment_ndeleted'))
                );

                $this->response();
            }
        }
        else
        {
            $this->callback = array(
                'fn' => 'ION.notification',
                'args' => array('error', lang('module_comments_permission_delete'))
            );

            $this->response();
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Set an item online / offline depending on its current context and status
     *
     * @param $id_article_comment
     * @param $id_article
     */
    public function switch_status($id_article_comment, $id_article)
    {
        if(Authority::can('status', 'module/comments/admin'))
        {
            // Clear the cache
            Cache()->clear_cache();

            // Change item status
            $status = $this->{$this->default_model}->switch_status($id_article_comment);

            if($status == 0 || $status == 1)
            {
                // Reload container after change status, because we have tabs need to move item
                $this->callback = array(
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_list',
                            array(
                                'id_article' => $id_article,
                                'status' => 0
                            ),
                            array(
                                'update' => 'pendingCommentsContainer'
                            )
                        ),
                    ),
                    array(
                        'fn' => 'ION.HTML',
                        'args' => array(
                            $this->controller_url . 'get_list',
                            array(
                                'id_article' => $id_article,
                                'status' => 1
                            ),
                            array(
                                'update' => 'publishedCommentsContainer'
                            )
                        ),
                    ),
                    // Send success message
                    array(
                        'fn' => 'ION.notification',
                        'args' => array('success', lang('module_comments_notification_comment_status_changed'))
                    )
                );

                $this->response();
            }
            else {
                // Send error message
                $this->callback = array(
                    'fn' => 'ION.notification',
                    'args' => array('error', lang('module_comments_notification_comment_status_nchanged'))
                );

                $this->response();
            }
        }
        else
        {
            $this->callback = array(
                'fn' => 'ION.notification',
                'args' => array('error', lang('module_comments_permission_status'))
            );

            $this->response();
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Prepares data before saving
     */
    function _prepare_data()
    {

        // Standard fields
        $fields = $this->db->list_fields($this->table);

        // Set the data to the posted value.
        foreach ($fields as $field)
        {
            if ($this->input->post($field) !== FALSE)
            {
                if ( ! in_array($field, $this->no_htmlspecialchars))
                    $this->data[$field] = htmlspecialchars($this->input->post($field), ENT_QUOTES, 'utf-8');
                else
                    $this->data[$field] = $this->input->post($field);
            }
        }

    }

    // ------------------------------------------------------------------------

    /**
     * Check if required fields done.
     *
     * @returns		Boolean		True if the save can be done, false if not
     *
     */
    function _check_before_save()
    {
        $require_fields = $this->required_fields;

        $return = FALSE;

        foreach ($require_fields as $required_field) {
            if ($this->input->post($required_field) !== FALSE && $this->input->post($required_field) != '')
                $return = TRUE;
            else
                return FALSE;
        }

        return $return;
    }

    // ------------------------------------------------------------------------

    /**
     * Get Alert View
     *
     * @param bool $type types :: success,danger,warning,info
     * @param bool $title
     * @param bool $text
     */
    function _alert($type = FALSE, $title = FALSE, $text = FALSE)
    {
        $this->template['type'] = (($title != FALSE) ? $type : 'danger');
        $this->template['title'] = (($title != FALSE) ? '<h4>' . $title . '</h4>' : '');
        $this->template['text'] = (($text != FALSE) ? '<p>' . $text . '</p>' : '');

        $this->output($this->controller_folder . 'alert');
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
        $moduleConfig = Modules()->get_module_config('Comments');

        $pages_ids = array();

        if($moduleConfig['module_comments_pages'] !== '')
            $pages_ids = explode(',', $moduleConfig['module_comments_pages']);

        $CI =& get_instance();

        if( ! empty($object['id_article']) && ! empty($object['id_page']) && in_array($object['id_page'], $pages_ids) ) {

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
        else
            return;
    }

}