<?php
    class viewUser extends Airlines {
        public function showAirlines () {
            $airlines = $this->getAirlines();
            foreach ($airlines as $data){
                echo $data['nameAirline']." ".$data['callsign']."<br>";
            }
        }
    }