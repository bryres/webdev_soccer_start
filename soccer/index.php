<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 12/14/15
 * Time: 1:04 PM
 */

/* These messages are used to customize the login page. */
$pageTitle = 'Soccer League';
$loginInfo = '<h1>Soccer Database</h1>
                <h2>
                    Let\'s practice PHP by building an app.
                </h2>';


/** Include the database credentials and then transfer control to /shared/index,
 * which contains the meat of the login handling code.
 */
require_once("util/main.php");
//include (__DIR__ . "/../shared/index.php");
include (__DIR__ . "/../shared/login/index.php");

?>