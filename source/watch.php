<?php

	require_once './init.watch.inc.php';
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Play</title>

		<!-- siteicon -->
		<link rel="shortcut icon" href="./images/siteicon.ico"/>
		<link rel="bookmark" href="./images/siteicon.ico"/>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="./css/bootstrap.css">

		<!-- Bootstrap theme -->
		<link rel="stylesheet" href="./css/drunken-parrot.css">

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="./css/font-awesome.min.css">

		<!-- Raleway Font CSS -->
		<link rel="stylesheet" href="./css/raleway.min.css">

		<!-- Enternal CSS 'files' -->
		<link rel="stylesheet" href="./css/style.css">
		
		<!-- Enternal JS -->
		<script src="./js/watch.js"></script>
		<script src="./js/voteAjax.js"></script>
		<script src="./js/subscribeAjax.js"></script>
		<script src="./js/playlistAjax.js"></script>
		<script src="./js/createPlaylistAjax.js"></script>
		<script src="./js/postCommentAjax.js"></script>
		<script src="./js/deleteCommentAjax.js"></script>
		<script src="./js/replyCommentAjax.js"></script>
		<script src="./js/editCommentAjax.js"></script>
		
	</head>
	<body>
	
		<div class="container" id="main">
		
			<!-- Navigation Bar-->
			<div class="container">
				<?php
					require_once './navbar.php';
					require_once './notificationModal.php';
					require_once './model.inc.php';
				?>
			</div>
			<!-- End of Navigation Bar-->
			
			<!-- Player Container div-->
			<div class="container">
			
				<!-- Video Container div-->
				<div class="col-xs-12 | col-sm-12 |col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1  centered"  id="form-box">
					
					<div class="row">
						
						<!-- Video player div-->
						<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" 
							src="<?php
								echo './player.php?video='.htmlentities($url);
							?>
							" frameborder="0" scrolling="no" allowfullscreen></iframe>
						</div>
						<!-- END OF Video player div-->
						
						<!-- Video Title div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<h4>
								<p class="help-block">
									<?php
										echo htmlentities($title);
									?>
								</p>
							</h4>
						</div>                      
						
						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<hr>
						</div>

						<!-- Hidden Elements -->
						<input type="hidden" name="channel_id" id="channel_id"
						value="<?php
									echo htmlentities($channel_id);
								?>">

						<input type="hidden" name="url" id="url"
						value="<?php
									echo htmlentities($url);
								?>">
						<!-- End of Hidden Elements -->
						
						<!-- Channel div-->
						<div class="col-xs-12 | col-sm-8 | col-md-8 | col-lg-8">
						
							<div class="row">
							
								<!-- Channel Image div-->
								<div class="col-xs-4 | col-sm-3 | col-md-2 | col-lg-3">
									<!-- Channel Link -->
									<a 
										href="<?php
													echo htmlentities('./channel.php?slug='.$slug);
												?>">
										<img src=
										"<?php
											echo htmlentities($channelPath.$channel_image_filename);
										?>" class="img-thumbnail channel_image">
									</a>                                    
								</div>
								
								<!-- Channel Detail div-->
								<div class="col-xs-8 | col-sm-8 | col-md-8 | col-lg-8">
								
									<div class="row">
									
										<!-- Channel Name div-->
										<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
											<h6>
												<a 
												href="<?php
															echo htmlentities('./channel.php?slug='.$slug);
													?>">
													<p class="help-block">
														<?php
															echo htmlentities($channel_name);
														?>
													</p>
												</a>
											</h6>
										</div>
										
										<!-- Channel Subscribe button div-->
										<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
											<div class="input-group input-group-sm form-group-sm" id="subscriptionButtonDiv">
												<span class="input-group-btn">
													<button type="button" name="subscribe_button" id="subscribe_button"
														<?php
															if(is_logged_in())
															{
																if($channel_id == channel_id())
																{
																	echo ' class="btn btn-primary" disabled ';
																}
																else if($is_subscribed == 1)
																{
																	echo ' class="btn btn-default"';
																}
																else
																{
																	echo ' class="btn btn-primary"';
																}
															} else {
																echo ' class="btn btn-primary" disabled ';
															}
														?>
														onclick="subscribeUnsubscribe()">
														<i class="fa fa-video-camera" aria-hidden="true"></i>
														<?php
															if(isset($is_subscribed))
															{
																if($is_subscribed == 1)
																{
																	echo ' Unsubscribe';
																}
																else {
																	echo ' Subscribe';
																}
															} else {
																echo ' Subscribe';
															}
														?>
													</button>
												</span>
												<input type="text" class="btn form-control text-center" style="font-size: 10px; width:55px" placeholder="0" 
												value="<?php
															echo htmlentities($subscribers);
														?>"
												 name="subscriber_number" id="subscriber_number" readonly>
											</div>
										</div>
										<!-- End of Channel Subscribe button div-->
									
									</div>
									
								</div>
								
							</div>
							
						</div>
						
						<!-- Video Response div-->
						<div class="col-xs-12 | col-sm-4 | col-md-4 | col-lg-4">
							
							<!-- Line Break div-->
							<div class="col-md-12 visible-xs">
								<hr>
							</div>
							
							<!-- Views div-->
							<div class="col-xs-5 | col-sm-12 | col-md-12 | col-lg-12 text-right">
								<h4 class="help-block">
									<?php 
										echo htmlentities($views).' ';
									?>
									<small>views</small>
								</h4>
							</div>

