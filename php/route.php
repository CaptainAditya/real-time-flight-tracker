<?php
    //https://flightaware.com/images/airline_logos/90p/AAL.png
    include("db_connect.php");
    class route extends MySqlDb{
        public function getDetails(){
            $origin = $_GET["origin"]; 
            $destination = $_GET["destination"]; 
            $sql1 = "select a.flightICAO, a.aircraftRegNumber, a.status, a.airlineIcaoCode, b.depIcaoCode, a.arrivalIcaoCode from (select * from flight, arrivals where flight.flightIcaoNumber = arrivals.flightICAO) as a, 
            (select * from flight, departures where flight.flightIcaoNumber = departures.flightICAO) as b where a.flightICAO = b.flightICAO and b.depIcaoCode = "."\"".$origin."\""." and a.arrivalIcaoCode = "."\"".$destination."\""."".";";
            $result1 = $this->connect()->query($sql1);
            $rows = array();
            while ($row = $result1->fetch_assoc()) {
                array_push($rows, $row);
            }
            // print_r($rows);
            return $rows;
        }   
        public function getAirlineName($airlineICAO){
            //get Airline Name
            $sql2 = "select nameAirline from airlines where codeIcaoAirline = \"{$airlineICAO}\";";
            $result2 = $this->connect()->query($sql2);
            $row2 =  $result2->fetch_assoc();
            $nameAirline = $row2['nameAirline'];
            return $nameAirline;
        }
        public function getAircraft($reg){
            $sql3 = "select airplaneIataType from airplane where numberRegistration = \"{$reg}\";";
            $result3 = $this->connect()->query($sql3);
            $row3 =  $result3->fetch_assoc();
            $aircraftModel = $row3['airplaneIataType'];
            return $aircraftModel;
        }
    }
    // $p = new route();
    // $rows = $p->getDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/route.css">
    <script src="https://kit.fontawesome.com/02abbcab9a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand" href="#">SkyView</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="../html/welcome.html">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="https://aviation-edge.com/">API</a></li>
            </ul>
            <button class="btn btn-danger navbar-btn">Search</button>
        </div>
    </nav>
    <?php
        $p = new route();
        $rows = $p->getDetails();
    ?>
    <div class="container">
        <div class="search-header">Search for flights by origin and destination airport</div>
        <center>
        <div class="status">
            <span class= "wrapper">
                <?php 
                    $query = $_GET;
                    // replace parameter(s)
                    $query['origin'] = $_GET["destination"];
                    $query['destination'] = $_GET["origin"];
                    // rebuild url
                    $query_result = http_build_query($query);
                    $url = $_SERVER['PHP_SELF']; 
                    $para = $query_result;
                    $completeURL = $url."?".$para;
                ?>
                <input type="text" class = "status1" re  placeholder=<?php echo $_GET["origin"] ?>>
                <a href= <?php echo $completeURL ?> ><i class="fas fa-exchange-alt"></i></a>
                <input type="text" class = "status1" placeholder=<?php echo $_GET["destination"] ?>>
            </span>
        </div>
        </center>
        <center>
        <div class="filter-box">
            <h2>filter results</h2>
            <input type="text" id="search" placeholder="Search By Airline">
            <input type="text" id="search" placeholder="Search By status">
            <input type="text" id="search" placeholder="Search By aircraft">
        </div>
        </center>
        <center>
        <div class="w3-container">
            <h2></h2>
            
            <table class="w3-table-all w3-hoverable" id = "table">
                <thead>
                    <tr class="w3-light-grey">
                        <th>Airline</th>
                        <th>Ident</th>
                        <th>Aircraft</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id = "data">
                    <?php
                        $i = 0;
                        $n = count($rows);
                        for ($i = 0; $i < $n; $i++){
                            $flightIcao = $rows[$i]["flightICAO"];
                            $status = $rows[$i]["status"];
                            $reg = $rows[$i]["aircraftRegNumber"];
                            $airlineName = $p->getAirlineName($rows[$i]["airlineIcaoCode"]);
                            $depIcaoCode = $rows[$i]["depIcaoCode"];
                            $arrivalIcaoCode = $rows[$i]["arrivalIcaoCode"];
                            $aircraft = $p->getAircraft($reg);
                            echo "<tr>";
                            echo "<td>{$airlineName}</td>";
                            echo "<td>{$flightIcao}</td>";
                            if ($aircraft){echo "<td>{$aircraft}</td>";}
                            else {echo "<td>   -</td>";}
                            echo "<td>{$status}</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            
            <script>
                $(document).ready(function() {
                    console.log(document.getElementById("search"))
                    $("#search").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#data tr").filter(function() {
                            $(this).toggle($(this).text()
                            .toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>
        </div>
        </center>
    </div>
</body>
</html>

<!-- select flightICAO, Dicao, Aicao, status, airline_name, aIata from flight

select a.flightICAO, a.status, a.airlineIcaoNumber, b.depIcaoCode, a.arrivalIcaoCode from (select * from flight, arrivals where flight.flightIcaoNumber = arrivals.flightICAO) as a, 
(select * from flight, departures where flight.flightIcaoNumber = departures.flightICAO) as b where a.flightICAO = b.flightICAO and b.depIcaoCode = "."\"".$origin."\""." and a.arrivalIcaoCode = "."\"".$destination."\""."".";";



select a.flightICAO, a.status, a.airlineIcaoNumber, b.depIcaoCode, a.arrivalIcaoCode from (select * from flight, arrivals where flight.flightIcaoNumber = arrivals.flightICAO) as a, 
(select * from flight, departures where flight.flightIcaoNumber = departures.flightICAO) as b where a.flightICAO = b.flightICAO and b.depIcaoCode = "KJFK" and a.arrivalIcaoCode = "EGLL";
 -->

