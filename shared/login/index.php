<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 12/14/15
 * Time: 1:04 PM
 */

require_once(__DIR__ . "/../../shared/model/database.php");
require_once(__DIR__ . "/../../shared/model/user_db.php");

$action = strtolower(filter_input(INPUT_POST, 'action'));

if (($action == NULL) || ($action != 'login' )){

    $message = "";

    include(__DIR__ . '/login.php');
    exit();
}
else {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    $pos = strpos($username, "@");
    if ($pos !== false) {
        $username = substr($username,0,$pos);
    }

    if (!bergenAuthLDAP($username, $password)) {
        $message = "Username, password combination is not correct.";
        include(__DIR__ . '/login.php');
        exit();
    }
    $user = User::getUserByBCAId($username);

    if (!isset($_SESSION))
        session_start();

    $_SESSION['user'] = $user;

    /* This method should be defined in the app specific default index.php file. */
    goToLandingPage();
}

?>