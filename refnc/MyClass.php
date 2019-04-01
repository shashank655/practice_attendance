<?php

class MyClass extends MySQLCN {

    function GetCountry() {
        $fetch = "SELECT * FROM `country_names` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }

    function GetState($country) {
        $fetchState = "SELECT state_name FROM `states_names` where country_code_char2='{$country}' order by `state_name` asc";
        //echo $fetchState;
        $fetch_State = $this->select($fetchState);
        return $fetch_State;
    }

    function GetStateNew($countryName) {
         $country = '1=1';
        if ($countryName != '')
            $country .= " and country = '{$countryName}'";
        $sql = "SELECT * from `state` where $country order by stateName";
        $result = $this->selectForJason($sql);
        return $result;
    }

    function GetCityVehicle($cityId) {
        $fetch = "SELECT distinct fkVId FROM `rate` where fkCId = '{$cityId}' order by mileageRate";
        //echo $fetch;
        $fetch_cityVehicle = $this->select($fetch);
        return $fetch_cityVehicle;
    }

    function GetVehicle($vehicleIds, $seat, $cityId, $pickupdate) {
        //echo "is ary".is_array($vehicleIds);exit;
//        $fetch = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId in($vehicleIds) AND rate.fkCId = '{$cityId}'  AND vehicle.seats >= {$seat}";
//        $fetch_vehicle = $this->selectassoc($fetch);
//        return $fetch_vehicle;
        $fetch_vehicle = array();
        $fetch_data = array();
        //print_r($vehicleIds);
        if (is_array($vehicleIds)) {
            for ($i = 0; $i < count($vehicleIds); $i++) {
                $fetchspecial = "select vehicle.*,rate.pkRId,rate.fkCId,rate.radiusMiles,rate.hourlyRate,rate.mileageRate,rate.feeRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId='{$vehicleIds[$i]}' AND rate.fkCId = '{$cityId}'  AND vehicle.seats >= '{$seat}' and rate.fromDate < '$pickupdate' And rate.toDate > '$pickupdate' order by rate.rateType limit 1";
                //echo "if fetchspecial:".$fetchdefault;
                //$fetchspecial = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId='{$vehicleIds[$i]}' AND rate.fkCId = '{$cityId}'  AND vehicle.seats >= '{$seat}' and rate.fromDate < '$pickupdate' And rate.toDate > '$pickupdate'";
                $fetch_data = $this->selectForJason($fetchspecial);
//                   echo $fetchspecial;exit;
                //$q = mysql_query($fetchspecial);
//                echo $q;exit;
                //if($q){
                //  $re = mysql_fetch_array($q);
                //print_r($re);exit;
                //}
//                $fetch_data = $this->select($fetchspecial);
                //print_r($re);
                //exit;
                //rate.mileageRate asc
                if (count($fetch_data) > 0) {
                    $fetch_vehicle[] = $fetch_data;
                } else {
                    $fetchdefault = "select vehicle.*,rate.pkRId,rate.fkCId,rate.radiusMiles,rate.hourlyRate,rate.mileageRate,rate.feeRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId='{$vehicleIds[$i]}' AND rate.fkCId = '{$cityId}'  AND vehicle.seats >= '{$seat}' and rate.rateType='3' order by rate.mileageRate asc limit 1";
                    //echo "else fetchResult:".$fetchdefault."\n\n";
                    $fetchdefault_data = $this->selectForJason($fetchdefault);
                    if (count($fetchdefault_data) > 0) {
                        $fetch_vehicle[] = $fetchdefault_data;
                    }
                }
            }
        }

        //$this->aasort($fetch_vehicle, "mileageRate");
        //$fetch_vehicle = array_values($fetch_vehicle);
        //print_r($fetch_vehicle);
        //exit;
        return $fetch_vehicle;
    }

    function GetVehicleQuote($cityId) {
        $fetchdefault = "SELECT vehicle . * FROM rate JOIN vehicle ON rate.fkVId = vehicle.pkVId WHERE rate.fkCId = '{$cityId}'  GROUP BY rate.fkVId";
        $fetchdefault_data = $this->selectForJason($fetchdefault);
        return $fetchdefault_data;
    }

//    function GetCityVehicleRates($vehicleIds, $seat ,$cityId,$pickupdate,$dropdate){
//        //$fetch = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where (vehicle.pkVId in($vehicleIds) AND rate.fkCId = '{$cityId}'  AND vehicle.seats >= {$seat} and ($pickupdate BETWEEN rate.fromDate AND rate.toDate) and ($dropdate BETWEEN rate.fromDate AND rate.toDate) order by rate.type";
//        $fetch="select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId in(1,2,3,4,5,6,7) AND rate.fkCId = '2'  AND vehicle.seats >= 1 order by rate.type";
//        $fetch_vehicle = $this->selectassoc($fetch);
//        return $fetch_vehicle;
//    }

    function GetCityVehicleRates($vehicleIds, $seat, $cityId, $pickupdate, $dropdate) {
        //$fetch = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where (vehicle.pkVId in($vehicleIds) AND rate.fkCId = '{$cityId}'  AND vehicle.seats >= {$seat} and ($pickupdate BETWEEN rate.fromDate AND rate.toDate) and ($dropdate BETWEEN rate.fromDate AND rate.toDate) order by rate.type";           
        $fetch_vehicle = array();
        $fetch_data = array();
        if (is_array($vehicleIds)) {
            for ($i = 0; $i < count($vehicleIds); $i++) {
                $fetchspecial = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId='{$vehicleIds[$i]}' AND rate.fkCId = '2'  AND vehicle.seats >= 1 and rate.fromDate < '$pickupdate' And rate.toDate > '$pickupdate' order by rate.rateType limit 1";
                $fetch_data = $this->selectassoc($fetchspecial);
                if (count($fetch_data) > 0) {
                    $fetch_vehicle[] = $fetch_data;
                } else {
                    $fetchdefault = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where vehicle.pkVId='{$vehicleIds[$i]}' AND rate.fkCId = '2'  AND vehicle.seats >= 1 and rate.rateType='3' limit 1";
                    $fetchdefault_data = $this->selectassoc($fetchdefault);
                    if (count($fetchdefault_data) > 0) {
                        $fetch_vehicle[] = $fetchdefault_data;
                    }
                }
            }
        }
        return $fetch_vehicle;
    }

    function GetVehicleFromCity($seat, $cityId) {
        $fetch = "select vehicle.*,rate.radiusMiles,rate.hourlyRate from `vehicle` JOIN `rate` ON rate.fkVId = vehicle.pkVId  where rate.fkCId = '{$cityId}'  AND vehicle.seats >= {$seat}";
        $fetch_vehicle = $this->selectForJason($fetch);
        return $fetch_vehicle;
    }

    function CheckCity($cityName) {
        $fetch = "SELECT pkCId,cityName,cityType,citylatLong,geoLatLong FROM `city` where  LOWER(cityName)= '{$cityName}'";
        $fetch_cityData = $this->selectForJason($fetch);
        return (count($fetch_cityData) > 0) ? $fetch_cityData[0] : false;
    }

    function getParentCity($subCityId) {
        $fetch = "SELECT city.* , city_parent.fkCId FROM `city_parent` JOIN `city` ON city.pkCId = city_parent.fkCId where  fkPCId = '{$subCityId}' limit 1";
        $fetch_cityData = $this->selectForJason($fetch);
        return (count($fetch_cityData) > 0) ? $fetch_cityData[0] : false;
    }

    function getMapLocation() {
        $fetch = "SELECT * from `city`";
        $fetch_cityData = $this->selectForJason($fetch);
        return $fetch_cityData;
    }

    function getMapLocationMap() {
        $fetch = "SELECT * from `city` WHERE cityName IN ('Denver', 'Miami', 'Washington DC', 'Las Vegas', 'Philadelphia', 'Baltimore', 'Dallas', 'San Diego', 'Tampa', 'San Francisco', 'Ft Worth', 'Charlotte', 'Birmingham', 'Reno', 'Bakersfield', 'Lexington', 'Charleston', 'Augusta', 'Greenville', 'Savannah', 'Phoenix', 'San Antonio', 'Boston', 'Austin', 'New York', 'Houston', 'Orlando', 'Indianapolis', 'Seattle', 'Louisville')";
        $fetch_cityData = $this->selectForJason($fetch);
        return $fetch_cityData;
    }

    function CheckCityVehicle($cityId, $vehId) {
        $fetch = "SELECT * FROM `rate` where fkCId = '{$cityId}' AND fkVId = '{$vehId}' limit 1";
        $fetch_cityData = $this->selectForJason($fetch);
        return $fetch_cityData;
    }

    function CheckNearestCity($citylat, $citylong) {
        $fetchcity = "select pkCId,cityName,cityType,citylatLong,geoLatLong FROM `city`";
        $getcitydata = $this->selectForJason($fetchcity);
        $citydistance = array();
        $i = 0;
        foreach ($getcitydata as $value) {
            $citydata = array();
            $citydata = explode(',', $value['citylatLong']);

            $citydistance[$i]['pkCId'] = $value['pkCId'];
            $citydistance[$i]['cityName'] = $value['cityName'];
            $citydistance[$i]['cityType'] = $value['cityType'];
            $citydistance[$i]['citylatLong'] = $value['citylatLong'];
            $citydistance[$i]['geoLatLong'] = $value['geoLatLong'];
            $citydistance[$i]['distance'] = $this->latlongDistance($citylat, $citylong, (float) $citydata[0], (float) $citydata[1]);
            $i++;
        }
        //sort($citydistance);
        $this->aasort($citydistance, "distance");
        $citydistance = array_values($citydistance);
        //print_r($citydistance);

        return $citydistance[0];
    }

    function latlongDistance($lat1, $lon1, $lat2, $lon2, $miles = false) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = NULL;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }

