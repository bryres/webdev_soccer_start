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

function get_audits($app_cde, $table) {
    $query = "select audit_id, usr_first_name, usr_last_name, date_format(audit_dt, '%b %e, %Y %r') as audit_dt, audit_action, data
              from audit, user
              where audit_usr_id = usr_id
              and app_cde = :app_cde
              and audit.table_name = :table
              and audit_dt > DATE_SUB(CURDATE(), INTERVAL 7 DAY)
              order by audit_id desc";

    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(":app_cde", $app_cde);
        $statement->bindValue(":table", $table);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

function get_audit_table_list($app_cde) {
    $query = "select distinct table_name
              from audit
              where app_cde = :app_cde";

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