<?php if($votes == 'on')
		{
?>
							<!-- Votes div-->
							<div class="col-xs-7 | col-sm-12 | col-md-12 | col-lg-12">
								<div class="row">
									<div class="col-xs-6 col-xs-offset-0 | col-sm-6 col-sm-offset-0 | col-md-5 col-md-offset-2 | col-lg-5 col-lg-offset-2text-right">
										<!-- Trigger Like-->
										<h5 class="text-nowrap text-left">
											<button type="button" class="btn btn-link"
												<?php
													if(is_logged_in())
													{
														if($is_liked == 1)
															echo 'style="color:#02baf2;"';
														else 
															echo 'style="color:#93a4aa;"';
													} else {
														echo 'style="color:#93a4aa;" disabled';
													}
												?> 
												name="like_button" id="like_button" onclick="likeDislike(this.id)">
												<span class="glyphicon glyphicon-thumbs-up"></span>
											</button>
											<small name="likes" id="likes">
												<?php 
													echo htmlentities($likes);
												?>
											</small>
										</h5>
									</div>
									<div class="col-xs-6 | col-sm-6 | col-md-5 | col-lg-5 text-right">
										<!-- Trigger Dislike-->
										<h5 class="text-nowrap text-left">
											<button type="button" class="btn btn-link"
												<?php
													if(is_logged_in())
													{
														if($is_disliked == 1)
															echo 'style="color:#02baf2;"';
														else 
															echo 'style="color:#93a4aa;"';
													} else {
														echo 'style="color:#93a4aa;" disabled';
													}
												?> 
												name="dislike_button" id="dislike_button" onclick="likeDislike(this.id)">
												<span class="glyphicon glyphicon-thumbs-down"></span>
											</button>
											<small name="dislikes" id="dislikes">
												<?php 
													echo htmlentities($dislikes);
												?>
											</small>
										</h5>
									</div>
								</div>
							</div>

<?php
	}
