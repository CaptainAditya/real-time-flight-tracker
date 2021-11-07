<?php
    //https://flightaware.com/images/airline_logos/90p/AAL.png
    include("db_connect.php");
    class flightInfo extends MySqlDb{
        public function getFlightRow(){
            $flightICAO = $_GET["flightICAO"]; 
            $sql1 = "select * from flight";
            $result1 = $this->connect()->query($sql1);
            $row = NULL;
            while ($row = $result1->fetch_assoc()) {
                if ($row['flightIcaoNumber'] == $flightICAO) 
                    break;
            }
            return $row;
        }
        public function getAirlineRow(){
            //get Airline Name
            $flightICAO = $_GET["flightICAO"];
            $sql2 = "select * from flight, airlines where airlineIcaoCode = codeIcaoAirline and flightIcaoNumber = "."\"".$flightICAO."\""."".";";
            $result2 = $this->connect()->query($sql2);
            $row2 =  $result2->fetch_assoc();
            // $nameAirline = $row2['nameAirline'];
            return $row2;
        }
        public function getDepartureRow(){    
            //departure IATA Code
            $flightICAO = $_GET["flightICAO"];
            $sql3 = "select * from flight, departures where flightIcaoNumber = flightICAO and flightIcaoNumber = "."\"".$flightICAO."\""."".";";
            $result3 = $this->connect()->query($sql3);
            $row3 = $result3->fetch_assoc();
            return $row3;
        }
        public function DepartureAirportRow($depIataCode){
            // //nameCountry of dep
            $flightICAO = $_GET["flightICAO"];
            $sql4 = "select * from Airports where codeIataAirport = "."\"".$depIataCode."\""."".";";;
            $result4 = $this->connect()->query($sql4);
            $row4 = $result4->fetch_assoc();
            return $row4;
            // $depNameCountry = $row4['nameCountry'];
        }
        public function getArrivalRow(){
            // //arrival IATA Code
            $flightICAO = $_GET["flightICAO"];
            $sql5 = "select * from flight, arrivals where flightIcaoNumber = flightICAO and flightIcaoNumber = "."\"".$flightICAO."\""."".";";
            $result5 = $this->connect()->query($sql5);
            $row5 = $result5->fetch_assoc();
            return $row5;
        } 
        public function ArrivalAirportRow($arrivalIataCode){
        // $arrivalIataCode = $row5['arrivalIataCode'];
            $flightICAO = $_GET["flightICAO"];
            // //nameCountry of arrival
            $sql6 = "select * from Airports where codeIataAirport = "."\"".$arrivalIataCode."\""."".";";
            $result6 = $this->connect()->query($sql6);
            $row6 = $result6->fetch_assoc();
            return $row6;
            // $arrivalNameCountry = $row6['nameCountry'];
        }
        public function getAirplaneRow($aircraftRegNumber){
            $sql7 = "select * from airplane, flight where numberRegistration = aircraftRegNumber and aircraftRegNumber = "."\"".$aircraftRegNumber."\";";
            $result7 = $this->connect()->query($sql7);
            $row7 = $result7->fetch_assoc();
            return $row7;
        }
            // //Aircraft Registration
            // $aircraftRegNumber = $row['aircraftRegNumber'];
           
            // $airplaneIataType = $row7['airplaneIataType'];
            // $engineCount = $row7['engineCount'];
            // $enginesType = $row7['enginesType'];
            // $planeAge = $row7['planeAge'];
            // $productionLine = $row7['productionLine'];
        public function liveStatus(){
            $flightICAO = $_GET["flightICAO"];
            // //Live Status
            $sql8 = "select * from flight, Current_Status where flightICAO = flightIcaoNumber and flightIcaoNumber = "."\"".$flightICAO."\""."".";";
            $result8 = $this->connect()->query($sql8);
            $row8 = $result8->fetch_assoc();
            return $row8;
            // $altitude = $row8['altitude'];

            // $direction = $row8['direction'];
            // $horizontalSpeed = $row8['horizontalSpeed'];
            // $verticalSpeed = $row8['verticalSpeed'];
            
            // echo "<h1>".$nameAirline."</h1>";
            
        }
        public function getHubAirport($iataCode){
            $sql = "select * from airports where codeIataAirport = "."\"".$iataCode."\";";
            $result = $this->connect()->query($sql);
            $row = $result->fetch_assoc();
            return $row['nameAirport'];
        }
        

    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/flight-info.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand" href="../html/welcome.html">SkyView</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="../html/welcome.html">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="https://aviation-edge.com/">API</a></li>
            </ul>
            <button class="btn btn-danger navbar-btn" ><a href="../php/search.php"></a> Search</button>
        </div>
    </nav>
    <?php
        $f = new flightInfo();
        $flightRow = $f->getFlightRow();
        $airlineRow = $f->getAirlineRow();
        $departureRow = $f->getDepartureRow();
        $departureAirportRow = $f->DepartureAirportRow($departureRow['depIataCode']);
        $arrivalRow = $f->getArrivalRow();
        $arrivalAirportRow = $f->ArrivalAirportRow($arrivalRow['arrivalIataCode']);
        $airplaneRow = $f->getAirplaneRow($flightRow['aircraftRegNumber']);
        $live_status = $f->liveStatus();
        $airlineIcaoCode = $airlineRow['codeIcaoAirline'];
        $flightNumber = substr($flightRow['flightIcaoNumber'], 3);
        $cookie_name = "url";
        $cookie_value = $airlineIcaoCode;
        setcookie($cookie_name, $cookie_value);
        
        $flightICAO = $_GET["flightICAO"];
        $url =  "http://aviation-edge.com/v2/public/timetable?key=[API_KEY]&flight_icao=".$flightICAO;
        $response = file_get_contents($url);
        $tmp = (array)json_decode($response);
        print_r (in_array("error", $tmp) );
        
        if(in_array("error", $tmp)){
            $departure_terminal = NULL;
            $arrival_terminal = NULL;
            $departure_time = array("-","-");
            $arrival_time = array("-", "-"); 
        } 
        else{
            $departure_terminal = $tmp[0]->departure->terminal;
            $arrival_terminal = $tmp[0]->arrival->terminal;
            $departure_time = explode('T', $tmp[0]->departure->scheduledTime);
            $arrival_time = explode('T', $tmp[0]->arrival->scheduledTime); 
        }        
    ?>
    <div class="container" id = "1">
        <div class="flight_info" id = "2"> 
            <div class="logo" id = "logo"></div>
            <script> 
                var div = document.getElementById("logo");
                const x = document.cookie.slice(4, 7);
                var url = "https://flightaware.com/images/airline_logos/90p/" + x + ".png";
                logo = document.createElement('img');
                logo.src = url;
                div.appendChild(logo);
            </script>
            <div class="name_number">
                <h1><?php echo $airlineRow['callsign']." ".$flightNumber  ?></h1>
                <h3><?php echo $flightRow['flightIcaoNumber']." / ".$airlineRow['codeIataAirline']."".$flightNumber ?></h3>
            </div>
            
            <div class="status">
                <h3><?php echo strtoupper($flightRow['status']) ?></h3>
            </div>
            <div class="departure_info">
                <h2><?php echo $departureRow['depIataCode'] ?></h2>
                <h2><?php echo $departureAirportRow['nameAirport'].", ".$departureAirportRow['nameCountry'] ?></h2>
                <h2><?php echo $departure_time[0] ?></h2>
                <h2><?php echo $departure_time[1] ?></h2>
                <h3 style="color: orange;">Left Terminal : <?php echo $departure_terminal ?></h3>
            </div>
            <div class="arrival_info">
                <h2><?php echo $arrivalRow['arrivalIataCode'] ?></h2>
                <h2><?php echo $arrivalAirportRow['nameAirport'].", ".$arrivalAirportRow['nameCountry'] ?></h2>
                <h2><?php echo $arrival_time[0] ?></h2>
                <h2><?php echo $arrival_time[1] ?></h2>
                <h3 style="color: darkgreen;">Arriving Terminal : <?php echo $arrival_terminal ?></h3>
            </div>
            
            <div id="map">
                <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJZ4xOAE7Yq90rehEl0jmHRbL5x1vzRfg&callback=initMap&v=weekly"
                    async
                ></script>
                <script>
                    
                    function initMap() {
                        icon = "../svg/airplane.png"
                        latitude = parseFloat(document.getElementById("lat").textContent);
                        longitude = parseFloat(document.getElementById("long").textContent);
                        // The location of Uluru
                        const uluru = { lat: latitude, lng: longitude };
                        // The map, centered at Uluru
                        const map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 4,
                            center: uluru,
                            mapId: "ccb377c1dbf1c670"
                        });
                        // The marker, positioned at Uluru
                        const marker = new google.maps.Marker({
                            position: uluru,
                            map: map,
                            icon: {
                                url: icon,
                                size: new google.maps.Size(36, 50),
                                scaledSize: new google.maps.Size(36, 50),
                                anchor: new google.maps.Point(0, 50)
                            }
                        });
                    }
                </script>   
            </div>
            <div class="w3-table-all w3-hoverable" id = "10">
                <h1>Aircraft Details</h1>
                <table>
                    <tr>
                        <th>Aircraft Type</th>
                        <td>
                            <?php 
                                if ($airplaneRow['airplaneIataType']){
                                    echo $airplaneRow['airplaneIataType'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tail Number</th>
                        <td>
                            <?php 
                                if ($airplaneRow['numberRegistration']){
                                    echo $airplaneRow['numberRegistration'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Engine Count</th>
                        <td>
                            <?php 
                                if ($airplaneRow['engineCount']){
                                    echo $airplaneRow['engineCount'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Engine Type</th>
                        <td>
                            <?php 
                                if ($airplaneRow['enginesType']){
                                    echo $airplaneRow['enginesType'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Plane Age</th>
                        <td>
                            <?php 
                                if ($airplaneRow['planeAge']){
                                    echo $airplaneRow['planeAge']." "."years";
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Production Line</th>
                        <td>
                            <?php 
                                if ($airplaneRow['productionLine']){
                                    echo $airplaneRow['productionLine'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                </table>

                <h1>Airline Details</h1>
                <table>
                    <tr>
                        <th>Airline Name</th>
                        <td>
                            <?php 
                                if ($airlineRow['nameAirline']){
                                    echo $airlineRow['nameAirline'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Hub Airport</th>
                        <td>
                            <?php 
                                if ($airlineRow['codeHub']){
                                    if ($f->getHubAirport($airlineRow['codeHub']) != NULL){
                                        echo $f->getHubAirport($airlineRow['codeHub']);
                                    }
                                    else{
                                        echo "-";
                                    }
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Age Fleet</th>
                        <td>
                            <?php 
                                if ($airlineRow['ageFleet']){
                                    echo $airlineRow['ageFleet'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Year Founded</th>
                        <td>
                            <?php 
                                if ($airlineRow['founding']){
                                    echo $airlineRow['founding'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>
                            <?php 
                                if ($airlineRow['nameCountry']){
                                    echo $airlineRow['nameCountry'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Airline Size</th>
                        <td>
                            <?php 
                                if ($airlineRow['sizeAirline']){
                                    echo $airlineRow['sizeAirline'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                </table>

                <h1>Current Status</h1>
                <table>
                    <tr>
                        <th>Altitude</th>
                        <td>
                            <?php 
                                if ($live_status['altitude']){
                                    echo $live_status['altitude']." ft";
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Direction</th>
                        <td>
                            <?php 
                                if ($live_status['direction']){
                                    echo $live_status['direction']."°";
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Latitude</th>
                        <td id = "lat">
                            <?php 
                                if ($live_status['latitude']){
                                    echo $live_status['latitude'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Longitude</th>
                        <td id = "long">
                            <?php 
                                if ($live_status['longitude']){
                                    echo $live_status['longitude'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Horizontal Speed</th>
                        <td>
                            <?php 
                                if ($live_status['horizontalSpeed']){
                                    echo $live_status['horizontalSpeed'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Vertical Speed</th>
                        <td>
                            <?php 
                                if ($live_status['verticalSpeed']){
                                    echo $live_status['verticalSpeed'];
                                }
                                else{
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>On Ground</th>
                        <td>
                            <?php 
                                if ($live_status['isGround']){
                                    echo "Yes";  
                                }
                                else{
                                    echo "No";
                                }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>