    function GetRateData($rateId) {
        $fetch = "SELECT * FROM `rate` where pkRId = '{$rateId}' ";
        $fetch_priceData = $this->select($fetch);
        return $fetch_priceData;
    }

    function GetPrice($tripType, $radiusMiles, $hourlyRate, $minHour, $mileageRate, $outMiles, $totalHour, $vehId, $feeRate = '') {
        // echo $radiusMiles."<br>".$hourlyRate."<br>".$minHour."<br>".$mileageRate."<br>".$outMiles."<br>".$vehId;
        // echo $minHour." <minhour TOTAL HOUR= ".$totalHour;exit;
        //$totalHour
        $vehiclelist = array("STRETCH SEDAN", "STRETCH C300", "STRETCH HUMMER", "LUXURY SUV", "LUXURY SHUTLE", "LUXURY BUS");

        $getqry = "select * From `vehicle` where pkVId='{$vehId}'";
        $fetch_vehicle = $this->select($getqry);

        $debugMsg = "";
        $data = array();

        switch ($tripType) {
            case "oneway":
                // $data['outRadiusBase'] = $mileageRate * $outMiles;
                // $data['otherBase'] = $hourlyRate * $minHour;
                $totalPrice = number_format(($hourlyRate * $minHour) + ($mileageRate * $outMiles), 2, '.', '');
                $debugMsg = "hourlyRate = $hourlyRate <br/> minHour = $minHour <br/>mileageRate = $mileageRate <br/>outMiles = $outMiles <br/>";
                $debugMsg = $debugMsg . "equation = ((hourlyRate * minHour) + (mileageRate * outMiles))  = " . $totalPrice;
                break;
            case "roundtrip":
                //   $data['outRadiusBase'] = ($mileageRate * $outMiles) * 2;
                //   $data['otherBase'] = ($hourlyRate * $minHour) * 2;
                $finaltotal = ceil($totalHour);
                $debugMsg = "hourlyRate = $hourlyRate <br/>minHour = $minHour <br/>mileageRate = $mileageRate <br/>outMiles = $outMiles <br/>totalHour = $totalHour<br/>";
                //if (in_array($fetch_vehicle[0]['vehicleName'], $vehiclelist)) {
                $debugMsg = $debugMsg . "found vehicle in special case<br/>";
                if ($finaltotal <= $minHour) {
                    $totalPrice = number_format((($hourlyRate * $minHour) + ($mileageRate * $outMiles)), 2, '.', '');
                    $debugMsg = $debugMsg . "equation = (((hourlyRate * minHour) + (mileageRate * outMiles)) * 2) = " . $totalPrice;
                } else if ($finaltotal <= ($minHour * 2)) {
                    $totalPrice = number_format((($hourlyRate * $finaltotal) + ($mileageRate * $outMiles)), 2, '.', '');
                    $debugMsg = $debugMsg . "equation = (hourlyRate * totalHour) + (mileageRate * outMiles) = " . $totalPrice;
                } else {
                    $totalPrice = number_format(((($hourlyRate * $minHour) + ($mileageRate * $outMiles)) * 2), 2, '.', '');
                    $debugMsg = $debugMsg . "equation = (((hourlyRate * minHour) + (mileageRate * outMiles)) * 2) = " . $totalPrice;
                }
                /* } else { */
                //$totalPrice = number_format(((($hourlyRate * $minHour) + ($mileageRate * $outMiles)) * 2), 2, '.', '');
                //$debugMsg = $debugMsg . "equation = (((hourlyRate * minHour) + (mileageRate * outMiles))* 2) = " . $totalPrice;
                //}                                
                break;
            case "hourly":
                $hourCount = $minHour;
                if ($totalHour > $minHour)
                    $hourCount+= ceil($totalHour) - $minHour;
//                echo $minHour." minhour TOTAL HOUR= ".$totalHour;
//                echo "  TOTAL HOUR count= ".$hourCount;exit;
                //  $data['outRadiusBase'] = $mileageRate * $outMiles;
                //   $data['otherBase'] = $hourlyRate * $hourCount;
                $totalPrice = number_format(($hourlyRate * $hourCount) + ($mileageRate * $outMiles), 2, '.', '');
                $debugMsg = "hourlyRate = $hourlyRate <br/>totalHour = $hourCount <br/>mileageRate = $mileageRate <br/>outMiles = $outMiles <br/>";
                $debugMsg = $debugMsg . "equation = ((hourlyRate * totalHour) + (mileageRate * outMiles)) = " . $totalPrice;
                break;
            default:
                $totalPrice = number_format(0, 2);
        }

        $data['basePrice'] = $totalPrice;
        $data['taxFees'] = number_format((($totalPrice * ($feeRate / 100))), 2, '.', '');
        $data['totalPrice'] = $data['basePrice'] + $data['taxFees'];
        $data['debugMsg'] = $debugMsg;

        return $data;
    }