?>
						</div>
						
						<!-- Line Break div-->
						<div class="col-xs-12 col-md-12">
							<hr>
						</div>
						
						<!-- Option div-->
						<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">
							
							<!-- Add to Playlist Dropdown menu -->
							<div class="col-xs-6 | col-sm-3 | col-md-3 | col-lg-3 dropdown 
								<?php
									if(!is_logged_in())
									{
										echo 'hidden';
									}
								?>">
							
								<!-- Dropdown Button -->
								<a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
									<span class="fa fa-plus-circle" aria-hidden="true">&nbsp;Add-to</span>
								</a>
								
								<!-- Dropdown menu -->
								<div class="dropdown-menu" id="playlist_dropdown_item">
									<li>
										<div class="btn-group-vertical" id="new_created_playlist">                                            
											<div class="input-group" id="playlist_maker">
												<input type="text" class="form-control" placeholder="Create New" name="playlist_name" id="playlist_name">
												<span class="input-group-btn">
													<button class="btn btn-default" type="button" name="create_button" id="create_button" onclick="createPlaylist(this.id)">
														<i class="fa fa-list-ul" aria-hidden="true"></i>
													</button>
												</span>
											</div>

											<?php
												foreach ($playlistNameArray as $key => $value) {

													echo '<button type="button" class="btn ';

													if(in_array($value, $activePlaylistArray))
													{
														echo 'btn-primary" onclick="playlist(this.id)" id="' . htmlentities($value).'">' . htmlentities($value).'</button>';
													}
													else
													{
														echo 'btn-default" onclick="playlist(this.id)" id="' . htmlentities($value).'">' . htmlentities($value).'</button>';
													}
												}
											?>

										</div>
									</li>
								</div>
								<!-- End of Dropdown menu -->
								
							</div>

							<div class="col-xs-6 | col-sm-3 | col-md-3 | col-lg-3 dropdown 
								<?php
									if(!is_logged_in())
									{
										echo 'hidden';
									}
								?>">

							    <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
									<span class="fa fa-download" aria-hidden="true">&nbsp;Download</span>
								</a>
								<div class="dropdown-menu" id="download_dropdown_item">
									<li>
										<div class="btn-group-vertical">
							    			<a href="./downloader.inc.php?type=video&url=<?php echo htmlentities($url);?>" target="blank" type="button" class="btn btn-default">Download Video</a>
							        		<a href="./downloader.inc.php?type=audio&url=<?php echo htmlentities($url);?>" target="blank" type="button" class="btn btn-default <?php if($audio_filename == NULL) echo 'hidden'; ?>">Download Audio</a>
							        		<a href="./advanceDownload.php?url=<?php echo htmlentities($url);?>" target="blank" type="button" class="btn btn-default">Advance Option</a>
							            </div>
							        </li>
							    </div>
							</div>
							
							<!-- Share button -->
							<div class="col-xs-6 | col-sm-3 | col-md-2 | col-lg-2">
								<a class="btn btn-link">
									<span class="fa fa-share-alt" aria-hidden="true" onClick="toggleVisibility('shareAlert');">&nbsp;Share</span>
								</a>
							</div>
							
							<!-- Embed button -->
							<div class="col-xs-6 | col-sm-3 | col-md-2 | col-lg-2">
								<a class="btn btn-link">
									<span class="fa fa-link" aria-hidden="true" onClick="toggleVisibility('embedAlert');">&nbsp;Embed</span>
								</a>
							</div>
							
							<!-- Alert box for share links -->
							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 hidden" id="shareAlert">
								<div class="alert alert-info alert-dismissible" role="alert">
									<button type="button" class="close" onClick="toggleVisibility('shareAlert');"><span aria-hidden="true">&times;</span></button>
									<strong>Share Link:&nbsp;</strong>
									<input type="text" class="form-control help-block" 
									value="<?php
										echo $domain.'watch.php?video='.htmlentities($url);
									?>" readonly>
								</div>
							</div>
							
							<!-- Alert box for Embed links -->
							<div class="col-xs-12 col-sm-12 col-md-12 | col-lg-12 hidden" id="embedAlert">
								<div class="alert alert-info alert-dismissible" role="alert">
									<button type="button" class="close" onClick="toggleVisibility('embedAlert');"><span aria-hidden="true">&times;</span></button>
									<strong>Embed Code:&nbsp;</strong>
									<input type="text" class="form-control help-block" 
									value="<?php
										echo htmlentities("<div class='embed-responsive embed-responsive-16by9'><iframe style='min-width: 360px;min-height: 210px;' class='embed-responsive-item' src='".$domain."player.php?video=$url' frameborder='0' scrolling='no' allowfullscreen></iframe></div>");
									?>" readonly>
								</div>
							</div>
							
						</div>
						<!-- End of Option div-->                       
						
					</div>
				</div>
				<!-- End of Video Container div-->

				<!-- Line Break div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
					<br>
				</div>          
		
				<!-- Description div-->
				<div class="col-xs-12 | col-sm-12 |col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1  centered"  id="form-box">
				
					<!-- Line Break div-->
					<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
						<br>
					</div>
					
					<!-- Description Toggle Heading div-->
					<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">

						<a class="btn btn-link" data-toggle="collapse" data-target="#description" aria-expanded="false" aria-controls="description">
							<h5><strong>Description <span class="caret"></span></strong></h5>
						</a>
						<!-- Published Date div-->
						<p class="help-block">
							<?php
								echo htmlentities('Published on '.date('jS M Y . g:ia', strtotime($published)));
							?>
						</p>
						
					</div>
					
					<!-- Description Content -->
					<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 | text-left collapse"  id="description">

						<div class="card card-block">                                                       
							<!-- Description content div-->
							<p class="help-block small">
								<?php
									echo htmlentities($description);
								?>
							</p>
						</div>

					</div>

					<!-- Line Break div-->
					<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
						<br>
					</div>
					
				</div>
				<!-- End of Description div-->

				<!-- Line Break div-->
				<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
					<br>
				</div>

