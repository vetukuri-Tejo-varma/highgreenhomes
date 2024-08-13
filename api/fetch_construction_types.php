<?php

include_once 'config.php';

 $select  = "select * from construction_type";
    $result = mysqli_query($conn,$select);
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
         $construction_type[] = array(
                "id"  => $row['id'],
                "category"    => $row['category'],
                "construction_image" => $row['construction_image']
            );
        }
        $status    = "success";
        $construction_types =  $construction_type;
    }
    else
    {
        $status    = "failure";
        $construction_types = "no construction type found";
    }
    echo json_encode(array("status"=>$status, "HTTPStatus"=>200,"history"=> $construction_types),JSON_UNESCAPED_SLASHES);
    mysqli_close($conn);
    exit();