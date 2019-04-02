<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(is_logged_in() && isset($_POST['button']) && isset($_POST['url']) && !empty($_POST['url']))
    {
        $user_id = user_id();
        $name = $_POST['button']; // IMPORTANT
        $url = $_POST['url'];

        # QUERY
        $query = "SELECT `id` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

        $result = mysqli_query($dbconnection, $query);
        $result_rows = mysqli_num_rows($result);

        if($result_rows == 1)
        {
            $row = mysqli_fetch_assoc($result);
            $video_id = $row['id'];
        }

        # QUERY
        $query = "SELECT `id` FROM `playlist` WHERE `playlist`.`video_id` = '" . mysqli_real_escape_string($dbconnection, $video_id) ."' AND `playlist`.`name` = '" . mysqli_real_escape_string($dbconnection, $name) ."' AND `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

        $result = mysqli_query($dbconnection, $query);
        $result_rows = mysqli_num_rows($result);

        if($result_rows == 1)
        {
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];

            # QUERY
            $query = "DELETE FROM `playlist` WHERE `playlist`.`id` = '" . mysqli_real_escape_string($dbconnection, $id) ."' AND `playlist`.`video_id` IS NOT NULL";

            $result = mysqli_query($dbconnection, $query);

            echo '{"playlist":"removed"}';
        } else {

            # QUERY
            $query = "INSERT INTO `playlist` (`id`, `user_id`, `name`, `video_id`, `created_at`, `updated_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $user_id) ."', '" . mysqli_real_escape_string($dbconnection, $name) ."', '" . mysqli_real_escape_string($dbconnection, $video_id) ."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

            $result = mysqli_query($dbconnection, $query);

            echo '{"playlist":"added"}';
        }

    } else {
        return NULL;
    }
?>