    function GetManualData($key) {
        $sql = "SELECT * from `manual_quote` as mq left join `vehicle` as v on mq.fkVId = v.pkVId left join `customer_info` as ci on mq.fkCId = ci.pkCId where `emailKey` = '{$key}'";
        $result = $this->selectForJason($sql);
        return $result;
    }

    //multi trip
    function GetMultipleManualData($key) {
        $sql = "SELECT * from `manual_journey_quote` as mjq left join `vehicle` as v on mjq.fkVId = v.pkVId left join `manual_journey` as mj on mjq.fkMJId = mj.pkMJId where `emailKey` = '{$key}'";
        $result = $this->selectForJason($sql);
        return $result;
    }

    function UpdateMultipleManualJourneyCount($pkMJQId, $journeyCount) {
        $sql = "UPDATE manual_journey_quote SET `countJourney` = '{$journeyCount}' WHERE pkMJQId = '{$pkMJQId}'";
        $result = $this->updateData($sql);
        return $result;
    }

    function GetProviderData($key) {
        $sql = "SELECT * from `provider` where `documentKey` = '{$key}'";
        $result = $this->selectForJason($sql);
        return $result;
    }

    function GetReservationData($key) {
        $sql = "SELECT * from `reservation` as res left join `trip` as trip on res.fkTripId = trip.pkTId left join `reservetripprovider` as rtp on res.fkRTPro = rtp.pkRTPro where md5(res.fkTripId) = '{$key}'";
        $result = $this->selectForJason($sql);
        return $result;
    }

