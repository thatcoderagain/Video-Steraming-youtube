<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(isset($_POST['delete_button']))
    {
        if(
            isset($_POST['sure']) &&
            isset($_POST['name'])
            )
        {
            $user_id = user_id();
            $sure = $_POST['sure'];
            $name = $_POST['name'];

            if($sure == 'confirm')
            {
                $query = "SELECT `name`, `created_at`, `updated_at` FROM `playlist` WHERE `playlist`.`name` = '" .mysqli_real_escape_string($dbconnection, $name). "' AND `playlist`.`user_id` = '" .mysqli_real_escape_string($dbconnection, $user_id). "' AND `playlist`.`video_id` IS NULL";

                $result = mysqli_query($dbconnection, $query);
                $result_rows = mysqli_num_rows($result);

                if($result_rows == 1)
                {
                    echo $query = "DELETE FROM `playlist` WHERE `playlist`.`name` = '" . mysqli_real_escape_string($dbconnection, $name) . "' AND `playlist`.`user_id` = '" . mysqli_real_escape_string($dbconnection, $user_id) . "'";

                    $result = mysqli_query($dbconnection, $query);

                } else {                    
                    goto error;
                }
            } else {
                goto error;
            }
        } else {
            $_SESSION['notification']['type'] = 'warning';
            $_SESSION['notification']['header'] = 'Deleting Playlist';
            $_SESSION['notification']['message'] = 'Please confirm and tick the checkbox if you want to delete the playlist.';
            
            goto error;
        }
    } else {        
        goto error;
    }

    $_SESSION['notification']['type'] = 'primary';
    $_SESSION['notification']['header'] = 'Deleting Playlist';
    $_SESSION['notification']['message'] = 'Playlist has been deleted successfully.';

    error:

    header("Location: ./userPlaylist.php");

?>