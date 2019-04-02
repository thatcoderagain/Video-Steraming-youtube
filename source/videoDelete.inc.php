<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(isset($_POST['delete_button']))
    {
        if(
            isset($_POST['sure']) &&
            isset($_POST['url'])
            )
        {
            $channel_id = channel_id();
            $sure = $_POST['sure'];
            $url = $_POST['url'];

            if($sure == 'confirm')
            {
                $query = "SELECT `video_filename`, `audio_filename`, `subtitle_filename`, `thumbnail_filename` FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "'";

                $result = mysqli_query($dbconnection, $query);
                $result_rows = mysqli_num_rows($result);

                if($result_rows == 1)
                {
                    $row = mysqli_fetch_assoc($result);

                    $video_filename = $row['video_filename'];
                    $audio_filename = $row['audio_filename'];
                    $subtitle_filename = $row['subtitle_filename'];
                    $thumbnail_filename = $row['thumbnail_filename'];

                    if(file_exists($videosPath.$video_filename))
                    {
                        unlink($videosPath.$video_filename);
                    }

                    if(file_exists($audiosPath.$audio_filename))
                    {
                        unlink($audiosPath.$audio_filename);
                    }

                    if(file_exists($subtitlesPath.$subtitle_filename))
                    {
                        unlink($subtitlesPath.$subtitle_filename);
                    }

                    if(file_exists($thumbnailPath.$thumbnail_filename))
                    {
                        unlink($thumbnailPath.$thumbnail_filename);
                    }

                    $query = "DELETE FROM `videos` WHERE `videos`.`url` = '" . mysqli_real_escape_string($dbconnection, $url) . "' AND `videos`.`channel_id` = '" . mysqli_real_escape_string($dbconnection, $channel_id) . "'";

                    $result = mysqli_query($dbconnection, $query);

                } else {                    
                    goto error;
                }
            } else {
                goto error;
            }
        } else {
            $_SESSION['notification']['type'] = 'warning';
            $_SESSION['notification']['header'] = 'Deleting Video';
            $_SESSION['notification']['message'] = 'Please confirm and tick the checkbox if you want to delete the video.';
            
            goto error;
        }
    } else {        
        goto error;
    }

    $_SESSION['notification']['type'] = 'primary';
    $_SESSION['notification']['header'] = 'Deleting Video';
    $_SESSION['notification']['message'] = 'Video has been deleted successfully.';

    error:

    $loc = $_SERVER['HTTP_REFERER'];
    header("Location: $loc");
?>