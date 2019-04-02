<?php

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_GET['page']) && !empty($_GET['page']))
		$page = $_GET['page'];
	else
		$page = 1;

	if($page < 1)
		$page = 1;

	$limit = 5;
	$offset = $page * $limit - $limit;

	if(isset($_GET['search_input']) && !empty($_GET['search_input']))
	{
		$search = mysqli_real_escape_string($dbconnection, $_GET['search_input']);

		$keywords = explode(' ', $search);
	} else {
		echo '{"results":"null_result"}';
		die();
	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	foreach ($keywords as $key => $value) {

		if($key != 0)
		{
			$wildString.=" OR `title` LIKE '%$value%'";
			$wildString2.=" OR `name` LIKE '%$value%'";

		} else {

			$wildString ="`title` LIKE '%$value%'";
			$wildString2 ="`name` LIKE '%$value%'";
		}

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	# QUERY
	$query1 = "SELECT `title`, `url` FROM `videos` WHERE " . $wildString . " AND `videos`.`visibility` = 'public' LIMIT $offset, $limit";

	$result1 = mysqli_query($dbconnection, $query1);

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	# QUERY
	$query2 = "SELECT `name`, `slug` FROM `channel` WHERE " . $wildString2;

	$result2 = mysqli_query($dbconnection, $query2);

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$results = array();

	while ($row = mysqli_fetch_assoc($result1)) {

		$results[] = $row['title'];
		$url[] = $row['url'];
	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$results2 = array();

	while ($row = mysqli_fetch_assoc($result2)) {

		$results2[] = $row['name'];
		$slug[] = $row['slug'];
	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$percentage = array();

	foreach ($results as $key => $value) {

		similar_text(strtolower($search), strtolower($value), $percent);
		$percentage[] = $percent;

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$percentage2 = array();

	foreach ($results2 as $key => $value) {

		similar_text(strtolower($search), strtolower($value), $percent);
		$percentage2[] = $percent;

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$bestMatch = array();
	$countMatch = array();
	$titleMatch = array();
	$urlMatch = array();
	$videoList = array();
	$urlList = array();

	foreach ($results as $key => $value1) {

		$bestMatch[$key] = $countMatch[$key] = 0;

		foreach ($keywords as $key2 => $value2) {
			
			$yes = strstr(strtolower($value1), strtolower($value2));
			if($yes)
				$bestMatch[$key] += 1;

			$yes = substr_count(strtolower($value1), strtolower($value2));
			if($yes)
				$countMatch[$key] += $yes;			
		}

		$titleMatch[$key] = $bestMatch[$key] * $countMatch[$key] * $percentage[$key];

	}

	arsort($titleMatch);

	foreach ($results as $key => $value) {

		$urlMatch[$key] = $titleMatch[$key];

		$titleMatch[$key] = $results[$key];
		$urlMatch[$key] = $url[$key];

	}

	$newkey = 0;
	foreach ($titleMatch as $key => $value) {

		$videoList[$newkey] = $titleMatch[$key];
		$urlList[$newkey++] = $urlMatch[$key];

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$bestMatch2 = array();
	$countMatch2 = array();
	$nameMatch = array();
	$slugMatch = array();
	$channelList = array();
	$slugList = array();

	foreach ($results2 as $key => $value1) {

		$bestMatch2[$key] = $countMatch2[$key] = 0;

		foreach ($keywords as $key2 => $value2) {
			
			$yes = strstr(strtolower($value1), strtolower($value2));
			if($yes)
				$bestMatch2[$key] += 1;

			$yes = substr_count(strtolower($value1), strtolower($value2));
			if($yes)
				$countMatch2[$key] += $yes;			
		}

		$nameMatch[$key] = $bestMatch2[$key] * $countMatch2[$key] * $percentage2[$key];

	}

	arsort($nameMatch);

	foreach ($results2 as $key => $value) {

		$urlMatch[$key] = $nameMatch[$key];

		$nameMatch[$key] = $results2[$key];
		$slugMatch[$key] = $slug[$key];

	}

	$newkey = 0;
	foreach ($nameMatch as $key => $value) {

		$channelList[$newkey] = $nameMatch[$key];
		$slugList[$newkey++] = $slugMatch[$key];

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$next = count($videoList) < $limit ? 0 : 1;

?>