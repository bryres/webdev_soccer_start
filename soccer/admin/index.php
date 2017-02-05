<?php
include('../util/main.php');

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'list_options';
    }
}
//some change
verify_admin();

switch ($action) {
    case 'list_options':
        break;
    default:
        display_error('Unknown account action: ' . $action);
        exit();
        break;
}
?>

<html>
<head>
    <title>Soccer League</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <!-- Styles -->
    <link href="../../shared/ss/main.css<?php echo(getVersionString()); ?>" rel="stylesheet">
    <link href="../admin/ss/main.css<?php echo(getVersionString()); ?>" rel="stylesheet">
</head>
<body id="admin-tools">
<main>
    <header>
        <h1 class="title"><h2>Soccer League Management System</h2></h1>
        <div id="logout"><h2><a style="cursor: pointer" href="../index.php?action=logout">Log Out</a></h2></div>
    </header>
    <br>
    <div id="wrapper">
        <table>
            <tr>
                <td>
                    <a href="coaches">
                        <div class="feature">
                            <h2>Coaches</h2>
                            <h4>Manage the list of coaches</h4>
                        </div>
                    </a>
                </td>
                <td>
                    <a href="roles">
                        <div class="feature">
                            <h2>Roles</h2>
                            <h4>Assign administrator roles.</h4>
                        </div>
                    </a>
                </td>
                <td>
                    <a href="log_viewer">
                        <div class="feature">
                            <h2>Log Viewer</h2>
                            <h4>View the application log.</h4>
                        </div>
                    </a>
                </td>
            </tr>
        </table>
    </div>

    <!-- should probably be /index.php?action=logout in the final, but that won't work right on localhost since everything's in bca-apps rn -->
</main>
</body>
</html>