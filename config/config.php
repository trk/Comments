<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
$config['module']['comments'] = array
(
    'module'        => "Comments",
    'name'          => "Comments",
    'description'   => "Comment modules for managing website comments.<br /><b>Authors : </b>Pascal Gay, Victor Efremov, Laurent Brugière, İskender TOTOĞLU",
    'author'        => "Pascal Gay, Victor Efremov, Laurent Brugière, İskender TOTOĞLU",
    'version'       => "0.2a | Release //=> ukyo",
    'uri'           => 'comments',
    'has_admin'     => TRUE,
    'has_frontend'  => FALSE,

    // The default resource : 'access' enought for user roles
);

return $config['module']['comments'];