    function GetStateWiseCity($statename = '') {
        $states = '1=1';
        if ($statename != '')
            $states .= " and state = '{$statename}'";
        $sql = "SELECT * from `city` where $states and isCharter = '1' order by cityName";
        $result = $this->selectForJason($sql);
        return $result;
    }

    function GetCityChild($cityname = '') {
        $city = '1=1';
        if ($cityname != '')
            $city .= " and cityName = '{$cityname}'";
        $sql = "SELECT * from `city_internal` where $city order by cityInternalName";
        $result = $this->selectForJason($sql);
        return $result;
    }

    function GetStateWiseSpecialAcross($country, $statename, $cityid = '') {
        $wherecity = "";
        if ($cityid != '') {
            $wherecity = " and ftd.fkFCId=$cityid";
        }
        //$sql1 = "SELECT ftd.*,sn.state_code from `from_to_destinations` ftd,states_names sn where ftd.fromstate=sn.state_name and ftd.fromstate = '{$statename}'";
        $sql = "select ftd.*,
                (select state_code from states_names where state_name=ftd.fromstate and country_code_char2 = '{$country}') as fstate,
                (select state_code from states_names where state_name=ftd.tostate and country_code_char2 = '{$country}') as tstate,
                (select cityName from city where pkCId=ftd.fkFCId) as fcity,
                (select cityName from city where pkCId=ftd.fkTCId) as tcity
                from `from_to_destinations` ftd where ftd.fromstate = '{$statename}'" . $wherecity . " order by tcity";
        //echo $sql;
        //exit;
                $result = $this->selectForJason($sql);
        
        for ($index = 0; $index < count($result); $index++) {

            $ParentChildSpacialCity = $this->ParentChildSpacialCity($result[$index]["fkFCId"]);
            if ($ParentChildSpacialCity) {
                $result[$index]['parentCityData'] = $ParentChildSpacialCity[0];
            } else {
                $result[$index]['parentCityData'] = array();
            }
        }
        
        return $result;
    }

    function GetStateWiseSpecialAcross_State($country, $stateId = '') {
        $wherestate = "";
        if ($stateId != '') {
            $wherestate = " and ftd.fkFSId=$stateId";
        }
        //$sql1 = "SELECT ftd.*,sn.state_code from `from_to_destinations` ftd,states_names sn where ftd.fromstate=sn.state_name and ftd.fromstate = '{$statename}'";
        $sql = "select ftd.*,
                (select stateName from state where pkSId=ftd.fkFSId) as fstate,
                (select stateName from state where pkSId=ftd.fkTSId) as tstate
                from `state_from_to_destinations` ftd where ftd.fromcountry = '{$country}'" . $wherestate . " order by tstate";
                $result = $this->selectForJason($sql);
        
        for ($index = 0; $index < count($result); $index++) {

           
                $result[$index]['parentCityData'] = array();
            
        }
        return $result;
    }

    function GetPopularDestinationRate($citId, $vehId) {
        $fetch = "SELECT rate.* FROM `rate` where rate.rateType = '3' AND rate.fkVId ='" . $vehId . "' AND rate.fkCId ='" . $citId . "' ";
        $fetch_rate = $this->selectForJason($fetch);
        return $fetch_rate;
    }

    function GetStatePopularDestinationRate($stateId, $vehId) {
        $fetch = "SELECT rate_states.* FROM `rate_states` where rate_states.rateType = '3' AND rate_states.fkVId ='" . $vehId . "' AND rate_states.fkSId ='" . $stateId . "' ";
        $fetch_rate = $this->selectForJason($fetch);
        return $fetch_rate;
    }

    function ParentChildSpacialCity($stateId) {
        $fetch = "SELECT city.cityName, city.state, city.country FROM `city_parent_destination` JOIN `city` ON city.pkCId = city_parent_destination.fkPCId where city_parent_destination.fkCId ='" . $stateId . "' AND city_parent_destination.cityForDestination ='subCity' ";
        $fetch_rate = $this->selectForJason($fetch);
        return $fetch_rate;
    }

