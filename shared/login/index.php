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


switch($action){
    case 'login':
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $external = strpos($username, "@");
        $external = $external && ($user = User::getUserByEmail($username))!=null;
        $external = $external && ($pwd = $user->pwd)!=null;


        if($external){ //external
            if ($user->failed >= 10){
                $message = "Too many failed attempts.  Please contact Bryan Respass for assistance.";
                include(__DIR__ . '/login.php');
                exit();
            }

            if (!password_verify($password, $pwd)){
                $message = "Username, password combination is not correct.";
                $user->setFailed($user->failed +1);
                include(__DIR__ . '/login.php');
                exit();
            }

            if (is_null($user) or is_null($user->usr_id)) {
                display_error("User configuration error.  Please contact Bryan Respass for assistance.");
            }
            $user->setFailed(0);
        }else{ //internal
            $pos = strpos($username, "@");
            if ($pos !== false) {
                $username = substr($username, 0, $pos);
            }

            if (!bergenAuthLDAP($username, $password)) {
                $message = "Username, password combination is not correct.";
                include(__DIR__ . '/login.php');
                exit();
            }
            $user = User::getUserByBCAId($username);

            if (is_null($user) or is_null($user->usr_id)) {
                display_error("User configuration error.  Please contact Bryan Respass for assistance.");
            }
        }

        if (!isset($_SESSION))
            session_start();

        $_SESSION['user'] = $user;

        /* This method should be defined in the app specific default view.php file. */
        goToLandingPage();
        break;

    case 'send':
        $email = filter_input(INPUT_POST, 'email');

        $user = User::getUserByEmail($email);
        if ($user == null)
            $message = "Email not found";
        else{
            $pwd = $user->pwd;
            if ($pwd !=null) { //external

                require(__DIR__."/../sendgrid-php/sendgrid-php.php");
                $sg = new \SendGrid($SENDGRID_API_KEY);

                $body = "Your new password is ";
                $chrs = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","0","1","2","3","4","5","6","7","8");
                $new_pass = "";
                for ($i=0;$i<8;$i++)
                    $new_pass .= $chrs[random_int(0,26+26+10 -1)];
                $body .= $new_pass;

                $from = new SendGrid\Email(null, "bryres@bergen.org");
                $to = new SendGrid\Email(null, $email);
                $content = new SendGrid\Content("text/html", $body);
                $subject = "Forgot Password Request For " . $user->usr_first_name ." ".$user->usr_last_name;

                $mail = new SendGrid\Mail($from, $subject, $to, $content);
                $response = $sg->client->mail()->send()->post($mail);

                $user->change_password($new_pass);

                $message = "sent or something";
            }else{ //internal
                $message = "Contant IT to change your password";
            }
        }

    //no break intentionl
    case 'forgot':
        if (!isset($message)) $message = "";
        include(__DIR__ . '/forgot.php');
        exit();

        break;
    default:
        $message = "";

        include(__DIR__ . '/login.php');
        exit();
        break;
}

?>