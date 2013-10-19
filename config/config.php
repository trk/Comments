<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
$config['module']['comments'] = array
(
    'module'        => "Comments",
    'name'          => "Comments",
    'description'   => "Comments Module help you to manage comments for articles.<br/><b>Version : </b>0.9.1<br/><b>Author : </b>İskender TOTOĞLU<br/><b>Company : </b>ALTI VE BIR IT.<br/><b>Website : </b>http://www.altivebir.com.tr",
    'author'        => "İskender TOTOĞLU | ALTI VE BIR IT.",
    'version'       => "0.9.1",
    'uri'           => 'comments',
    'has_admin'     => TRUE,
    'has_frontend'  => TRUE,
    'resources'     => array(
        'admin'     => array(
            'title' => 'Admin Panel / Yönetim Paneli',
            'actions' => 'create,save,edit,delete,status,view'
        ),
//        'admin/menu' => array(
//            'title'     => 'Menu Items / Menü Öğeleri',
//            'actions'   => 'create,save,edit,delete,status'
//        ),
        'frontend'  => array
        (
            'title'     => 'Client Side / Kullanıcı Tarafı',
            'actions'   => 'view,manage,create,delete,status'
        )
    )
);

return $config['module']['comments'];