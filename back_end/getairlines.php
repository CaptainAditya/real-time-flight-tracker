<?php
    class Airlines extends MySqlDb{
        protected function getAirlines() {
            $sql = "select * from airlines";
            $result = $this->connect()->query($sql);
            $numRows = $result->num_rows;
            $i = 0;

            while ($i < 2000) {
                $row = $result->fetch_assoc();
                $data[] = $row;
                $i += 1;
            }
            return $data;
        }
    }