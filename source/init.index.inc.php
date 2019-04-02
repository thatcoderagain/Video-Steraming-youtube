<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	if(isset($_GET['page']) && !empty($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 1;

	if($page < 1)
		$page = 1;

	$limit = 5;
	$offset = $page * $limit - $limit;

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	# QUERY
	$query = "SELECT `title`, `url` FROM `videos` WHERE `videos`.`visibility` = 'public' ORDER BY `id` DESC LIMIT $offset, $limit";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$results = array();
	$list = array();
	$urlList = array();

	while ($row = mysqli_fetch_assoc($result)) {

		$list[] = $row['title'];
		$urlList[] = $row['url'];
	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$next = count($list) < $limit ? 0 : 1;

?>