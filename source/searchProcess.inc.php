<?php

	# AJAX SEARCH SUGGESTION SCRIPT

	require_once './core.inc.php';
	require_once './dbconnect.inc.php';

	if(isset($_GET['search']) && !empty($_GET['search']))
	{
		$search = mysqli_real_escape_string($dbconnection, $_GET['search']);

		$keywords = explode(' ', $search);
	} else {
		echo '{"results":"null_result"}';
		die();
	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	foreach ($keywords as $key => $value) {

		if($key != 0)
			$wildString.=" OR `title` LIKE '%$value%'";
		else
			$wildString="`title` LIKE '%$value%'";

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	# QUERY
	$query = "SELECT `title`, `url` FROM `videos` WHERE " . $wildString . " AND `videos`.`visibility` = 'public'";

	$result = mysqli_query($dbconnection, $query);
	$result_rows = mysqli_num_rows($result);

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$results = array();

	while ($row = mysqli_fetch_assoc($result)) {

		$results[] = $row['title'];
		$url[] = $row['url'];
	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$percentage = array();

	foreach ($results as $key => $value) {

		similar_text(strtolower($search), strtolower($value), $percent);
		$percentage[] = $percent;

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	$bestMatch = array();
	$countMatch = array();
	$titleMatch = array();
	$urlMatch = array();
	$list = array();
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

		$list[$newkey] = $titleMatch[$key];
		$urlList[$newkey++] = $urlMatch[$key];

	}

# %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

	if(isset($list[0]))
	{
		echo '{"title1":"' . $list[0] . '", "url1":"' . $urlList[0] . '"';

		if(isset($list[1]))
		{
			echo ', "title2":"' . $list[1] . '", "url2":"' . $urlList[1] . '"';

			if(isset($list[2]))
			{
				echo ', "title3":"' . $list[2] . '", "url3":"' . $urlList[2] . '"';

				if(isset($list[3]))
				{
					echo ', "title4":"' . $list[3] . '", "url4":"' . $urlList[3] . '"';

					if(isset($list[4]))
						echo ', "title5":"' . $list[4] . '", "url5":"' . $urlList[4] . '"';
					
				}
				
			}			
			
		}

		echo '}';

	} else {
		echo '{"results":"null_result"}';
	}

?>