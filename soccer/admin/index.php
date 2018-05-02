<?php
include('../util/main.php');
verify_admin();

$head =
    '<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css rel="stylesheet">
    <link href="../../shared/ss/main_new.css' . getVersionString() . '" rel="stylesheet">';

$path = array
(
    array("name" => "Soccer Admin", "link" => "/" . $app_url_path)
);

generateHeader($head, $path);

?>

<div class="container">
    <h3 class="center-align">Admin Tools</h3>
    <ul class="collection with-header">

        <a href="coaches" class="collection-item avatar">
            <i class="material-icons circle purple">list</i>
            <h6 class="title">Coaches</h6>
            <p class="small-text">Manage the list of coaches.</p>
        </a>

        <li class="collection-header">
        <h4>Advanced</h4>
        </li>
        <a href="log_viewer" class="collection-item avatar">
            <i class="material-icons circle purple">report_problem</i>
            <h6 class="title">Log Viewer</h6>
            <p class="small-text">View the application log.</p>
        </a>
        <a href="roles" class="collection-item avatar">
            <i class="material-icons circle purple">person_add</i>
            <h6 class="title">Roles</h6>
            <p class="small-text">Set roles for IDA.</p>
        </a>
    </ul>

</div>

<?php
writeFooter();

