<?php


include "sanitization.php";
session_start();
$result = "";

if (isset($_POST['rented_cars'])) { 
    $request_type = sanitizeMYSQL($connection, $_POST['rented_cars']);
   $result = get_cars($connection, $request_type);
   echo $result;
}


function get_cars($connection,$request_type) {
    $final = array();
    $query = "SELECT Car.Picture, Car.Picture_type, Car.CarSpecsID, CarSpecs.Make, CarSpecs.Model, CarSpecs.YearMade, CarSpecs.Size, Rental.ID as rental_id, Rental.rentDate as rent_date"
            . "FROM Car JOIN CarSpecs ON Car.CarSpecsID = CarSpecs.ID JOIN Rental ON Car.ID = Rental.carID WHERE Rental.CustomerID = '".$_SESSION["username"]."";
    

    $result = mysqli_query($connection, $query);
    $text = "";
    if (!$result)
    {       
       return json_encode($array);
    }
    else {
        $row_count = mysqli_num_rows($result);
        for ($i = 0; $i < $row_count; $i++) {
            $row = mysqli_fetch_array($result);
            $array = array();
            $array["make"] = $row["Make"];
            $array["model"] = $row["Model"];
            $array["year"] = $row["YearMade"];
            $array["size"] = $row["Size"];         
            $array["rental_id"] = $row["rental_id"];
            $array["rent_date"] = $row["rent_date"];
            $array["picture"] = 'data:' . $row["Picture_type"] . ';base64,' . base64_encode($row["Picture"]);
            $final[] = $array;
        }
    }
    return json_encode($final);
        
}
