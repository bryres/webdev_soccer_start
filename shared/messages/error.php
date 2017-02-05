<html lang="en">
	<head>
		<title><?php echo $app_title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<!-- <link rel="shortcut icon" href="images/logo.ico"> -->

		<!-- Styles -->
		<link href="/<?php echo $shared_ss_url; ?>" rel="stylesheet">
		<link href="/<?php echo $shared_url_path; ?>/messages/styles.css<?php echo(getVersionString()); ?>" rel="stylesheet">
		<!-- <?php include_analytics(); ?> -->
	</head>
	<body>
		<form action="" method="get">
			<div class="error">
	                <h1><i>oops...</i></h1>
	                <h3><i>
	                	<?php echo $error_message ?>
	                </i></h3>

				<div id="button-div">
					<button style="cursor: pointer" class="submit s" type="submit" name="choice" value="Back" onclick="history.back();">
						Ok
					</button>
				</div>


			</div>
		</form>

		<script type="text/javascript" src="/<?php echo $shared_url_path; ?>/js/jquery.min.js<?php echo(getVersionString()); ?>"></script>
		<script type="text/javascript" src="/<?php echo $shared_url_path; ?>/js/jquery.easing.min.js<?php echo(getVersionString()); ?>"></script>
		<script type="text/javascript" src="/<?php echo $shared_url_path; ?>/js/jquery.plusanchor.min.js<?php echo(getVersionString()); ?>"></script>
		<script type="text/javascript">
		    $('body').plusAnchor({
		        easing: 'easeInOutExpo',
		        speed:  700
		    });

		</script>
	</body>
</html>