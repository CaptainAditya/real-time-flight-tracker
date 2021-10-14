<?php
    class flightInfo extends MySqlDb{
        public returnAllDetails($flightICAO){
            $sql1 = "select * from flight";
            $result1 = $this->connect()->query($sql);
            $i = 0;
            $row;
            while ($row = $result->fetch_assoc()) {
                if ($row['flightIcaoNumber'] == flightICAO) 
                    break;
            }
            //get Airline Name
            $sql2 = "select * from flight, Airlines where airlineIcaoCode = codeIcaoAirline and flightIcaoNumber = " + $flightICAO;
            $result2 = $this->connect()->query($sql2);
            $row2 =  $result2->fetch_assoc();
            $nameAirline = $row2['nameAirline'];
            //airlineICAO
            $airlineIcaoCode = $row['airlineIcaoCode'];
            //airlineIATA
            $airlineIataCode = $row2['codeIataAirline'];
            //departure IATA Code
            $sql3 = "select * from flight, departures where flightIcaoNumber = flightICAO and flightIcaoNumber = " + $flightICAO;
            $result3 = $this->connect()->query($sql3);
            $row3 = $result3->fetch_assoc();
            $depIataCode = $row3['depIataCode'];
            //nameCountry of dep
            $sql4 = "select * from Airports where codeIataAirport = " + $depIataCode;
            $result4 = $this->connect()->query($sql4);
            $row4 = $result4->fetch_assoc();
            $depNameCountry = $row3['nameCountry'];
            //arrival IATA Code
            $sql5 = "select * from flight, arrivals where flightIcaoNumber = flightICAO and flightIcaoNumber = " + $flightICAO;
            $result5 = $this->connect()->query($sql5);
            $row5 = $result5->fetch_assoc();
            $arrivalIataCode = $row3['arrivalIataCode'];
            //nameCountry of arrival
            $sql6 = "select * from Airports where codeIataAirport = " + $arrivalIataCode;
            $result6 = $this->connect()->query($sql6);
            $row6 = $result6->fetch_assoc();
            $arrivalNameCountry = $row6['nameCountry'];
            //Aircraft Registration
            $aircraftRegNumber = $row['aircraftRegNumber'];
            $sql7 = "select * from Airplane where numberRegistration = " + $aircraftRegNumber;
            $result7 = $this->connect()->query($sql7);
            $row7 = $result7->fetch_assoc();
            $airplaneIataType = $row7['airplaneIataType'];
            $engineCount = $row7['engineCount'];
            $enginesType = $row7['enginesType'];
            $planeAge = $row7['planeAge'];
            $productionLine = $row7['productionLine'];
            //Live Status
            $sql8 = "select * from flight, Current_Status where flightICAO = flightIcaoNumber and flightIcaoNumber = " + $flightICAO;
            $result8 = $this->connect()->query($sql8);
            $row8 = $result8->fetch_assoc();
            $altitude = $row8['altitude'];
            $direction = $row8['direction'];
            $horizontalSpeed = $row8['horizontalSpeed'];
            $verticalSpeed = $row8['verticalSpeed'];
            
        }
    }
?>