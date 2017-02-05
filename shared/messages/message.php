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
		<form action="<?php echo $next_page ?>" method="get">
			<div class="error">
	                <h1><i>oops...</i></h1>
	                <h2><i>
	                	<?php echo $message ?>
	                </i></h2>
					<div id="button-div">
						<button style="cursor: pointer" class="submit s" type="submit" name="choice" value="Back">Ok</button>
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