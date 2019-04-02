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

	$channel_id = channel_id();

    # QUERY
    $query = "SELECT `id`, `title`, `thumbnail_filename`, `published`, `visibility`, `url` FROM `videos` WHERE `channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "' ORDER BY `id` DESC LIMIT $offset, $limit";

    $result = mysqli_query($dbconnection, $query);
    $result_rows = mysqli_num_rows($result);

    $next = $result_rows < $limit ? 0 : 1;

?>