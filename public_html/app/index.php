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

$cnp_check = new \Tripsy\Library\CNP\Verification($cnp);
$error = $cnp_check->validateFormat();

if (!$error) {
    $cnp_data = new \Tripsy\Library\CNP\Data($cnp);
    $error = $cnp_check->validateData($cnp_data); //additional check for birthdate and county code
}

if ($error) {
    echo 'CNP <strong>'.$cnp.'</strong> is not okay (eg: '.$error.')';
}
else {
    echo 'CNP <strong>'.$cnp.'</strong> is okay';
}

//after me, there shall be no more