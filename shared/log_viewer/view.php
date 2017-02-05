<html>
<title>Log Viewer</title>

<link rel="stylesheet" type="text/css" href="../../../shared/ss/main.css<?php echo(getVersionString()); ?>">
<link rel="stylesheet" type="text/css" href="../../../shared/log_viewer/styles.css<?php echo(getVersionString()); ?>">

<section style="margin:0;padding:5em;">
    <h1 style="display:inline-block;">Log Viewer</h1>
    <a style="display:inline-block; padding-left:3em;" href=".."><button class="b">Go Back</button></a>
    <table class="gridtable" style="width:50%;">



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
            <td nowrap><?php echo $logDate; ?></td>
            <td nowrap><?php echo $logLvl; ?></td>
            <td nowrap><?php echo $logName; ?></td>
            <td nowrap><?php echo $logMsg; ?></td>



            <?php endforeach; ?>
    </table>
</section>

</html>
