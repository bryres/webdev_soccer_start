<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Coach</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <!-- Styles -->
    <link href="../../../shared/ss/main.css<?php echo(getVersionString()); ?>" rel="stylesheet">
    <link href="styles_add_modify.css<?php echo(getVersionString()); ?>" rel="stylesheet">

</head>
<body>
<form action="." method="post">
    <input type="hidden" name="action" value="add_coach">
    <div class="box">
        <div class="wrapper">
            <div class="columns">
                <h1 class="title">Add Coach</h1>

                <input type="hidden" name="action" value="add_coach">

                <div class="row">
                    <label>Last Name</label>
                    <input type="text" name="coach_last_name" autofocus required>
                </div>

                <div class="row">
                    <label>First Name</label>
                    <input type="text" name="coach_first_name" required>
                </div>

                <div class="row">
                    <label>Phone</label>
                    <input type="text" name="coach_phone_nbr">
                </div>

                <div class="row">
                    <label>Email</label>
                    <input type="text" name="coach_email">
                </div>

                <div class="button-div">
                    <button style="cursor: pointer" class="submit s" type="submit" name="choice" value="Add">Submit</button>
                    <button style="cursor: pointer" class="submit b" type="submit" name="choice" value="Back" formnovalidate>Cancel</button>
                </div>
            </div>
        </div>
</form>
</body>
</html>