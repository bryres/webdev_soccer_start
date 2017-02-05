<?php

require_once('../../util/main.php');
require_once('../../model/coach_db.php');

function loadCoachListPage() {
    global $coachList;

    $coachList = get_coach_list();
    include 'coach_list.php';
    exit();
}

verify_admin();

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'list';
    }
}

switch ($action) {
    case 'list':
        loadCoachListPage();
        break;

    case 'show_add_coach':
        $coach_name = '';
        include 'coach_add.php';
        exit();
        break;

    case 'add_coach':
        $choice = filter_input(INPUT_POST, 'choice');
        $coach_last_name = filter_input(INPUT_POST, 'coach_last_name');
        $coach_first_name = filter_input(INPUT_POST, 'coach_first_name');
        $coach_phone_nbr = filter_input(INPUT_POST, 'coach_phone_nbr');
        $coach_email = filter_input(INPUT_POST, 'coach_email');

        if ($choice == 'Add') {
            add_coach($coach_last_name, $coach_first_name, $coach_phone_nbr, $coach_email);
        }
        loadCoachListPage();
        break;

    case 'show_modify_coach';
        $coach_id = filter_input(INPUT_GET, 'coach_id');
        $coach = get_coach($coach_id);
        $coach_last_name = $coach['coach_last_name'];
        $coach_first_name = $coach['coach_first_name'];
        $coach_phone_nbr = $coach['coach_phone_nbr'];
        $coach_email = $coach['coach_email'];

        include 'coach_modify.php';
        exit();
        break;

    case 'modify_coach':
        $choice = filter_input(INPUT_POST, 'choice');
        $coach_last_name = filter_input(INPUT_POST, 'coach_last_name');
        $coach_first_name = filter_input(INPUT_POST, 'coach_first_name');
        $coach_phone_nbr = filter_input(INPUT_POST, 'coach_phone_nbr');
        $coach_email = filter_input(INPUT_POST, 'coach_email');
        $coach_id = filter_input(INPUT_POST, 'coach_id');

        if(filter_input(INPUT_POST, 'choice') == "Modify") {
            modify_coach($coach_id, $coach_last_name, $coach_first_name, $coach_phone_nbr, $coach_email);
        }

        loadCoachListPage();
        break;

    case 'delete_coach':
        $coach_id = filter_input(INPUT_GET, 'coach_id');
        delete_coach($coach_id);

        loadCoachListPage();
        break;

    default:
        display_error('Unknown coach action: ' . $action);
        break;
}
?>