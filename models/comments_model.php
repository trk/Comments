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
}

/* End of file comments_model.php */
/* Location: /modules/Comments/models/comments_model.php */