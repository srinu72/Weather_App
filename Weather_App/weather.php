<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $city = $_POST["city"];
    $apiKey = "fa2c13f2f7814ecf77d215e6d3acdfcd"; 
    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
    $response = file_get_contents($url);
    $data = json_decode($response);

    if ($data->cod == 200) {
        $weather = $data->weather[0]->main;
        $temp = $data->main->temp;
        $humidity = $data->main->humidity;
        $windSpeed = $data->wind->speed;

    
         $script="
         <style>
          table{
            border-spacing: 0;
            margin-top: 3%;
            font-size: 14px;
            font-family: sans-serif;
            padding-left:42%;
          };
          tr{
            font-weight: bold;
            padding-bottom:10px;
          };
         </style>";
         echo $script;
         echo "<img alt='weather' style='  width: 100px; height: 100px; border-radius: 50%; padding-left:42%; margin-top:2%;' src='./Images/OIP.jpg' class='img'></img>";
       echo "<table>";
       echo"<tr>";
        echo "<tr><td><strong>City :</strong> $city</td> </tr>"  ;
        echo "<tr><td><strong>Weather:</strong> $weather</td></tr> ";
        echo "<tr><td><strong>Temperature:</strong> $temp °C</td>   </tr> ";
        echo "<tr><td><strong>Humidity:</strong> $humidity%</td>       </tr> ";
        echo "<tr><td><strong>Wind Speed:</strong> $windSpeed m/s</td> </tr>  ";
        echo"</tr>";
        echo "</table>";
        
        
    } else {
        echo "<div>City not found!</div>";
    }
    if ($response) {
        $data = json_decode($response, true);
        $sunrise = $data['sys']['sunrise'];
        $sunset = $data['sys']['sunset'];
        
        $currentTime = time();
        
      
        $sunriseTime = gmdate("Y-m-d H:i:s", $sunrise);
        $sunsetTime = gmdate("Y-m-d H:i:s", $sunset);
        
        $currentTime = gmdate("Y-m-d H:i:s", $currentTime);
        
        if ($currentTime > $sunriseTime && $currentTime < $sunsetTime) {
            echo "<table>";
            echo"<tr>";
            echo " <tr> <td><center>It's daytime in $city.<center> </td></tr>";
        } else {
            echo "<tr> <td><h3 style='padding-left:42%; margin-top:10px;'>It's nighttime in $city.</h3></td></tr>";
            echo"</tr>";
            echo "</table>";
        }
    } else {
        echo "Failed to fetch weather data.";
    }
}
?>
