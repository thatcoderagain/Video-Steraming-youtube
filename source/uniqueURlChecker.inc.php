<?php

    require_once './core.inc.php';
    require_once './dbconnect.inc.php';

    if(isset($_POST['slug']) && !empty($_POST['slug']))
    {
        $slug = $_POST['slug'];

        if(ctype_alnum($slug))
        {
            $query = "SELECT `slug` FROM `channel` WHERE `slug` = '" . mysqli_real_escape_string($dbconnection, $slug) . "'";

            $result = mysqli_query($dbconnection, $query);
            $result_rows = mysqli_num_rows($result);

            if($result_rows != 1){
                echo '{"url":"unique"}';
            } else {
                echo '{"url":"common"}';
            }
        }
    } else {
        return NULL;
    }
    
?>