    function GetPageReview($pageId, $reviewType) {
        $sqlcityreview = "select * from review where reviewType='{$reviewType}' and  isApproved='1' and fkPageId='{$pageId}'";
        $result = $this->selectForJason($sqlcityreview);
        return $result;
    }

    function GetCityEvent($state, $cityId = '') {
        $wherecity = "";
        if ($cityId != '') {
            $wherecity = " and fkCId='{$cityId}'";
        }
        //next 30 days events
        $sqlcityEvent = "select * from events where eventDate BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY  and state='{$state}'" . $wherecity . ' ORDER BY eventDate';
        $result = $this->selectForJason($sqlcityEvent);
        return $result;
    }

    function GetCityNewsLimo($cityId = '') {
        $sqlcityThing = "select * from news where fkCId='{$cityId}' AND newsDate BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY AND cityType = 'limo' ORDER BY newsDate";
        $result = $this->selectForJason($sqlcityThing);
        return $result;
    }

    function GetCityNewsCharter($cityId = '') {
        $sqlcityThing = "select * from news where fkCId='{$cityId}' AND newsDate BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY AND cityType = 'charter' ORDER BY newsDate";
        $result = $this->selectForJason($sqlcityThing);
        return $result;
    }

    function GetCityThingToDo($cityId) {
        $sqlcityThing = "select * from things_do_city where fkCId='{$cityId}'";
        $result = $this->selectForJason($sqlcityThing);
        return $result;
    }

    function GetCityRateList($vehicleType, $state, $cityId = '') {
        $wherecity = "";
        if ($cityId != '') {
            $wherecity = " and rate.fkCId=$cityId";
        }
//       $sqlrate = "select rate.* ,city.state,vehicle.vehicleName, vehicle.imageName, fleet.description as vehicleDescription  from rate 
//                    join fleet on rate.fkVId = fleet.fkVId
//                    join city on rate.fkCId = city.pkCId
//                    join vehicle on rate.fkVId = vehicle.pkVId 
//                    where city.state='{$state}' and vehicle.vehicleType = '{$vehicleType}' $wherecity
//                    group by vehicle.pkVId order by  rate.fkVId , rate.fromDate ASC";

        $sqlrate = "select rate.* ,city.state,city.cityType,city.citylatLong,city.geoLatLong,vehicle.vehicleName,vehicle.seats,vehicle.bags, vehicle.imageName, fleet.description as vehicleDescription, 
                (select rate.hourlyRate from rate where rate.fkVId = vehicle.pkVId AND rate.fkCId = city.pkCId order by rate.rateType limit 1) as newYearRate,
                (select rate.crossState from rate where rate.fkVId = vehicle.pkVId AND rate.fkCId = city.pkCId  AND rate.rateType='3' order by rate.rateType limit 1) as crossStateAvailable,
                (select concat('$',MIN(rate.hourlyRate),' - $',MAX(rate.hourlyRate)) from rate where rate.fkVId = vehicle.pkVId AND rate.fkCId = city.pkCId order by rate.rateType limit 1) as minMaxHour
                from rate 
                join fleet on rate.fkVId = fleet.fkVId
                join city on rate.fkCId = city.pkCId
                join vehicle on rate.fkVId = vehicle.pkVId 
                where city.state='{$state}' and vehicle.vehicleType = '{$vehicleType}' $wherecity
                group by vehicle.pkVId order by  vehicle.seats DESC, rate.fromDate ASC";
                //echo $sqlrate ;exit;
        $result = $this->selectForJason($sqlrate);
        return $result;
    }

    function GetCityChildRateList($vehicleType, $cityname, $citychildId = '') {
        $wherecity = "";
        if ($citychildId != '') {
            $wherecity = " and rate_city_child.fkCCId=$citychildId";
        }


        $sqlrate = "select rate_city_child.* ,city_internal.cityInternalName,city_internal.citylatLong,vehicle.vehicleName,vehicle.seats,vehicle.bags, vehicle.imageName, fleet.description as vehicleDescription, 
                (select rate_city_child.hourlyRate from rate_city_child where rate_city_child.fkVId = vehicle.pkVId AND rate_city_child.fkCCId = city_internal.pkCIId order by rate_city_child.rateType limit 1) as newYearRate,
                (select rate_city_child.crossState from rate_city_child where rate_city_child.fkVId = vehicle.pkVId AND rate_city_child.fkCCId = city_internal.pkCIId  AND rate_city_child.rateType='3' order by rate_city_child.rateType limit 1) as crossStateAvailable,
                (select concat('$',MIN(rate_city_child.hourlyRate),' - $',MAX(rate_city_child.hourlyRate)) from rate_city_child where rate_city_child.fkVId = vehicle.pkVId AND rate_city_child.fkCCId = city_internal.pkCIId order by rate_city_child.rateType limit 1) as minMaxHour
                from rate_city_child 
                join fleet on rate_city_child.fkVId = fleet.fkVId
                join city_internal on rate_city_child.fkCCId = city_internal.pkCIId
                join vehicle on rate_city_child.fkVId = vehicle.pkVId 
                where city_internal.cityName='{$cityname}' and vehicle.vehicleType = '{$vehicleType}' $wherecity
                group by vehicle.pkVId order by  vehicle.seats DESC, rate_city_child.fromDate ASC";
        $result = $this->selectForJason($sqlrate);
        return $result;
    }

