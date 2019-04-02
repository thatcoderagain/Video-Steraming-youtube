<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<!-- Modal Toggle Button-->
		<button type="button" class="btn btn-default hidden" data-toggle="modal" data-target="#popUp" id="popUpButton">Open Modal</button>

		<!-- Modal -->
		<div id="popUp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header alert">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="model_heading">
							
						</h4>
					</div>
					<div class="modal-body">

						<!-- Post Comment div-->						
						<div class="form-group text-right">

							<h5 class="help-block" id="model_message">

							</h5>

							<!-- Line Break div-->
							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
								<br>
							</div>

							<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Okay</button>

						</div>
						<!-- End of Post Comment div-->

					</div>                    
				</div>
				<!-- End of Modal content-->
			</div>            
		</div>
		<!-- End of Modal -->
</body>
</html>