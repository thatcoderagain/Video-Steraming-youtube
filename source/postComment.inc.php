<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(is_logged_in() && isset($_POST['url']) && !empty($_POST['url']) && isset($_POST['message']) && !empty($_POST['message']))
    {
        $user_id = user_id();
        $url = $_POST['url'];
        $message = $_POST['message'];

        # QUERY
        $query = "SELECT `id` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) ."'";

        $result = mysqli_query($dbconnection, $query);
        $result_rows = mysqli_num_rows($result);

        if($result_rows == 1)
        {
            $row = mysqli_fetch_assoc($result);

            $video_id = $row['id'];

            # QUERY
            $query = "INSERT INTO `comment` (`id`, `video_id`, `user_id`, `message`, `posted_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $video_id) ."', '" . mysqli_real_escape_string($dbconnection, $user_id) ."', '" . mysqli_real_escape_string($dbconnection, $message) ."', CURRENT_TIMESTAMP)";

            $result = mysqli_query($dbconnection, $query);

            if($result)
                echo '{"comment":"posted"}';
            else 
                echo '{"comment":"not posted"}';
        }

    } else {
        return NULL;
    }
    
?>