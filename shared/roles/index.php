<?php

require_once(__DIR__ . '/../model/admin_roles_db.php');

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'list_roles';
    }
}

verify_admin();

switch ($action) {
    case 'list_roles':
        $assigned_roles = get_assigned_roles();
        $users = get_users();
        $roles = get_roles();
        $teacherList = get_teacher_list();
        include(__DIR__ . "/view.php");
        break;
    case 'modify_admin':
        $choice = filter_input(INPUT_POST, 'choice');
        if($choice == "Back"){
            header("Location: ..");
        }
        if($choice == "Add Admin"){
            $usr_id = filter_input(INPUT_POST, 'user_drop');
            $usr_role_cde = filter_input(INPUT_POST, 'role_drop');
            add_admin($usr_id, $app_cde, $usr_role_cde);
        }
        $assigned_roles = get_assigned_roles();
        $users = get_users();
        $roles = get_roles();
        include(__DIR__ . "/view.php");
        break;
    case 'delete_admin':
        $usr_id = filter_input(INPUT_GET, 'usrID');
        $usr_role_cde = filter_input(INPUT_GET, 'roleID');
        delete_admin($usr_id, $usr_role_cde);

        $assigned_roles = get_assigned_roles();
        $users = get_users();
        $roles = get_roles();
        include(__DIR__ . "/view.php");
        break;
    default:
        display_error('Unknown account action: ' . $action);
        exit();
        break;
}
?>
