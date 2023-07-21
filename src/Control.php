<?php
    class Control
    {
        private mysqli $conn;

        public function __construct(Database $conn)
        {
            $this->conn = $conn->connection();
        }

        // ---------------------- LOGIN -----------------------
        function login(string $user, string $pass)
        {
            $pass = md5($pass);
            
            $sql = "SELECT `id` FROM `admin`
                    WHERE username = '$user' AND `password` = '$pass'";

            $run = $this->conn->query($sql);

            if($run){
                $result = $run->fetch_assoc();
                return $result;
            }
            return false;
        }


        // ------------------- ADD VEHICLE --------------------
        public function getAllPlace()
        {
            $sql = "SELECT * FROM parking_place WHERE `status` = '0'";

            $result = $this->conn->query($sql);
            return $result;
        }

        public function isParked(string $plate): int
        {
            $sql = "SELECT * FROM parking_place WHERE number_plate = '$plate'";

            $result = $this->conn->query($sql);
            return $result->num_rows;
        }
        
        public function addVehicle(string $plate, string $parking):int
        {
            $sql2 = "INSERT INTO vehicle (number_plate, parking_number)
                    VALUES ('$plate', '$parking')";
            
            $sql = "UPDATE parking_place
                    SET number_plate = '$plate', `status` = '1'
                    WHERE parking_number = '$parking'";

            $this->conn->query($sql);
            $this->conn->query($sql2);

            return $this->conn->insert_id;
        }

        public function changePlate(string $plate): string
        {
            $str = strtoupper($plate);
            $str = preg_replace('/[^0-9A-Z]/', '', $str);

            // if(strlen($str) < 7){
            //     $str = preg_replace("/([0-9A-Z]{3})(.+)/", "$1-$2", $str);
            // }else{
            //     $str = preg_replace("/([0-9A-Z]{3})([0-9]{3})(.+)/", "$1-$2.$3", $str);
            // }

            return $str;
        }

        public function viewPlate(string $plate)
        {
            $str = strtoupper($plate);
            $str = preg_replace('/[^0-9A-Z]/', '', $str);

            $str = preg_replace("/([0-9A-Z]{0,3})([0-9]{3})(.+)/", "$1-$2.$3", $str);
            return $str;
        }



        // ---------------------- INCOMING VEHICLE ------------------------
        public function getIncoming()
        {
            $sql = "SELECT * FROM `vehicle` WHERE `status` = '0' ORDER BY `vehicle`.`in_time` DESC";

            $result = $this->conn->query($sql);
            return $result;
        }

        public function getInById(int $id): array
        {
            $sql = "SELECT * FROM `vehicle` WHERE `id` = '$id'";

            $result = $this->conn->query($sql);
            return $result->fetch_array();
        }

        public function isMember(string $plate, bool $isAdd = false): int
        {
            if($isAdd) $checkTime = $this->addMonth(1);
            else $checkTime = $this->addMonth(0);

            $sql = "SELECT * FROM member
                    WHERE number_plate = '$plate' AND `time` = '$checkTime'";
            
            $result = $this->conn->query($sql);
            return $result->num_rows;
        }

        public function qrySearch(string $query)
        {
            $sql = "SELECT * FROM `vehicle`
                    WHERE (`number_plate` LIKE '%$query%' OR `parking_number` LIKE '%$query%')
                    AND `status` = '0' ORDER BY `vehicle`.`in_time` DESC";

            $result = $this->conn->query($sql);
            return $result;
        }

        public function isMemberCheckMoney(string $plate, string $time): int
        {
            $checkTime = $this->addMonth(0);
            $inTime = substr($time,0,7);

            if($checkTime == $inTime){
                $num = $this->isMember($plate);
            }
            else{
                $sql = "SELECT * FROM member
                        WHERE number_plate = '$plate' AND `time` = '$inTime'";
                $run = $this->conn->query($sql);
                $result = $run->num_rows;

                if(! $result) $num = 0;
                else{
                    $var = $this->isMember($plate);
                    if($var) $num = 1;
                    else $num = 2;
                }
            }
            
            return $num;
        }




        // ---------------------- OUTGOING VEHICLE ------------------------
        public function outGoing(int $id, string $parking, string $in, int $isMember)
        {
            $out = date("Y-m-d H:i:s");

            if($isMember == 1) $fee = 0;
            elseif($isMember == 0) $fee = $this->parkingFee0($in, $out);
            else $fee = $this->parkingFee2($in, $out);
            
            $sql = "UPDATE vehicle
                    SET out_time='$out', parking_fee=$fee,`status`='1'
                    WHERE id='$id'";

            $sql2 = "UPDATE `parking_place`
                    SET `number_plate`=NULL,`status`='0'
                    WHERE parking_number = '$parking'";

            $this->conn->query($sql);
            $result = $this->conn->query($sql2);

            return $result;
        }

        public function parkingFee0(string $in, string $out): int
        {
            $getFee = $this->getFee();
            $diff = (strtotime($out) - strtotime($in))/(60*60);

            if($diff <= 2) $fee = $getFee[1];
            elseif($diff <= 24) $fee = $getFee[1] + (floor($diff - 2) + 1)*$getFee[2];
            else $fee = $getFee[1] + 22*$getFee[2] + (floor(($diff - 24)/12) + 1)*$getFee[3];
            
            return $fee;
        }

        public function parkingFee2(string $in, string $out): int
        {
            $inTime = date_create($in);
            $inTime = date_create(date_format($inTime, 'Y-m'));

            $value = date_add($inTime, date_interval_create_from_date_string("1 month"));
            $info = date_format($value,"Y-m-d H:i:s");
            
            $getFee = $this->getFee();
            $diff = (strtotime($out) - strtotime($info))/(60*60);

            if($diff <= 2) $fee = $getFee[1];
            elseif($diff <= 24) $fee = $getFee[1] + (floor($diff - 2) + 1)*$getFee[2];
            else $fee = $getFee[1] + 22*$getFee[2] + (floor(($diff - 24)/12) + 1)*$getFee[3];
            
            return $fee;
        }

        public function getOutgoing(string $varTime)
        {
            $sql = "SELECT * FROM `vehicle`
                    WHERE `status` = '1' AND LEFT(`out_time`,7) = '$varTime'
                    ORDER BY `vehicle`.`out_time` DESC";

            $result = $this->conn->query($sql);
            return $result;
        }

        public function getOutById(int $id): array
        {
            $sql = "SELECT * FROM `vehicle` WHERE `id` = '$id'";

            $result = $this->conn->query($sql);
            return $result->fetch_array();
        }

        // GET MONTH
        public function fieldMonth()
        {
            $sql = "SELECT LEFT(`out_time`,7) FROM `vehicle`
                    WHERE `status` = '1' GROUP BY LEFT(`out_time`,7) DESC";

            $result = $this->conn->query($sql);
            return $result;
        }

        // GET PERIOD OF TIME
        public function dateDiff(string $inTime, string $outTime):string
        {
            $in = date_create($inTime);
            $out = date_create($outTime);

            $diff = date_diff($in, $out);
            $days = $diff->days;

            if($days == 0) $str = $diff->format("%H:%I:%S");
            elseif($days == 1) $str = $diff->format("1 day, %H:%I:%S");
            else $str = $diff->format("%a days, %H:%I:%S");

            return $str;
        }

        // GET MEMBER



        // ------------------------ MEMBER ----------------------------
        public function addMember(string $name, string $plate, string $mobile, string $month, int $fee)
        {
            $first = $this->addMonth(1);
            
            $sql = "INSERT INTO `member`(`owner`, `number_plate`, `mobile`, `time`, `parking_fee`)
                    VALUES ('$name', '$plate', '$mobile', '$first', $fee)";

            $result = $this->conn->query($sql);

            if($month == 3){
                $second = $this->addMonth(2);
                $third = $this->addMonth(3);

                $sql2 = "INSERT INTO `member`(`owner`, `number_plate`, `mobile`, `time`, `parking_fee`)
                        VALUES ('$name', '$plate', '$mobile', '$second', 0)";
                $sql3 = "INSERT INTO `member`(`owner`, `number_plate`, `mobile`, `time`, `parking_fee`)
                        VALUES ('$name', '$plate', '$mobile', '$third', 0)";

                $this->conn->query($sql2);
                $this->conn->query($sql3);
            }
            return $result;
        }

        public function addMonth(int $num): string
        {
            $now = date_create();
            $now = date_create(date_format($now, "Y-m"));
            
            $value = date_add($now, date_interval_create_from_date_string("$num month"));
            return date_format($value,"Y-m");
        }

        public function getMember(string $varTime)
        {
            $sql = "SELECT * FROM member
                    WHERE `time` = '$varTime'
                    ORDER BY regdate DESC";

            $result = $this->conn->query($sql);
            return $result;
        }

        public function fieldMember()
        {
            $sql = "SELECT `time` FROM `member` GROUP BY `time` DESC";
            $result = $this->conn->query($sql);
            return $result;
        }

        function isFullMember(): bool
        {
            $checkTime = $this->addMonth(1);
               
            $sql = "SELECT * FROM `member`
                    WHERE `time` = '$checkTime'";

            $run = $this->conn->query($sql);
            $result = $run->num_rows;
            
            if($result >= 70) return true;
            return false;
        }



        // ------------------------ PARKING LOT ----------------------------
        public function getClass()
        {
            $sql = "SELECT `class` FROM `parking_place` GROUP BY `class`";
            $result = $this->conn->query($sql);

            return $result;
        }
        
        public function getSlot(string $class)
        {
            $sql = "SELECT * FROM `parking_place` WHERE `class` = '$class'";
            $result = $this->conn->query($sql);
            return $result;
        }

        public function getLink(string $parking): int
        {
            $sql = "SELECT * FROM `vehicle` WHERE `parking_number` = '$parking' AND `status` = '0'";
            $run = $this->conn->query($sql);

            $result = $run->fetch_array();
            return $result['id'];
        }

        public function totalSlot(): int
        {
            $sql = "SELECT * FROM `parking_place`";
            $run = $this->conn->query($sql);

            return $run->num_rows;
        }

        public function availableSlot(): int
        {
            $sql = "SELECT * FROM `parking_place` WHERE `status` = '0'";
            $run = $this->conn->query($sql);

            return $run->num_rows;
        }



        // --------------------- DASHBOARD ----------------------
        public function todayEntries(): int
        {
            $sql = "SELECT * FROM `vehicle` WHERE date(`in_time`) = CURRENT_DATE()";
            $result = $this->conn->query($sql);

            return $result->num_rows;
        }

        public function yesterdayEntries(): int
        {
            $sql = "SELECT * FROM `vehicle` WHERE date(`in_time`) = CURRENT_DATE()-1";
            $result = $this->conn->query($sql);

            return $result->num_rows;
        }

        public function last7dayEntries(): int
        {
            $sql = "SELECT * FROM `vehicle`
                    WHERE date(`in_time`) >= (DATE(NOW()) - INTERVAL 7 DAY)";
            $result = $this->conn->query($sql);

            return $result->num_rows;
        }

        public function totalEntries(): int
        {
            $sql = "SELECT * FROM `vehicle`";
            $result = $this->conn->query($sql);

            return $result->num_rows;
        }



        // --------------------- PARKING_FEE ---------------------
        function getFee(): array
        {
            $sql = "SELECT * FROM `parking_fee`
                    ORDER BY `redate` DESC LIMIT 1";

            $result = $this->conn->query($sql);
            return $result->fetch_array();
        }



        // --------------------- PRINT ---------------------
        function getVehicle(string $vid): array
        {
            $sql = "SELECT * FROM `vehicle`
                    WHERE `id` = '$vid'";

            $result = $this->conn->query($sql);
            return $result->fetch_assoc();
        }



        // --------------------- REPORTS ---------------------
        function reportParking(): array
        {
            $sql = "SELECT LEFT(`in_time`,7) AS 'time', SUM(`parking_fee`) AS 'parking_fee' FROM `vehicle`
                    WHERE `status` = '1' GROUP BY LEFT(`in_time`,7)";

            $result = $this->conn->query($sql);

            while($row = $result->fetch_assoc()){
                $value[] = $row;
            }

            return $value;
        }

        function reportMember(): array
        {
            $sql = "SELECT `time`, SUM(`parking_fee`) AS 'member_fee' FROM `member`
                    GROUP BY `time`";

            $result = $this->conn->query($sql);
            
            while($row = $result->fetch_assoc()){
                $value[] = $row;
            }

            return $value;
        }

        function reports(): string
        {
            $park = $this->reportParking();
            $member = $this->reportMember();

            foreach($member as $key => $value){
                if($key < count($park))
                    $member[$key]['parking_fee'] = $park[$key]['parking_fee'];
                else 
                    $member[$key]['parking_fee'] = '0';
            }

            $data = '';
            foreach($member as $key => $value){
                $data .="{ month: '".$value['time']."', member_fee: '".$value['member_fee']."', parking_fee: '".$value['parking_fee']."' }, ";
            }
            $data = substr($data, 0, -2);

            return $data;
        }
    }
?>