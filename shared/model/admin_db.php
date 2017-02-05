<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 3/9/16
 * Time: 9:20 AM
 */

function get_log_messages($app_cde) {
    $query = "select log_id, log_lvl_cde, log_msg, log_src, log_pdo_file, log_pdo_line, log_dt, user.usr_id, concat (usr_last_name, ', ' ,usr_first_name) as name
              from log
              left join user on log.usr_id = user.usr_id
              where app_cde = :app_cde
              order by log_id desc
              limit 200";

    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(":app_cde", $app_cde);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}