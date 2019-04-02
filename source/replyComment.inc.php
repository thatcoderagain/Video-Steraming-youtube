<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(is_logged_in() && isset($_POST['comment_id']) && !empty($_POST['comment_id']) && isset($_POST['message']) && !empty($_POST['message']))
    {
        $user_id = user_id();
        $comment_id = $_POST['comment_id'];
        $message = $_POST['message'];

        # QUERY
        $query = "SELECT `id` FROM `comment` WHERE `comment`.`id` = '" . mysqli_real_escape_string($dbconnection, $comment_id) ."'";

        $result = mysqli_query($dbconnection, $query);
        $result_rows = mysqli_num_rows($result);

        if($result_rows == 1)
        {
            # QUERY
            $query = "INSERT INTO `reply` (`id`, `comment_id`, `user_id`, `message`, `posted_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $comment_id) ."', '" . mysqli_real_escape_string($dbconnection, $user_id) ."', '" . mysqli_real_escape_string($dbconnection, $message) ."', CURRENT_TIMESTAMP)";

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