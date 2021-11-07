<?php 
    include("db_connect.php");
    class search extends MySqlDb{
        public function getPopularFlight(){
            $sql = "select * from flight, airplane where flight.aircraftRegNumber = airplane.numberRegistration";
            $result1 = $this->connect()->query($sql);
            $rows = array();
            while ($row = $result1->fetch_assoc()) {
                array_push($rows, $row);
            }
            return $rows;
        }   
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/search1.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

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
    <div class="form-style-10">
        <h1>Search By Anything!</h1>

        <form class="searchbox1" action="route.php">
            <label><input type="text" placeholder="Origin" name="origin"/></label> 
            <label><input type="text" placeholder="Destination" name = "destination" /></label> 
            <div class="button-section">
                <input type="submit" value="Search"></input>
            </div>
        </form>
        <h4 style="text-align: center; color:darkred">OR</h4>
        <form class="searchbox" action="flight-info.php">
            <label><input type="search" placeholder="Search by Flight #:" name = "flightICAO"/></label>
            <div class="button-section">
                <input type="submit" value="Search"></input>
            </div>
        </form>
        <h4 style="text-align: center; color:darkred">OR</h4>
        <form class="searchbox" action="airport.php">
            <label><input type="search" placeholder="Search by Airport:" name = 'airportICAO'/></label>
            <div class="button-section">
                <input type="submit" value="Search"></input>
            </div>
        </form>
    </div>
    <div class="w3-container">
            <h2>Suggestions</h2>
            
            <table class="w3-table-all w3-hoverable" id = "table">
                <thead>
                    <tr class="w3-light-grey">
                        <th>Flight Number</th>
                    </tr>
                </thead>
                <tbody id = "data">
                    <?php
                        $obj = new search;
                        $rows = $obj->getPopularFlight();
                        $i = 0;
                        $n = count($rows);
                        for ($i = 0; $i < 10; $i++){
                            $flightIcao = $rows[$i]["flightIcaoNumber"];
                            echo "<tr>";
                            echo "<td>{$flightIcao}</td>";
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
    
    
</body>
</html> 
