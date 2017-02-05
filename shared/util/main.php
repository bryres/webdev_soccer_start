<?php


//
// Common imports that should be available on all pages.
// Add them here.
//
require_once(__DIR__ . "/../model/database.php");
require_once(__DIR__ . "/../../shared/model/user_db.php");

$shared_ss_url = $server_web_root . '/shared/ss/main.css';
$shared_url_path = $server_web_root . '/shared';
$version_number = 1;
    
////////////////////////////
// Start Session and security check.
// If the user is not logged in, send them to the login page.
//
session_start();
if (isset($_SESSION['user']))
    $user = $_SESSION['user'];

/* Displays a message to the user.  When the user presses ok, redirects user to $next_page. */
function display_user_message ($message, $next_page) {
    global $shared_url_path;
    global $shared_ss_url;
    global $app_title;
    include __DIR__ . '/../messages/message.php';;
    exit();
}

/* Displays an error to the user.  When the user presses ok, goes to the prior page in history. */
function display_error($error_message) {
    global $shared_url_path;
    global $shared_ss_url;
    global $app_title;
    include __DIR__ . '/../messages/error.php';;
    exit();
}

/* Call this method whenever a query fails.  The method logs everything about the error in the LOG
   table and displays a generic error message to the user.  To add: Create a debug mode that will print
   the error message to the screen. */
function display_db_exception ($pdo_exception) {
    global $debug_mode;
    if (isset($_SESSION['user']))
        $usr_id = $_SESSION['user']->usr_id;
    else
        $usr_id = "";

    $stack = generateCallTrace();
    if (strlen($stack) > 1000)
        $stack = substr($stack,0,1000);

    log_pdo_exception ($pdo_exception, $usr_id, $stack,'');

    if ($debug_mode === true)
        display_error('A database error has occurred.<br><br>' .
            'Message:<br>' . $pdo_exception->getMessage() . '<br><br>' .
            'Stack:<br>' . nl2br($stack) . '<br><br>' .
            'PDO Code:<br>' . $pdo_exception->getCode() . '<br><br>' .
            'PDO File:<br>' . $pdo_exception->getFile() . '<br><br>' .
            'PDO Line:<br>' . $pdo_exception->getLine() . '<br><br>');
    else
        display_error('A database error has occurred.  Please try again.');
    exit();
}

/* Returns the current call stack as a string. */
function generateCallTrace()
{
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
    array_pop($trace); // remove call to this method
    $length = count($trace);
    $result = array();

    for ($i = 0; $i < $length; $i++)
    {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
    }

    return "\t" . implode("\n\t", $result);
}

/* Writes an error message into the LOG table. */
function log_error ($msg)
{
    $query = 'insert into log (log_lvl_cde, log_msg, app_cde)
              VALUES (\'ERR\',:log_msg, :app_cde)';

    global $db;
    global $app_cde;

    try {
        error_log("log_error:" . $msg, 0);

        $statement = $db->prepare($query);
        $statement->bindValue(":log_msg", $msg);
        $statement->bindValue(":app_cde", $app_cde);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
    }
}

/* Writes an exception message into the LOG table. */
function log_exception ($exception, $usr_id, $src, $method)
{
    $query = 'insert into log (log_lvl_cde, log_msg, log_src, log_mthd, usr_id, app_cde)
              VALUES (\'ERR\',:log_msg, :log_src, :log_mthd, :usr_id, :app_cde)';

    global $db;
    global $app_cde;

    try {
        error_log("log_exception:" . $exception->getMessage(), 0);

        $statement = $db->prepare($query);
        $statement->bindValue(":log_msg", $exception->getMessage());
        $statement->bindValue(":log_src", $src);
        $statement->bindValue(":log_mthd", $method);
        $statement->bindValue(":usr_id", $usr_id);
        $statement->bindValue(":app_cde", $app_cde);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
    }
}

/* Writes a pdo exception message into the LOG table. */
function log_pdo_exception ($exception, $usr_id, $src, $method)
{
    $query = 'insert into log (log_lvl_cde, log_msg, log_src, log_mthd,
                usr_id, log_pdo_code, log_pdo_file, log_pdo_line, log_pdo_msg, app_cde)
              VALUES (\'ERR\',:log_msg, :log_src, :log_mthd,
               :usr_id, :log_pdo_code, :log_pdo_file, :log_pdo_line, :log_pdo_msg, :app_cde)';

    global $db;
    global $app_cde;

    try {
        error_log("log_pdo_exception:" . $exception->getMessage(), 0);

        $statement = $db->prepare($query);
        $statement->bindValue(":log_msg", $exception->getMessage());
        $statement->bindValue(":log_src", $src);
        $statement->bindValue(":log_mthd", $method);
        $statement->bindValue(":usr_id", $usr_id);
        $statement->bindValue(":log_pdo_code", $exception->getCode());
        $statement->bindValue(":log_pdo_file", $exception->getFile());
        $statement->bindValue(":log_pdo_line", $exception->getLine());
        $statement->bindValue(":log_pdo_msg", "");
        $statement->bindValue(":app_cde", $app_cde);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
    }
}

/* Verifies that the current user is logged in.  If not, they are redirected to the /index.php page. */
function verify_logged_in()
{
    global $app_url_path;
    global $user;

    if (!isset($user)) {
        header('Location: /' . $app_url_path . '/index.php');
        exit();
    }
}

/* Verifies that the current user is an administrator.  If not, displays an error. */
function verify_admin() {
    global $app_cde;
    global $app_url_path;
    global $user;

    verify_logged_in();

    if ($user->getRole($app_cde) != 'ADM') {
        log_error ("Permission exception in verify_admin.  User id:" . $user->usr_id);
        display_user_message("Permission denied.  You are not an administrator.", '/' . $app_url_path . '/index.php');
        exit();
    }
}

function verify_teacher() {
    global $app_cde;
    global $app_url_path;
    global $user;

    verify_logged_in();

    if ($user->usr_type_cde != 'TCH') {
        log_error ("Permission exception in verify_teacher.  User id:" . $user->usr_id);
        display_user_message("Permission denied.  You are not a teacher.", '/' . $app_url_path . '/index.php');
        exit();
    }
}

function verify_student() {
    global $app_cde;
    global $app_url_path;
    global $user;

    verify_logged_in();

    if ($user->usr_type_cde != 'STD') {
        log_error ("Permission exception in verify_student.  User id:" . $user->usr_id);
        display_user_message("Permission denied.  You are not a student.", '/' . $app_url_path . '/index.php');
        exit();
    }
}

function include_analytics() {
    /* Discontinued analytics tracking.
    include_page_tracking();
    include_user_tracking();*/
}

function include_page_tracking() {
/*    echo (
    "<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-71500783-1', 'auto');
        ga('send', 'pageview');
    </script>"
    );*/
}

function include_user_tracking() {
  /*  if (isset($_SESSION)) {
        $cur_user = $_SESSION['user'];
        if ($cur_user != NULL) {
            echo(
                '<script>
                    ga("create", "UA-71500783-1", "auto", "usr_id", {
                        usr_id: "' . $cur_user->usr_id . '"
                    });

                    ga("create", "UA-71500783-1", "auto", "usr_type_cde", {
                        usr_type_cde: "' . $cur_user->usr_type_cde . '"
                    });
                </script>'
            );
        }
    }*/
}

function getVersionString() {
    global $version_number;
    
    return "?v=" . $version_number;
}


?>