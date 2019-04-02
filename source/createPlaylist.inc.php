<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';    

    if(isset($_POST['create_button']) && isset($_POST['playlist_Name']) && !empty($_POST['playlist_Name']))
    {
        $user_id = user_id();
        $name = $_POST['playlist_Name'];

        # QUERY
        $query = "SELECT `id` FROM `playlist` WHERE `playlist`.`video_id` IS NULL AND `playlist`.`name` = '" . mysqli_real_escape_string($dbconnection, $name) ."' AND `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) ."'";

        $result = mysqli_query($dbconnection, $query);
        $result_rows = mysqli_num_rows($result);

        if($result_rows == 1)
        {
            echo '{"playlist":"existed"}';
        } else {

            # QUERY
            $query = "INSERT INTO `playlist` (`id`, `user_id`, `name`, `video_id`, `created_at`, `updated_at`) VALUES (NULL, '" . mysqli_real_escape_string($dbconnection, $user_id) ."', '" . mysqli_real_escape_string($dbconnection, $name) ."', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

            $result = mysqli_query($dbconnection, $query);

            echo '{"playlist":"created"}';
        }
        
    } else {
        return NULL;
    }

?>