<?php
	if($comments == 'on')
	{
?>
					
				<!-- Comments div-->
				<div class="col-xs-12 | col-sm-12 |col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1  centered"  id="form-box">

					<!-- Line Break div-->
					<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
						<br>
					</div>
					
					<!-- Comments Toggle Heading div-->
					<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1">

						<a class="btn btn-link" data-toggle="collapse" data-target="#comments" aria-expanded="false" aria-controls="comments">
							<h5><strong>Comments <span class="caret"></span></strong></h5>
						</a>
						
					</div>

					<!-- Break Line div-->
					<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
						<hr>
					</div>

					<!-- Line Break div-->
					<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12 <?php if(!is_logged_in()) echo 'hidden'; ?>">
						<br>
					</div>

					<!-- Post Comment div-->
					<div class="col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 <?php if(!is_logged_in()) echo 'hidden'; ?>">
						<form>
							<div class="form-group text-right">

								<textarea class="form-control" placeholder="Post a comment . . . " rows="3" id="newComment"></textarea>

								<!-- Line Break div-->
								<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
									<br>
								</div>

								<button type="button" onclick="postComment()" class="btn btn-primary btn-sm" id="post_button">&nbsp;&nbsp;Post&nbsp;&nbsp;</button>

								<button type="reset" class="btn btn-default btn-sm" id="reset_button">Cancel</button>

							</div>
						</form>
					</div>
					<!-- End of Post Comment div-->

					<!-- Line Break div-->
					<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12  <?php if(!is_logged_in()) echo 'hidden'; ?>">
						<br>
					</div>

					<!-- user Comments div-->
					<div class="media col-xs-12 col-xs-offset-0 | col-sm-10 col-sm-offset-1 | col-md-10 col-md-offset-1 | col-lg-10 col-lg-offset-1 collapse" id="comments">

<?php

	# ===> fetching comments
	# QUERY
	$query = "SELECT `id`, `video_id`, `user_id`, `message`, `posted_at` FROM `comment` WHERE `comment`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' ORDER BY `id` DESC";

	$result = mysqli_query($dbconnection, $query);
    $number_of_comments = mysqli_num_rows($result);

    if($number_of_comments > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{

	    	$comment_id = $row['id'];
	    	$user_id = $row['user_id'];
	    	$message = $row['message'];
	    	$posted_at = $row['posted_at'];

			
			# QUERY
			$query = "SELECT `id`, `name`, `image_filename` FROM `users` WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

			$user_result = mysqli_query($dbconnection, $query);

			$row = mysqli_fetch_assoc($user_result);

			$user_id = $row['id'];
			$name = $row['name'];
	    	$image_filename = $row['image_filename'];
	    	$image_filename = $image_filename != NULL ? $image_filename : $defaultProfile;


	    	# QUERY
	    	$query = "SELECT `name`, `slug` FROM `channel` WHERE `channel`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

			$channel_result = mysqli_query($dbconnection, $query);

			$row = mysqli_fetch_assoc($channel_result);

			$channel_name = $row['name'];
	    	$slug = $row['slug'];

?>

						<!-- Commenter Pic div-->
						<div class="media-left">
							<a href="#">
								<img class="media-object img-thumbnail user_image" 
								src="<?php
										echo htmlentities($profilePath.$image_filename);
									?>" alt="User">
							</a>
						</div>

						<!-- Commenter Comment div-->
						<div class="media-body">

							<h5 class="media-heading">
								<!-- Name -->
								<a <?php 
										echo ' href="./channel.php?slug=' . $slug . '"';
									?> 
									class="user_name" >
									<?php 
										echo htmlentities($name);
									?>
								</a>
								<!-- Time -->
								<span class="help-block comment_time pull-right text-left">
									<?php
										echo htmlentities(date('jS M Y . g:ia', strtotime($posted_at)));
									?>
								</span>
							</h5>

							<!-- Options -->
							<p class="help-block comment_options text-left text-nowrap">
								<a class="btn" onclick="setCommentReplyId(this.id);"
									id="<?php
											echo htmlentities($comment_id);
										?>">
									<i class="fa fa-reply" aria-hidden="true"></i>
								</a>
								<a type="button" onclick="setCommentEditId(this.id, 'c');"
									id="<?php
											echo htmlentities($comment_id);
										?>"
									class="btn <?php if($user_id != user_id()) echo 'hidden';?> ">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<a type="button" onclick="deleteComment(this.id, 'c')" name="delete_button" 
									id="<?php
											echo htmlentities($comment_id);
										?>"
									class="btn <?php 
													if($user_id != user_id())
														echo 'hidden';
												?> " >
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</p>

							<!-- Comment Content -->
							<p class="help-block text-left comment">
								<?php
									echo htmlentities($message);
								?>
							</p>

<?php

			# ===> fetching replies
			# QUERY
			$query = "SELECT `id`, `comment_id`, `user_id`, `message`, `posted_at` FROM `reply` WHERE `reply`.`comment_id` = '" . mysqli_real_escape_string($dbconnection, $comment_id) ."' ORDER BY `id` DESC";

			$reply_result = mysqli_query($dbconnection, $query);
		    $number_of_reply = mysqli_num_rows($reply_result);

		    if($number_of_reply > 0)
		    {
		    	while($row = mysqli_fetch_assoc($reply_result))
		    	{

			    	$reply_id = $row['id'];
			    	$user_id = $row['user_id'];
			    	$message = $row['message'];
			    	$posted_at = $row['posted_at'];

					# QUERY
					$query = "SELECT `id`, `name`, `image_filename` FROM `users` WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

					$replier_user_result = mysqli_query($dbconnection, $query);

					$row = mysqli_fetch_assoc($replier_user_result);

					$user_id = $row['id'];
					$name = $row['name'];
			    	$image_filename = $row['image_filename'];
			    	$image_filename = $image_filename != NULL ? $image_filename : $defaultProfile;


			    	# QUERY
			    	$query = "SELECT `name`, `slug` FROM `channel` WHERE `channel`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

					$replier_channel_result = mysqli_query($dbconnection, $query);

					$row = mysqli_fetch_assoc($replier_channel_result);

					$channel_name = $row['name'];
			    	$slug = $row['slug'];

?>


							<div class="media m-t-1">

								<!-- Replier Pic div-->
								<a class="media-left" href="#">
									<img class="media-object img-thumbnail user_image"
									src="<?php
										echo htmlentities($profilePath.$image_filename);
									?>" alt="User">
								</a>

								<!-- Replier Reply div-->
								<div class="media-body">
										

									<h5 class="media-heading">
										<!-- Name -->
										<a <?php 
												echo ' href="./channel.php?slug=' . $slug . '"';
											?> 
											class="user_name" >
											<?php 
												echo htmlentities($name);
											?>
										</a>
										<!-- Time -->
										<span class="help-block comment_time pull-right text-left">
											<?php
												echo htmlentities(date('jS M Y . g:ia', strtotime($posted_at)));
											?>
										</span>
									</h5>

									<!-- Options -->
									<p class="help-block comment_options text-left text-nowrap">
										<a type="button" onclick="setCommentEditId(this.id, 'r');"
											id="<?php
													echo htmlentities($reply_id);
												?>"
											class="btn <?php if($user_id != user_id()) echo 'hidden';?> ">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</a>
										<a type="button" onclick="deleteComment(this.id, 'r')" name="delete_button" 
											id="<?php
													echo htmlentities($reply_id);
												?>"
											class="btn <?php 
															if($user_id != user_id())
																echo 'hidden';
														?> " >
											<i class="fa fa-trash" aria-hidden="true"></i>
										</a>
									</p>

									<!-- Reply Content -->
									<p class="help-block text-left comment">
										<?php
											echo htmlentities($message);
										?>
									</p>

								</div>
							</div>

<?php
				}
			}
?>
						</div>

						<!-- Line Break div-->
						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

<?php
		}
	} else {
?>

						<div class="col-xs-10 col-xs-offset-1 | col-sm-7 col-sm-offset-1 | col-md-8 col-md-offset-1 | col-lg-8 col-lg-offset-1">
							<h5 class="help-block">No comments are posted.</h5>
						</div>

						<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
							<br>
						</div>

<?php
	}
?>

					</div>
					<!-- End of user Comments div-->


				</div>
				<!-- End of Comments div-->
<?php
	}
