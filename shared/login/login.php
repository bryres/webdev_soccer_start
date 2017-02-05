<html lang="en">
	<head>
		<title><?php echo $pageTitle ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<!-- <link rel="shortcut icon" href="images/logo.ico"> -->

		<!-- Styles -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link href="/<?php echo $shared_ss_url; ?>" rel="stylesheet">
		<link href="/<?php echo $shared_url_path; ?>/login/styles.css<?php echo(getVersionString()); ?>" rel="stylesheet">
	</head>
	<body>
		<section class="main login">
			<div class="login-intro">
				<div class="vertical-center">
					<?php echo $loginInfo ?>

	            </div>
			</div>
			<div class="login-header">
				<h1>Login</h1>
			</div>
            <div class="login-main">
            	<div class="vertical-center">
					<form action="." method="post">
						<input type="hidden" name="action" value="login">

						<h3 style="color:red; text-align: center;">
							<?php echo $message ?>
						</h3>

						<input type="text" name="username" placeholder="username">
	                    <input type="password" name="password" placeholder="password">
						<button>Login</button>
	                </form>
            	</div>
            </div>
		</section>
		<script type="text/javascript" src="/<?php echo $app_url_path; ?>/../shared/js/jquery.min.js<?php echo(getVersionString()); ?>"></script>
		<script type="text/javascript" src="/<?php echo $app_url_path; ?>/../shared/js/jquery.easing.min.js<?php echo(getVersionString()); ?>"></script>
		<script type="text/javascript" src="/<?php echo $app_url_path; ?>/../shared/js/jquery.plusanchor.min.js<?php echo(getVersionString()); ?>"></script>
		<script type="text/javascript">
		    $('body').plusAnchor({
		        easing: 'easeInOutExpo',
		        speed:  700
		    });

		</script>
	</body>
</html>