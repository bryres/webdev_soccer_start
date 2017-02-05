<?php

$app_cde = 'SCR';
$app_title = 'Soccer Registration';

// Provides environment specific configuration information.
include(__DIR__ . "/../../../soccer_config.php");

$app_url_path = $server_web_root . '/soccer';

function goToLandingPage()
{
    global $server_web_root;

    header("Location: /" . $server_web_root . "/soccer/admin/");
}

/* These includes depend on the variables above, therefore they should be at the end of the file. */
require_once(__DIR__ . "/../../shared/util/main.php");

?>