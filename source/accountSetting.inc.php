<?php
		
	require_once './core.inc.php';
	require_once './dbconnect.inc.php';
	
	if(isset($_POST['update_button']))
	{
		if(
			isset($_POST['name']) &&
			isset($_POST['dob']) &&
			isset($_POST['email']) &&
			isset($_POST['newpassword'])
			)
		{
			$user_id = user_id();

			if(!empty($_POST['name']))
			{
				$name = $_POST['name'];

				# QUERY
				$query = "UPDATE `users` SET `name` = '" . mysqli_real_escape_string($dbconnection ,$name) . "' WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

				$result = mysqli_query($dbconnection, $query);
			}

			if(!empty($_POST['dob']))
			{
				$dob = $_POST['dob'];

				# QUERY
				$query = "UPDATE `users` SET `dob` = '" . mysqli_real_escape_string($dbconnection ,$dob) . "' WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

				$result = mysqli_query($dbconnection, $query);
			}

			if(!empty($_POST['email']))
			{
				$email = $_POST['email'];

				# QUERY
				$query = "SELECT `email` FROM `users` WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "'";

				$result = mysqli_query($dbconnection, $query);
				$result_rows = mysqli_num_rows($result);

				if($result_rows == 0)
				{
					# QUERY
					$query = "UPDATE `users` SET `email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "' WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

					$result = mysqli_query($dbconnection, $query);
				} else {
					# QUERY
					$query = "SELECT `email` FROM `users` WHERE `users`.`email` = '" . mysqli_real_escape_string($dbconnection ,$email) . "' AND `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

					$result = mysqli_query($dbconnection, $query);
					$result_rows = mysqli_num_rows($result);

					if($result_rows == 1)
					{
						$_SESSION['notification']['type'] = 'danger';
						$_SESSION['notification']['header'] = 'Email updation failed';
						$_SESSION['notification']['message'] = 'This email address is already registered with your account.';
						goto error;
					} else {
						$_SESSION['notification']['type'] = 'danger';
						$_SESSION['notification']['header'] = 'Email updation failed';
						$_SESSION['notification']['message'] = 'This email address is already registered with another account.';
						goto error;
					}
				}
			}

			if(!empty($_POST['newpassword']))
			{
				$newpassword = $_POST['newpassword'];
				$passwordhash = password_to_hash($newpassword);

				# QUERY
				$query = "UPDATE `users` SET `password` = '" . mysqli_real_escape_string($dbconnection ,$passwordhash) . "' WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

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
						if($imageSIZE <= 5120000 )
						{
							# QUERY
							$query = "SELECT `image_filename` FROM `users` Where `users`.`image_filename` IS NULL AND `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

							$result = mysqli_query($dbconnection, $query);
							$result_rows = mysqli_num_rows($result);
							
							if($result_rows == 1)
							{
								# TRY Again
								image_filename:

								$filename = str_shuffle($string) . '.jpg';

								# QUERY
								$query = "SELECT `image_filename` FROM `users` Where `users`.`image_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "'";

								$result = mysqli_query($dbconnection, $query);
								$result_rows = mysqli_num_rows($result);

								if($result_rows == 0)
								{
									if(move_uploaded_file($imageTMPNAME, $profilePath.$filename))
									{
										# QUERY
										$query = "UPDATE `users` SET `image_filename` = '" . mysqli_real_escape_string($dbconnection ,$filename) . "' WHERE `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

										$success = mysqli_query($dbconnection, $query);

										if($success)
										{
											# Scaling down image
											/*
											$image = $profilePath.$filename;
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
								$query = "SELECT `image_filename` FROM `users` Where `users`.`id` = '" . mysqli_real_escape_string($dbconnection ,$user_id) . "'";

								$result = mysqli_query($dbconnection, $query);
								$row = mysqli_fetch_assoc($result);
								$filename = $row['image_filename'];

								if(move_uploaded_file($imageTMPNAME, $profilePath.$filename))
								{
									# Scaling down image
									/*
									$image = $profilePath.$filename;
									$new_width = 140;
									$new_height = 140;
									imageResize($image, $new_width, $new_height);
									*/

								} else {
									$_SESSION['notification']['type'] = 'danger';
									$_SESSION['notification']['header'] = 'Thumbnail file Error.';
									$_SESSION['notification']['message'] = 'Thumbnail file uploading failed.';
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