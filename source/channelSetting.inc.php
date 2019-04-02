<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_POST['update_button']))
	{
		if(
			isset($_POST['name']) &&
			isset($_POST['slug']) &&
			isset($_POST['description'])
			)
		{
			$channel_id = channel_id();

			if(!empty($_POST['name']))
			{
				$name = $_POST['name'];

				$query = "UPDATE `channel` SET `name` = '" . mysqli_real_escape_string($dbconnection ,$name) . "' WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

				$result = mysqli_query($dbconnection, $query);
			}

			if(!empty($_POST['slug']))
			{
				$slug = $_POST['slug'];

				#QUERY
				$query = "SELECT `slug` FROM `channel` WHERE `channel`.`slug` = '" . mysqli_real_escape_string($dbconnection ,$slug) . "'";

				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);

				if($result_rows == 0)
				{   
					#QUERY
					$query = "UPDATE `channel` SET `slug` = '" . mysqli_real_escape_string($dbconnection ,$slug) . "' WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";
				
					$result = mysqli_query($dbconnection, $query);
				} else {
					$_SESSION['notification']['type'] = 'danger';
					$_SESSION['notification']['header'] = 'Unique URL update failed.';
					$_SESSION['notification']['message'] = 'URL '. htmlentities($slug) .' is already occupied by someone else.';
					goto error;
				}
			}

			if(!empty($_POST['description']))
			{
				$description = $_POST['description'];

				#QUERY
				$query = "UPDATE `channel` SET `description` = '" . mysqli_real_escape_string($dbconnection ,$description) . "' WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

				$result = mysqli_query($dbconnection, $query);
			}

			if(!empty($_FILES['imagefile']) && $_FILES['imagefile']['size'] != 0)
			{
				$imageNAME = $_FILES['imagefile']['name'];
				$imageTMPNAME = $_FILES['imagefile']['tmp_name'];
				$imageSIZE = $_FILES['imagefile']['size'];
				$imageTYPE = $_FILES['imagefile']['type'];                
				$imageEXTENSION = strtolower(substr($imageNAME, strripos($imageNAME, '.') + 1));

				if($imageEXTENSION == 'jpg' || $imageEXTENSION == 'jpeg' || $imageEXTENSION == 'png')
				{
					if($imageTYPE == 'image/jpeg' || $imageTYPE == 'image/png')
					{
						if($imageSIZE <= 5000000 )
						{
							#QUERY
							$query = "SELECT `image_filename` FROM `channel` Where `channel`.`image_filename` IS NULL AND `channel`.`id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

							$result = mysqli_query($dbconnection, $query);
							$result_rows = mysqli_num_rows($result);
							
							if($result_rows == 1)
							{
								# TRY Again
								image_filename:

								$filename = str_shuffle($string) . '.jpg';

								#QUERY
								$query = "SELECT `image_filename` FROM `channel` Where `channel`.`image_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "'";

								$result = mysqli_query($dbconnection, $query);
								$result_rows = mysqli_num_rows($result);

								if($result_rows == 0)
								{
									if(move_uploaded_file($imageTMPNAME, $channelPath.$filename))
									{
										#QUERY
										$query = "UPDATE `channel` SET `image_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "' WHERE `channel`.`id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

										$success = mysqli_query($dbconnection, $query);

										if($success)
										{
											# Scaling down image
											/*
											$image = $channelPath.$filename;
											$new_width = 140;
											$new_height = 140;
											imageResize($image, $new_width, $new_height);
											*/
											
										} else {
											$_SESSION['notification']['type'] = 'danger';
											$_SESSION['notification']['header'] = 'Image file Error.';
											$_SESSION['notification']['message'] = 'Image file uploading failed.';
											goto error;
										}
									}
								} else {
									goto image_filename;
								}
							} else {
								# QUERY
								$query = "SELECT `image_filename` FROM `channel` Where `channel`.`id` = '" . mysqli_real_escape_string($dbconnection ,$channel_id) . "'";

								$result = mysqli_query($dbconnection, $query);
								$row = mysqli_fetch_assoc($result);
								$filename = $row['image_filename'];

								if(move_uploaded_file($imageTMPNAME, $channelPath.$filename))
								{
									# Scaling down image
									/*
									$image = $channelPath.$filename;
									$new_width = 140;
									$new_height = 140;
									imageResize($image, $new_width, $new_height);
									*/

								} else {
									$_SESSION['notification']['type'] = 'danger';
									$_SESSION['notification']['header'] = 'Image file Error.';
									$_SESSION['notification']['message'] = 'Image file uploading failed.';
									goto error;
								}
							}
						} else {
							$_SESSION['notification']['type'] = 'danger';
							$_SESSION['notification']['header'] = 'Image file Error.';
							$_SESSION['notification']['message'] = 'File size should be less than or equals to 5MB.';
							goto error;
						}
					} else {
						$_SESSION['notification']['type'] = 'danger';
						$_SESSION['notification']['header'] = 'Image file Error.';
						$_SESSION['notification']['message'] = 'Invalid image file type.';
						goto error;
					}
				} else {
					$_SESSION['notification']['type'] = 'danger';
					$_SESSION['notification']['header'] = 'Image file Error.';
					$_SESSION['notification']['message'] = 'Invalid file extension.';
					goto error;
				}
			}
		}
	}
	
	$_SESSION['notification']['type'] = 'primary';
	$_SESSION['notification']['header'] = 'Update Success';
	$_SESSION['notification']['message'] = 'Changes are updated successfully.';

	error:

	$loc = $_SERVER['HTTP_REFERER'];
	header("Location: $loc");

?>