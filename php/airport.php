<?php
    include("db_connect.php");
    class showAirport extends MySqlDb{
        public function getDepartures($airportICAO){
            $sql = "select flightICAO, arrivalIcaoCode from arrivals where flightICAO in (select flightICAO from departures where depIcaoCode = \"{$airportICAO}\");";
            $result1 = $this->connect()->query($sql);
            $rows = array();
            while ($row = $result1->fetch_assoc()) {
                array_push($rows, $row);
            }
            return $rows;
        }
        public function getArrivals($airportICAO){
            $sql = "select flightICAO, depIcaoCode from departures where flightICAO in (select flightICAO from arrivals where arrivalIcaoCode = \"{$airportICAO}\");";
            $result1 = $this->connect()->query($sql);
            $rows = array();
            while ($row = $result1->fetch_assoc()) {
                array_push($rows, $row);
            }
            return $rows;
        }
        public function getType($flight){
            $sql = "select airplaneIataType from flight, airplane where aircraftRegNumber = numberRegistration and flightIcaoNumber = \"{$flight}\"";
            $result1 = $this->connect()->query($sql);
            $type = $result1->fetch_assoc()["airplaneIataType"];
            return $type;
        }
        public function getAirportName($airportICAO){
            $sql = "select nameAirport from airports where codeIcaoAirport = \"{$airportICAO}\";";
            $result1 = $this->connect()->query($sql);
            $name = $result1->fetch_assoc()["nameAirport"];
            return $name;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/airport.css">
    <script src="https://kit.fontawesome.com/02abbcab9a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    
    <?php 
        $p = new showAirport;
        $departures = $p->getDepartures($_GET["airportICAO"]);
        $arrivals = $p->getArrivals($_GET["airportICAO"]);
    ?>
    <div class="tables">
        <div class="w3-container">
            <h2>Departures</h2>
            
            <table class="w3-table-all w3-hoverable" id = "table">
                <thead>
                    <tr class="w3-light-grey">
                        <th>Ident</th>
                        <th>To</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id = "data">
                    <?php
                        $i = 0;
                        $n = count($departures);
                        for ($i = 0; $i < $n; $i++){
                            $flightIcao = $departures[$i]["flightICAO"];
                            $airport = $departures[$i]["arrivalIcaoCode"];
                            $name = $p->getAirportName($airport);
                            $type = $p->getType($flightIcao);                
                            echo "<tr>";
                            echo "<td>{$flightIcao}</td>";
                            echo "<td>{$name}</td>";
                            if ($type){echo "<td>{$type}</td>";}
                            else {echo "<td>   -</td>";}
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="w3-container">
            <h2>Arrivals</h2>
            <table class="w3-table-all w3-hoverable" id = "table">
                <thead>
                    <tr class="w3-light-grey">
                        <th>Ident</th>
                        <th>From</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id = "data">
                    <?php
                        $i = 0;
                        $n = count($arrivals);
                        for ($i = 0; $i < $n; $i++){
                            $flightIcao = $arrivals[$i]["flightICAO"];
                            $airport = $arrivals[$i]["depIcaoCode"];
                            $name = $p->getAirportName($airport);
                            $type = $p->getType($flightIcao);                
                            echo "<tr>";
                            echo "<td>{$flightIcao}</td>";
                            echo "<td>{$name}</td>";
                            if ($type){echo "<td>{$type}</td>";}
                            else {echo "<td>   -</td>";}
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>