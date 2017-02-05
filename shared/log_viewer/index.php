<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 3/9/16
 * Time: 9:19 AM
 */

require_once (__DIR__ . "/../util/main.php");
require_once (__DIR__ . "/../model/admin_db.php");

verify_admin();

$logs = get_log_messages($app_cde);

include "view.php";


exit();