?>
				
			</div>
			<!-- End of Player Container div-->				

			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			<!-- Line Break div-->
			<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
				<br>
			</div>
			
		</div>
		<!-- end of main div-->

		<button type="button" class="btn btn-default hidden" data-toggle="modal" data-target="#popUp2" id="popUpButton2">Open Modal</button>

		<!-- Modal -->
		<div id="popUp2" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header alert alert-warning">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">
							
						</h4>
					</div>
					<div class="modal-body">

						<!-- Post Comment div-->						
						<div class="form-group text-right">

							<textarea class="form-control" placeholder="Write a comment . . ." rows="3" id="message"></textarea>

							<!-- Line Break div-->
							<div class="col-xs-12 | col-sm-12 | col-md-12 | col-lg-12">
								<br>
							</div>

							<input type="hidden" name="comment_id" value="" id="comment_id">
							<input type="hidden" name="reply_id" value="" id="reply_id">

							<button type="button" onclick="replyComment(comment_id.value, message.value)" class="btn btn-warning btn-sm" id="popUpReplyButton">&nbsp;&nbsp;Reply&nbsp;&nbsp;</button>

							<button type="button" onclick="editComment(comment_id.value, reply_id.value, message.value)" class="btn btn-warning btn-sm" id="popUpEditButton">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>

							<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" id="popUpCloseButton2">Cancel</button>

						</div>
						<!-- End of Post Comment div-->

					</div>                    
				</div>
				<!-- End of Modal content-->
			</div>            
		</div>
		<!-- End of Modal -->
	
		<!-- *************************************************************************** -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) ********************* -->
		<!-- ********* --><script src="./js/jquery.min.js"></script><!-- *************** -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- ********* --><script src="./js/bootstrap.min.js"></script><!-- ************ -->
		<!-- Include all compiled plugins for theme --><!-- **************************** -->
		<!-- ********* --><script src="./js/bootstrap-switch.js"></script><!-- ********* -->
		<!-- ********* --><script src="./js/checkbox.js"></script><!-- ***************** -->
		<!-- ********* --><script src="./js/html5shiv.js"></script><!-- **************** -->
		<!-- ********* --><script src="./js/radio.js"></script><!-- ******************** -->
		<!-- ********* --><script src="./js/switch.js"></script><!-- ******************* -->
		<!-- ********* --><script src="./js/toolbar.js"></script><!-- ****************** -->
		<!-- *************************************************************************** -->
		<!-- *************************************************************************** -->
	</body>
</html>