    function GetStateRateList($vehicleType,$country,$stateId = ''){
        $wherecity = "";
        if ($stateId != '') {
            $wherestate = " and rate_states.fkSId=$stateId";
        }
        $sqlrate = "select rate_states.* ,state.stateName,state.statelatLong,vehicle.vehicleName,vehicle.seats,vehicle.bags, vehicle.imageName, fleet.description as vehicleDescription, 
                (select rate_states.hourlyRate from rate_states where rate_states.fkVId = vehicle.pkVId AND rate_states.fkSId = state.pkSId order by rate_states.rateType limit 1) as newYearRate,
                (select rate_states.crossState from rate_states where rate_states.fkVId = vehicle.pkVId AND rate_states.fkSId = state.pkSId  AND rate_states.rateType='3' order by rate_states.rateType limit 1) as crossStateAvailable,
                (select concat('$',MIN(rate_states.hourlyRate),' - $',MAX(rate_states.hourlyRate)) from rate_states where rate_states.fkVId = vehicle.pkVId AND rate_states.fkSId = state.pkSId order by rate_states.rateType limit 1) as minMaxHour
                from rate_states 
                join fleet on rate_states.fkVId = fleet.fkVId
                join state on rate_states.fkSId = state.pkSId
                join vehicle on rate_states.fkVId = vehicle.pkVId 
                where state.country='{$country}' and vehicle.vehicleType = '{$vehicleType}' $wherestate
                group by vehicle.pkVId order by  vehicle.seats DESC, rate_states.fromDate ASC";
                //echo $sqlrate ;exit;
        $result = $this->selectForJason($sqlrate);
        return $result;
    }


    function GetVehicleSlider() {
        $sqlslider = "select vehicle.pkVId , vehicle.bags , vehicle.seats , vehicle.vehicleName, vehicle.imageName, fleet.description as vehicleDescription  from vehicle 
                join fleet on vehicle.pkVId = fleet.fkVId
                order by  vehicle.seats DESC";

        $result = $this->selectForJason($sqlslider);
        return $result;
    }

    function GetCityStateVehicleSlider($vehicleType, $state, $cityId = '') {
        $wherecity = "";
        if ($cityId != '') {
            $wherecity = " and rate.fkCId=$cityId";
        }
        $sqlslider = "select city.state,vehicle.vehicleType, vehicle.seats ,vehicle.vehicleName,vehicle.imageNameCrop, vehicle.imageName,fleet.interiorImage, fleet.description as vehicleDescription  from rate 
                    join fleet on rate.fkVId = fleet.fkVId
                    join city on rate.fkCId = city.pkCId
                    join vehicle on rate.fkVId = vehicle.pkVId 
                    where city.state='{$state}' and vehicle.vehicleType = '{$vehicleType}' $wherecity
                    group by vehicle.pkVId order by  vehicle.seats DESC";
        $result = $this->selectForJason($sqlslider);
        return $result;
    }

    function GetCountryWiseState($countries = "'US','CA'") {
        $fetchState = "SELECT state_name,country_code_char2 FROM `states_names` where country_code_char2 in ({$countries}) order by `state_name` asc";
        $fetch_State = $this->select($fetchState);
        return $fetch_State;
    }

    function getAllCity() {
        $fetchCity = "SELECT cityName FROM `city_internal` group by cityName order by `cityName` asc";
        $fetch_city = $this->select($fetchCity);
        return $fetch_city;
    }

    //Get pages content from page_content table link up to pages table
    function GetPageContent($pageId) {
        $sqlcityThing = "select * from page_content where pageId='{$pageId}'";
        $result = $this->selectForJason($sqlcityThing);
        return $result;
    }

    //Set and get session state for filter data listing in cms
    function SetMyState() {
        $_SESSION['myState'] = $_POST['myState'];

        return $_SESSION['myState'];
    }

    function GetMyState() {
        $myState = '';

        if (isset($_SESSION['myState']))
            $myState = $_SESSION['myState'];

        return $myState;
    }

