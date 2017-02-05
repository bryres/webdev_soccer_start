<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 12/14/15
 * Time: 1:04 PM
 */

require_once(__DIR__ . "/../../shared/model/user_db.php");



if ($debugging_login_active !== true) {
    header("Location: ..");
}

$action = strtolower(filter_input(INPUT_POST, 'action'));

if ($action == NULL) {
    $action = 'show_users';
}

switch ($action) {
    case 'show_users':
        $user_list = get_user_list_test_page();

        include('login.php');
        break;

    case 'login':
        /**
         * The following session variables are set:
         * usr_id
         * usr_role_cde
         * user_type_cde
         */
        $choice = filter_input(INPUT_POST, 'choice');
        if($choice == "Login ADM"){
            $user_from_post = filter_input(INPUT_POST, 'usr_id_adm');
        } else if($choice == "Login TCH") {
            $user_from_post = filter_input(INPUT_POST, 'usr_id_tch');
        } else {
            $user_from_post = filter_input(INPUT_POST, 'usr_id_std');
        }
        $user = User::getUserByUsrId($user_from_post);
        $_SESSION['user'] = $user;

        goToLandingPage();

        break;
}

?>