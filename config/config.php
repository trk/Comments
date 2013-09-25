<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
$config['module']['comments'] = array
(
    'module'        => "Comments",
    'name'          => "Comments",
    'description'   => "Comments Module help you to manage comments for articles.<br/><b>Author : </b>İskender TOTOĞLU<br/><b>Company : </b>ALTI VE BIR IT.<br/><b>Website : </b>http://www.altivebir.com.tr",
    'author'        => "İskender TOTOĞLU | ALTI VE BIR IT.",
    'version'       => "0.9",
    'uri'           => 'comments',
    'has_admin'     => TRUE,
    'has_frontend'  => FALSE,

    // The default resource : 'access' enought for user roles
);

return $config['module']['comments'];