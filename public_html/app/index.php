<?php
/*****************************************************************************
* index.php
*
* Author: David Gabriel
*
*****************************************************************************/

//init vars
$CFG = array();

//load -> settings
require_once 'settings.init.php';
require_once 'settings.local.php';

//load -> helper
require_once $CFG['path']['config'].'/helper.php';

//load -> autoload
require_once '../vendor/autoload.php';

$cnp = isset($_GET['cnp']) ? $_GET['cnp'] : '';
//$cnp = '1910217410067';

$obj_cnp_verification = new \Test\Library\CNPVerification($cnp);
$error = $obj_cnp_verification->validateFormat();

if (!$error) {
    $obj_cnp_data = new \Test\Library\CNPData($cnp);
    $error = $obj_cnp_verification->validateData($obj_cnp_data); //additional check for birthdate and county code
}

if ($error) {
    echo 'CNP <strong>'.$cnp.'</strong> is not okay (eg: '.$error.')';
}
else {
    echo 'CNP <strong>'.$cnp.'</strong> is okay';
}

//after me, there shall be no more