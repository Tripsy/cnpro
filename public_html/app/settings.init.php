<?php
/*****************************************************************************
 * settings.init.php
 *
 * Author: David Gabriel
 *
 *****************************************************************************/

//site
$CFG['site']['protocol']  = 'http';
$CFG['site']['charset']   = 'utf-8';
$CFG['site']['name']      = 'TEST'; //site name
$CFG['site']['email']     = 'no-reply@local.test'; //site email - used to send emails
$CFG['site']['domain']    = 'local.test'; //domain name of the site
$CFG['site']['folder']    = ''; //folder of the site

//folder
$CFG['folder']['root']   = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $CFG['site']['folder'];
$CFG['folder']['config'] = '/config'; //config directory

//paths
$CFG['path']['config'] = $CFG['folder']['root'].$CFG['folder']['config'];

//links
$CFG['link']['site'] = $CFG['site']['protocol'].'://'.$CFG['site']['domain'].$CFG['site']['folder']; //site link
?>