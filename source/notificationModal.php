<?php

	if(!isset($_SESSION['notification']))
	{
		goto END;
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="./css/bootstrap.css">

		<!-- Bootflat theme -->
		<link rel="stylesheet" href="./css/drunken-parrot.css">

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="./css/font-awesome.min.css">

		<!-- Raleway Font CSS -->
		<link rel="stylesheet" href="./css/raleway.min.css">

		<!-- Enternal CSS 'files' -->
		<link rel="stylesheet" href="./css/style.css">

		<!-- Enternal JS 'files' -->
		<script src="./js/notificationModal.js"></script>
		
	</head>

	<body onload="showNotification('notification-button');">

		<button type="button" class="btn btn-info hidden" data-toggle="modal" data-target="#notification" id="notification-button">Open Modal</button>

		<!-- Modal -->
		<div id="notification" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header alert <?php echo ' alert-'.$_SESSION['notification']['type']; ?>">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">
							<strong>
								<?php
									echo $_SESSION['notification']['header'];
								?>
							</strong>
						</h4>
					</div>
					<div class="modal-body">
						<h5 class="help-block">
							<?php
								echo $_SESSION['notification']['message'];
							?>
						</h5>
					</div>                    
				</div>
				<!-- End of Modal content-->
			</div>            
		</div>
		<!-- End of Modal -->

		<!-- *************************************************************************** -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) ********************* -->
		<!-- ********* -><script src="./js/jquery.min.js"></script><!- *************** -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- ********* -><script src="./js/bootstrap.min.js"></script><!- ************ -->
		<!-- Include all compiled plugins for theme --><!-- **************************** -->
		<!-- ********* -><script src="./js/bootflat.min.js"></script><!- ************* -->
		<!-- ********* -><script src="./js/bootstrap-switch.js"></script><!- ********* -->
		<!-- ********* -><script src="./js/checkbox.js"></script><!- ***************** -->
		<!-- ********* -><script src="./js/html5shiv.js"></script><!- **************** -->
		<!-- ********* -><script src="./js/radio.js"></script><!- ******************** -->
		<!-- ********* -><script src="./js/switch.js"></script><!- ******************* -->
		<!-- ********* -><script src="./js/toolbar.js"></script><!- ****************** -->
		<!-- *************************************************************************** -->
		<!-- *************************************************************************** -->
	</body>
</html>

<?php

	unset($_SESSION['notification']);

	END:

?>