    function getConfigField($fieldname) {
        $qry = "select * from configurations where config_name='$fieldname'";
        $res = $this->selectForJason($qry);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    function getUserList() {
        $qry = "select * from user where userAccess LIKE '%trip.php%' OR userType='super'";
        $res = $this->selectForJason($qry);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    function printArray($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
    
    function addQuoteIpAddress($quoteIds , $ipAddress){
        $accessDate = date('Y-m-d H:i:s');
        foreach($quoteIds as $key => $values){
            $quoteId = $values['quoteId'];
            $quoteFrom = $values['quoteFrom'];
            $check = $this->checkQuoteIpAddress($quoteId, $ipAddress);
            if ($check == NULL) {
                //insert iP
                $qry = "INSERT INTO `quoteIpTrack` 
                ( `fkMQMJQId`,`clientIpAddress`, `quoteFrom`, `lastAccessDateTime`) 
                VALUES 
                ( '{$quoteId}','{$ipAddress}', '{$quoteFrom}', '{$accessDate}')";
                $this->insert($qry);
            }else{
                //update Ip
                $pkQITId = $check[0]['pkQITId'];
                $this->updateQuoteIpAddress($pkQITId, $accessDate);
            }
        }
    } 
    
    function updateQuoteIpAddress($pkQITId , $accessDate){
       $qry = "UPDATE quoteIpTrack SET
              `lastAccessDateTime` = '{$accessDate}'
               WHERE pkQITId = '{$pkQITId}'";
        $res = $this->updateData($qry);
    }
    
    function checkQuoteIpAddress($quoteId , $ipAddress){
        $fetch = "SELECT pkQITId FROM  quoteIpTrack where fkMQMJQId ='" . $quoteId . "' AND clientIpAddress ='" . $ipAddress . "'";
        $fetch_quoteIp = $this->selectForJason($fetch);
        return $fetch_quoteIp;
        
    }
    
   function getQuoteIpAddress($quoteId , $quoteFrom){
        $fetch = "SELECT * FROM  quoteIpTrack where fkMQMJQId ='" . $quoteId . "' AND quoteFrom ='" . $quoteFrom . "' ORDER BY lastAccessDateTime ASC";
        $fetch_quoteIp = $this->selectForJason($fetch);
        return $fetch_quoteIp;
        
    } 
    
    function GetAttractData($cityId) {
        $sqlattractque = "select * from attraction_in_city where fkCityId='{$cityId}'";
        $resultData = $this->selectForJason($sqlattractque);
        return $resultData;
    }

    function GetStateAttractData($stateId) {
        $sqlattractque = "select * from attraction_in_state where fkStateId='{$stateId}'";
        $resultData = $this->selectForJason($sqlattractque);
        return $resultData;
    }

    function GetCityChildAttractData($cityId) {
        $sqlattractque = "select * from attraction_in_city_child where fkCityCId='{$cityId}'";
        $resultData = $this->selectForJason($sqlattractque);
        return $resultData;
    }
    
    function GetHCardData($pageId) {
        $sqlattractque = "select * from h_card_avaibility where fkCityID='{$pageId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetGroupTravelData($cityId) {
        $sqlattractque = "select * from more_about_group_travel where fkCityId='{$cityId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetStateGroupTravelData($stateId) {
        $sqlattractque = "select * from state_more_about_group_travel where fkStateId='{$stateId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetHelpfulResourcesData($cityId) {
        $sqlattractque = "select * from helpful_resources where fkCityId='{$cityId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetStateHelpfulResourcesData($stateId) {
        $sqlattractque = "select * from state_helpful_resources where fkStateId='{$stateId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetpopularNearByCityData($cityId) {
        $sqlattractque = "select * from popular_near_by_cities where fkCityId='{$cityId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetStatepopularNearByCityData($stateId) {
        $sqlattractque = "select * from state_popular_near_by_cities where fkStateId='{$stateId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetserviceSliderData($cityId) {
        $sqlattractque = "select * from services_slider where fkCityId='{$cityId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetStateserviceSliderData($stateId) {
        $sqlattractque = "select * from state_services_slider where fkStateId='{$stateId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetStateHCardData($pageId) {
        $sqlattractque = "select * from h_card_avaibility_state where fkStateID='{$pageId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }
   
    function GetfollowSectionData($cityId) {
        $sqlattractque = "select * from follow_us_section where fkCityId='{$cityId}'";
        $resultDataDisp = $this->selectForJason($sqlattractque);
        return $resultDataDisp;
    }

    function GetexpandMenuData($cityId) {
        $sql = "select * from expand_menu where fkCityId='{$cityId}'";
        $resultDataDisp = $this->selectForJason($sql);
        return $resultDataDisp;
    }
    
    function GetSliderImages(){
        $fetch="select * from imageUploadHome order by pkImageID desc LIMIT 0,3";
        $resultData=$this->selectForJason($fetch);
        return $resultData;
    }
    
    function GetPopularDestinationRateForCalculation($citId, $vehId){
        $fetch = "SELECT rate_for_calculation.* FROM `rate_for_calculation` where  rate_for_calculation.fkVId ='" . $vehId . "' AND rate_for_calculation.fkCId ='" . $citId . "' ";
        $fetch_rate = $this->selectForJason($fetch);
        return $fetch_rate;
    }
    
    function getAllBlogList(){
        $qry = "select * from  blog";
        $result = $this->selectForJason($qry);
        return $result;
    }
    
    function getTotalTripAmount($city_id,$vehicleId,$totalDistanceMiles){
        $fetch = "SELECT rate.* FROM `rate` where rate.rateType = '3' AND rate.fkVId ='" . $vehicleId . "' AND rate.fkCId ='" . $city_id . "' ";
        $specialacrossstateRate = $this->selectForJason($fetch);

        if($specialacrossstateRate){
            $dayRate = $specialacrossstateRate[0]['dayRate'];
            $mileageRate  =  $specialacrossstateRate[0]['mileageRate'];
            $totalPrice = floor($mileageRate * ($totalDistanceMiles  * 2));

            if($totalDistanceMiles > 650)
                $totalPrice = floor(($totalPrice * 1.1)); 

            $finalPrice = $totalPrice;
        }
        else{
            $finalPrice = 0;
        }

       return $finalPrice;

    }

    function getTotalTripAmountStates($state_id,$vehicleId,$totalDistanceMiles){
        $fetch = "SELECT rate_states.* FROM `rate_states` where rate_states.rateType = '3' AND rate_states.fkVId ='" . $vehicleId . "' AND rate_states.fkSId ='" . $state_id . "' ";
        $specialacrossstateRate = $this->selectForJason($fetch);

        if($specialacrossstateRate){
            $dayRate = $specialacrossstateRate[0]['dayRate'];
            $mileageRate  =  $specialacrossstateRate[0]['mileageRate'];
            $totalPrice = floor($mileageRate * ($totalDistanceMiles  * 2));

            if($totalDistanceMiles > 650)
                $totalPrice = floor(($totalPrice * 1.1)); 

            $finalPrice = $totalPrice;
        }
        else{
            $finalPrice = 0;
        }

       return $finalPrice;

    }
 
    /**
     *  Function to get state and city list data
     * @return array of stateListOne
    */

    function getStateAndCityList() {
    $fetch = "SELECT state FROM `city` where isCharter='1' group by state order by state ASC ";
    $stateListOne = $this->selectForJason($fetch);
    foreach ($stateListOne as $key => $value) {
        $stateList[$key] = $value['state'];
    }

    $fetch2 = "SELECT stateName FROM `state` group by stateName order by stateName ASC";
    $stateListTwo = $this->selectForJason($fetch2);
    foreach ($stateListTwo as $key1 => $value1) {
        $get_key = array_search($value1['stateName'], $stateList);

        if (isset($get_key) && !empty($get_key)) {
            $stateListOne[$get_key]['link'] = 'yes';
        } else {
            $temp = array();
            $temp['state'] = $value1['stateName'];
            $temp['link'] = 'yes';
            $stateListOne[] = $temp;
        }
    }
    function method1($a,$b) {
      return ($a["state"] <= $b["state"]) ? -1 : 1;
    }
    usort($stateListOne, "method1");
    foreach ($stateListOne as $key2 => $value2) {
        $fetch_city = "SELECT cityName , state FROM `city` where state='" . $value2['state'] . "' and isCharter='1' order by cityName ASC";
        $getCityList = $this->selectForJason($fetch_city);
        $stateListOne[$key2]['cities'] = $getCityList;
    }
    return $stateListOne;
    }

    /**
     *  Function to get all events listing
     * @return array of output
    */

    function getAllEventsListing(){
        $fetch="select city.cityName,cityId,eventName,eventPageUrl from event_pages left join city on city.pkCId =  event_pages.cityId order by eventName";
        $resultData=$this->selectForJason($fetch);
        return $resultData;
    }
    /**
     *  Function to get reseller rating API data
     * @return array of output
    */

    function GetResellerRatingData(){
      /* to get access token */
      $url = "https://api.resellerratings.com/oauth/access_token";
        $params = array(
          'grant_type' => 'client_credentials',
          'client_id' => RESELLER_RATING_CLIENT_ID,
          'client_secret' => RESELLER_RATING_CLIENT_SECRET 
        );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close ($ch);
      $res = json_decode($response, true);
      $output = array();
      /* to get access token */
      if(!empty($res['access_token']) && $res['token_type'] == 'Bearer'){
      /* to get reseller rating data with the help of access_token */
          $url1 = "https://api.resellerratings.com/v1/seller/98673"; // seller ID
          $header = array();
          $header[] = 'Content-length: 0';
          $header[] = 'Content-type: application/json';
          $header[] = 'Authorization: Bearer '.$res['access_token'];
          $ch1 = curl_init();
          curl_setopt($ch1, CURLOPT_URL, $url1);
          curl_setopt($ch1, CURLOPT_HTTPHEADER, $header);
          curl_setopt($ch1, CURLOPT_POST, 0); //1 for POST data
          curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
          $response1 = curl_exec($ch1);
          curl_close ($ch1);
          $res1 = json_decode($response1, true);
          if(!empty($res1['data']['id'])){
            $output['success'] = true;
            $output['message'] = "records found.";
            $output['data'] = $res1['data'];
          } else {
            $output['success'] = false;
            $output['message'] = "no records found.";
          }
      /* to get reseller rating data with the help of access_token */
      } else {
          $output['success'] = false;
          $output['message'] = "no records found.";
      }
        return $output;
    }
}

?>