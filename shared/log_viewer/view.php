<?php
$head = '<link rel="stylesheet" href="/' . $shared_url_path .'/log_viewer/styles.css' .getVersionString() . '">';
$path = array
(
    array("name" => $app_title, "link" => '/' . $app_url_path),
    array("name" => 'Admin', "link" => '/' . $app_url_path . '/admin'),
    array("name" => 'Log Viewer', "link" => '/' . $app_url_path . '/admin/log_viewer'),
);
generateHeader($head, $path);
?>

<section style="margin:0;padding:1em;">
    <h3 style="display:inline-block;">Log Viewer</h3>
    <table class="striped" style="width:95%;">

        <tr class="tablerow">
            <th>Date/Time </th>
            <th>Lvl. </th>
            <th>Name </th>
            <th>Message </th>

        </tr>

        <?php foreach ($logs as $log) :
            // Get product data
            $logDate = $log['log_dt'];
            $logLvl = $log['log_lvl_cde'];
            $logMsg = $log['log_msg'];
            $logName = $log['name'];

            ?>
            <tr>
                <td class="small_column"><?php echo $logDate; ?></td>
                <td class="small_column"><?php echo $logLvl; ?></td>
                <td class="small_column"><?php echo $logName; ?></td>
                <td class="log_msg"><?php echo $logMsg; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<?php writeFooter(); ?>