<!DOCTYPE html>
<html lang="en">
    <script type="text/javascript">
        function deleteCoach(coachID) {
            if (confirm('Are you sure you would like to delete this coach?')) {
                window.parent.parent.location.href = 'index.php?action=delete_coach&coach_id=' + coachID;
            }
        }

    </script>
    <head>
        <title>Admin: Coaches</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <!-- Styles -->
        <link href="../../../shared/ss/main.css<?php echo(getVersionString()); ?>" rel="stylesheet">
        <link href="styles.css<?php echo(getVersionString()); ?>" rel="stylesheet">
    </head>

    <body>

        <header>
            <h1 class="title">Coaches</h1>
        </header>
        <div style="text-align:center;padding-bottom:2vh;">
            <a href="./index.php?action=show_add_coach">
                <button style="cursor: pointer" class="s">Add New</button>
            </a>
            <a href="../index.php">
                <button style="cursor: pointer" class="b">Back</button>
            </a>
        </div>
        <nav class="navbar" style="">
            <div class="cell widecol">First Name</div>
            <div class="cell widecol">Last Name</div>
            <div class="cell widecol">Phone Number</div>
            <div class="cell widecol">Email</div>
            <div class="cell delcol"></div>
        </nav>


        <div class="list-container" style="">

            <?php foreach ($coachList as $coach) {
                $coach_id = $coach['coach_id'];
                $coach_last_name = $coach['coach_last_name'];
                $coach_first_name = $coach['coach_first_name'];
                $coach_phone_nbr = $coach['coach_phone_nbr'];
                $coach_email = $coach['coach_email'];
                ?>
                <div class="row">
                    <div class="wrapper">
                        <div class="clickable" onclick="javascript:location.href='./index.php?coach_id=<?php echo $coach_id ?>&action=show_modify_coach'">
                            <div class="cell widecol"><?php echo $coach_last_name; ?>&nbsp</div>
                            <div class="cell widecol"><?php echo $coach_first_name; ?>&nbsp</div>
                            <div class="cell widecol"><?php echo $coach_phone_nbr; ?>&nbsp</div>
                            <div class="cell widecol"><?php echo $coach_email; ?>&nbsp</div>
                        </div>
                        <div class="cell delcol">
                            <div class="del_icon" onclick="deleteCoach(<?php echo $coach_id; ?>);">d</div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>

        <script type="text/javascript" src="../../admin/js/jquery.min.js<?php echo(getVersionString()); ?>"></script>
        <script type="text/javascript" src="../../admin/js/jquery.easing.min.js<?php echo(getVersionString()); ?>"></script>
        <script type="text/javascript" src="../../admin/js/jquery.plusanchor.min.js<?php echo(getVersionString()); ?>"></script>
        <script type="text/javascript" src="../../admin/js/featherlight.min.js<?php echo(getVersionString()); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('body').plusAnchor({
                    easing: 'easeInOutExpo',
                    speed: 700
                });
            });

            $('#fab-action').click(function () {
                $.featherlight($('<iframe width="1000" height="800" src="' + $(this).attr('trigger') + '"/>'))
            })

        </script>
    </body>
</html>