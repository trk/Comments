<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Comments model
 *
 * The model that handles actions
 *
 * @author	@author	İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Comments_model extends Base_model
{
    public $comment_table = 			'article_comment';

    /**
     * Model Constructor
     *
     * @access	public
     */
    public function __construct()
    {
        parent::__construct();

        $this->set_pk_name('id_article_comment');
        $this->set_table($this->comment_table);
    }

    /**
     * Return count result
     *
     * @param bool $id_article
     * @return array
     */
    function count_article_comments($id_article = FALSE)
    {
        $count = array();

        $count['all']       = parent::count(array('id_article' => $id_article));
        $count['pending']   = parent::count(array('id_article' => $id_article, 'status' => 0));
        $count['published'] = parent::count(array('id_article' => $id_article, 'status' => 1));

        return $count;
    }

    /**
     * Save the comment
     *
     * @param 	array	Standard data table
     *
     * @return	int		Comment saved ID
     *
     */
    public function save($data)
    {
        // New comment : Created field
        if( ! $data['id_article_comment'] OR $data['id_article_comment'] == '')
            $data['created'] = $data['updated'] = date('Y-m-d H:i:s');
        // Existing comment : Update date
        else
            $data['updated'] = date('Y-m-d H:i:s');

        // Dates
        // $data = $this->_set_dates($data);

        // Article saving
        return parent::save($data);
    }

    /**
     * If user connected get user informations
     * => author
     * => email
     *
     * @return array|bool
     */
    function _get_user()
    {
        if(User()->logged_in())
        {
            $connected_user = User()->get_user();

            $user = array(
                'author' => '',
                'email' => $connected_user['email']
            );

            if($connected_user['firstname'] != '' || $connected_user['lastname'] != '')
                $user['author'] = $connected_user['firstname'] . ' ' . $connected_user['lastname'];
            if($connected_user['screen_name'] != '' && ($connected_user['firstname'] == '' || $connected_user['lastname'] == ''))
                $user['author'] = $connected_user['screen_name'];
            if($connected_user['screen_name'] == '' && ($connected_user['firstname'] == '' || $connected_user['lastname'] == ''))
                $user['author'] = $connected_user['username'];

            return $user;
        }

        return FALSE;
    }

    /**
     * Set an item online / offline depending on its current status
     *
     * @param	int			item ID
     *
     * @return 	boolean		New status
     *
     */
    public function switch_status($id)
    {
        // Current status
        $status = $this->get_row($id)->status;

        // New status
        ($status == 1) ? $status = 0 : $status = 1;

        // Save
        $this->{$this->db_group}->where($this->pk_name, $id);
        $this->{$this->db_group}->set('status', $status);
        $this->{$this->db_group}->update($this->table);

        return $status;
    }

    /**
     * Set the correct dates to one comment and return it
     *
     * @param array		Article array
     *
     * @return array
     *
     */
    protected function _set_dates($data)
    {
        $data['created'] = (isset($data['created']) && $data['created']) ? getMysqlDatetime($data['created'], Settings::get('date_format')) : '0000-00-00';
        $data['updated'] = (isset($data['updated']) && $data['updated']) ? getMysqlDatetime($data['updated'], Settings::get('date_format')) : '0000-00-00';

        return $data;
    }

    /**
     * Get Client Ip Address
     *
     * @return mixed
     */
    function get_client_ip() {

        $ip = $_SERVER['REMOTE_ADDR'];

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }

    /**
     * Check article comment is expired or not
     *
     * FALSE    : Expired
     * TRUE     : Not expire yet
     *
     * @param $article
     * @return bool
     */
    function _check_expire($article)
    {
        $return = FALSE;

        $now    = date("YmdHis");
        $expire = $article['comment_expire'];
        if($expire != '')
        {
            $expire = str_replace('-', '', $expire);
            $expire = str_replace(' ', '', $expire);
            $expire = str_replace(':', '', $expire);
        }

        if($expire == '' || $expire == '00000000000000' || $now < $expire)
            $return = TRUE;
        if($expire != '' && $expire != '00000000000000' && $now > $expire)
            $return = FALSE;

        return $return;
    }
}

/* End of file comments_model.php */
/* Location: /modules/Comments/models/comments_model.php */