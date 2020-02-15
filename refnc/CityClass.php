<?php

class City extends MySQLCN {

    function Add($cityLatLong, $isLimo = '0', $isCharter = '0') {

        if ($_FILES['imgurl']['error'] == '0') {
            $bannerImageName = time() . strtolower(basename($_FILES['imgurl']['name']));
            $target = CITY_IMAGE_ROOT . $bannerImageName;
            move_uploaded_file($_FILES['imgurl']['tmp_name'], $target);
        } else {
            $bannerImageName = '';
        }

        $cityImageName = '';
        if ($_FILES['cityImageUrl']['error'] == '0') {
            $cityImageName = time() . strtolower(basename($_FILES['cityImageUrl']['name']));
            $target = CITY_IMAGE_ROOT . $cityImageName;
            move_uploaded_file($_FILES['cityImageUrl']['tmp_name'], $target);
        }

        $qry = "INSERT INTO `city` 
            ( `cityName`,`state`, `country`, `zip`,`cityType`,`cityLatLong`,`geoLatLong`,`pageTitle`,`pageH1Tag`,`pageBasicInfo`,`pageContent`,`headerPhoneNumber`,`phoneNumberBox`,`cityTitle`,`cityDescription`,`pageJavascript`,`cityImageAltText`,`cityImageCaption`,`cityImageCaptionLink`,`bannerImageName`,`cityImageName`,`isLimo`,`isCharter`) 
            VALUES 
            ( '{$_POST['cityName']}','{$_POST['state']}', '{$_POST['country']}', '{$_POST['zip']}' ,'{$_POST['cityType']}', '{$cityLatLong}','{$_POST['finalGeoLatLong']}','{$_POST['pageTitle']}','{$_POST['pageH1Tag']}','{$_POST['pageBasicInfo']}','{$_POST['pageContent']}','{$_POST['headerPhoneNumber']}','{$_POST['phoneNumberBox']}','{$_POST['cityTitle']}','{$_POST['cityDescription']}','{$_POST['pageJavascript']}','{$_POST['cityImageAltText']}','{$_POST['cityImageCaption']}','{$_POST['cityImageCaptionLink']}','{$bannerImageName}','{$_POST['cityImageName']}','{$isLimo}','{$isCharter}')";

        $res = $this->insert($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'City', 'action' => 'Add', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return $res;
        } else {
            return false;
        }
    }

    function Update($citId, $cityLatLong, $isLimo = '0', $isCharter = '0') {

        if ($_FILES['imgurl']['error'] == '0') {
            $bannerImageName = time() . strtolower(basename($_FILES['imgurl']['name']));
            $target = CITY_IMAGE_ROOT . $bannerImageName;
            move_uploaded_file($_FILES['imgurl']['tmp_name'], $target);
        } else {
            $bannerImageName = $_POST['bannerImage'];
        }

        $cityImageName = '';
        if ($_FILES['cityImageUrl']['error'] == '0') {
            $cityImageName = time() . strtolower(basename($_FILES['cityImageUrl']['name']));
            $target = CITY_IMAGE_ROOT . $cityImageName;
            if (move_uploaded_file($_FILES['cityImageUrl']['tmp_name'], $target)) {
                if (file_exists(CITY_IMAGE_ROOT . $_POST['cityImageName'])) {
                    @unlink(CITY_IMAGE_ROOT . $_POST['cityImageName']);
                }
            } else {
                return false;
            }
        } else {
            $cityImageName = $_POST['cityImageName'];
        }

        $check = $this->GetCity($citId);
        if ($check == NULL) {
            return false;
        }
        $qry = "UPDATE `city` SET
              `cityName` = '{$_POST['cityName']}', 
              `state` = '{$_POST['state']}', 
              `country` = '{$_POST['country']}',
              `zip` = '{$_POST['zip']}',
              `cityType` = '{$_POST['cityType']}',
              `cityLatLong` = '{$cityLatLong}',
              `geoLatLong` = '{$_POST['finalGeoLatLong']}',
              `pageTitle` = '{$_POST['pageTitle']}',
              `pageH1Tag` = '{$_POST['pageH1Tag']}',
              `pageBasicInfo` = '{$_POST['pageBasicInfo']}',
              `pageContent` = '{$_POST['pageContent']}',
              `headerPhoneNumber` = '{$_POST['headerPhoneNumber']}',
              `phoneNumberBox` = '{$_POST['phoneNumberBox']}',
              `cityTitle` = '{$_POST['cityTitle']}',
              `cityDescription` = '{$_POST['cityDescription']}',
              `pageJavascript` = '{$_POST['pageJavascript']}',
              `bannerImageName` = '{$bannerImageName}',
              `cityImageName` = '{$cityImageName}',
              `cityImageAltText` = '{$_POST['cityImageAltText']}',
              `cityImageCaption` = '{$_POST['cityImageCaption']}',
              `cityImageCaptionLink` = '{$_POST['cityImageCaptionLink']}',
              `isLimo` = '{$isLimo}',
              `isCharter` = '{$isCharter}'
               WHERE pkCId = '{$citId}'";
        $res = $this->updateData($qry);
        if ($res) {

            $qry = "UPDATE `city_internal` SET
              `cityName` = '{$_POST['cityName']}' 
               WHERE cityName = '{$_POST['oldCityName']}'";
            $res = $this->updateData($qry);   

            //system log
            $sysLog = array('operation' => 'City', 'action' => 'Update', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return true;
        } else {
            return false;
        }
    }

    function AllGetCity() {
        $fetch = "SELECT distinct city.* FROM `city` order by city.cityName";
        $fetch_city = $this->select($fetch);
        return $fetch_city;
    }

    function GetCity($Id) {
        $fetch = "SELECT * FROM `city` where pkCId ='" . $Id . "' order by 'cityName'";
        $fetch_city = $this->select($fetch);
        return $fetch_city;
    }

    function Delete($pkCId) {
        $qry = "DELETE FROM `city` WHERE pkCId = '{$pkCId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'City', 'action' => 'Delete', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return true;
        } else {
            return false;
        }
    }

    function GetCityVehicle($pkcid) {
        $cityids = array();
        $fetch = "SELECT v.pkVId,v.vehicleName,'selected' as 'selected' FROM vehicle v LEFT JOIN rate r ON v.pkVId=r.fkVId where r.fkCId=$pkcid group by v.pkVId";
        $fetch_city = $this->selectassoc($fetch);
        if (count($fetch_city) > 0) {
            for ($i = 0; $i < count($fetch_city); $i++) {
                $cityids[] = $fetch_city[$i]['pkVId'];
            }
            $cityids = implode(',', $cityids);
        } else {
            $cityids = "''";
        }
        $sqlvehicle = "SELECT v.pkVId,v.vehicleName,'not' as 'selected' FROM vehicle v where v.pkVId NOT IN ($cityids)";
        $fetchvehicle = $this->selectassoc($sqlvehicle);
        return array_merge($fetch_city, $fetchvehicle);
    }

    function AddDestination() {
        $qry = "INSERT INTO `from_to_destinations` 
            (`fromcountry`,`fromstate`,`fkFCId`,`tocountry`,`tostate`, `fkTCId`,`triptype`,`description`,`trip_total`,`fkVId`,`total_distance`) 
            VALUES 
            ('{$_POST['fromcountry']}','{$_POST['fromstate']}','{$_POST['fromcity']}','{$_POST['tocountry']}','{$_POST['tostate']}', '{$_POST['tocity']}' ,'{$_POST['tripType']}','', '0','{$_POST['fkVId']}','{$_POST['final_distance']}')";
        $res = $this->insert($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'City', 'action' => 'Add', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return true;
        } else {
            return false;
        }
    }

    function UpdateDestination() {
        $qry = "UPDATE `from_to_destinations` SET
              `fromcountry` = '{$_POST['fromcountry']}', 
              `fromstate` = '{$_POST['fromstate']}', 
              `fkFCId` = '{$_POST['fromcity']}',
              `tocountry` = '{$_POST['tocountry']}',
              `tostate` = '{$_POST['tostate']}',
              `fkTCId` = '{$_POST['tocity']}',
              `triptype` = '{$_POST['tripType']}',
              `fkVId` = '{$_POST['fkVId']}',
              `total_distance` = '{$_POST['final_distance']}'
               WHERE pkFTDId = '{$_POST['pkftdId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function GetdestinationData($ftdid) {
        $fetch = "SELECT * FROM `from_to_destinations` where pkFTDId ='" . $ftdid . "'";
        $fetch_destination = $this->select($fetch);
        return $fetch_destination;
    }

    function DeleteDestination($destinationid) {
        $qry = "DELETE FROM `from_to_destinations` WHERE pkFTDId = '{$destinationid}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function UpdateField($id, $field, $fieldval) {
        $qry = "UPDATE `city` SET
              `{$field}` = '{$fieldval}'              
               WHERE pkCId = '{$id}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function GetCityParent($pkcid) {
        $cityids = array();
        $fetch = "SELECT c.pkCId,c.cityName,'selected' as 'selected' FROM city c LEFT JOIN city_parent cp ON c.pkCId = cp.fkPCId where cp.fkCId=$pkcid group by c.pkCId order by c.cityName";
        $fetch_city = $this->selectassoc($fetch);
        $cityids[] = $pkcid;
        if (count($fetch_city) > 0) {
            for ($i = 0; $i < count($fetch_city); $i++) {
                $cityids[] = $fetch_city[$i]['pkCId'];
            }
        }
        $cityidsStr = implode(',', $cityids);
        $sqlcity = "SELECT c.pkCId,c.cityName,'not' as 'selected' FROM city c where c.pkCId NOT IN ($cityidsStr) order by c.cityName";
        $fetchCity = $this->selectassoc($sqlcity);
        return array_merge($fetch_city, $fetchCity);
    }

    function AddParentCity($cityid, $parentCityId) {
        $qry = "INSERT INTO `city_parent` (fkCId,fkPCId)
            VALUES 
            ($cityid,$parentCityId)";
        $res = $this->insert($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'Citys Parent', 'action' => 'Add', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return true;
        } else {
            return false;
        }
    }

    function RemoveParentCity($cityid, $parentCityId) {
        $qry = "DELETE FROM `city_parent` WHERE fkCId=$cityid and fkPCId=$parentCityId";
        $res = $this->deleteData($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'Citys Parent', 'action' => 'Delete', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return true;
        } else {
            return false;
        }
    }

    function AddDestinationParentCity($cityForDestination, $cityid, $parentCityId) {
        $qry = "INSERT INTO `city_parent_destination` (cityForDestination,fkCId,fkPCId)
            VALUES 
            ('{$cityForDestination}',$cityid,$parentCityId)";
        $res = $this->insert($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'Citys Parent destination', 'action' => 'Add', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return true;
        } else {
            return false;
        }
    }

    function UpdateDestinationParentCity($cityForDestination, $cityid, $parentCityId) {
        $qry = "UPDATE `city_parent_destination` SET
              `cityForDestination` = '{$cityForDestination}', 
              `fkPCId` = '{$parentCityId}'
               WHERE fkCId = '{$cityid}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function CheckDestinationParentCity($citId) {
        $check = $this->GetDestinationParentCity($citId);
        if ($check == NULL) {
            return false;
        } else {
            return true;
        }
    }

    function GetDestinationParentCity($Id) {
        $fetch = "SELECT * FROM `city_parent_destination` where fkCId ='" . $Id . "'";
        $fetch_city = $this->select($fetch);
        return $fetch_city;
    }

    function GetCitySelectedVehicle($Id) {
        $qry = "SELECT v.pkVId,v.vehicleName FROM vehicle v LEFT JOIN rate r ON v.pkVId=r.fkVId where r.fkCId=$Id group by v.pkVId";
        $resqry = $this->select($qry);
        return $resqry;
    }

    function GetCityDescriptionData($Id) {
        $qry = "SELECT* FROM `cityDescription` WHERE pkCityDId ='{$Id}'";
        $resqry = $this->select($qry);
        return $resqry;
    }

    function addCityDescription() {

        $cityImageName = '';
        if ($_FILES['cityImageUrl']['error'] == '0') {
            $cityImageName = time() . strtolower(basename($_FILES['cityImageUrl']['name']));
            $target = CITY_IMAGE_ROOT . $cityImageName;
            move_uploaded_file($_FILES['cityImageUrl']['tmp_name'], $target);
        }
        
         $qry = "INSERT INTO `cityDescription` 
            ( `fkCityID`,`cityTitle`, `cityDescription`, `cityImageName`, `cityImageAltText`, `cityImageCaption`, `cityImageCaptionLink`, `createdDate`) 
            VALUES 
            ( '{$_POST['fkCId']}','{$_POST['cityTitle']}', '{$_POST['cityDescription']}', '{$cityImageName}', '{$cityImageAltText}', '{$cityImageCaption}', '{$cityImageCaptionLink}', now())";

        $res = $this->insert($qry);
        if ($res) {
            //system log
            $sysLog = array('operation' => 'CityDescription', 'action' => 'Add', 'info' => '', 'by' => $_SESSION['userName']);
            systemLog($sysLog);
            return $res;
        } else {
            return false;
        }
    }

    function UpdateCityDescription() {

        $cityImageName = '';
        if ($_FILES['cityImageUrl']['error'] == '0') {
            $cityImageName = time() . strtolower(basename($_FILES['cityImageUrl']['name']));
            $target = CITY_IMAGE_ROOT . $cityImageName;
            if (move_uploaded_file($_FILES['cityImageUrl']['tmp_name'], $target)) {
                if (file_exists(CITY_IMAGE_ROOT . $_POST['cityImageName'])) {
                    @unlink(CITY_IMAGE_ROOT . $_POST['cityImageName']);
                }
            } else {
                return false;
            }
        } else {
            $cityImageName = $_POST['cityImageName'];
        }

        $qry = "UPDATE `cityDescription` SET
              `fkCityID` = '{$_POST['fkCId']}', 
              `cityTitle` = '{$_POST['cityTitle']}', 
              `cityDescription` = '{$_POST['cityDescription']}',
              `cityImageName` = '{$cityImageName}',
              `cityImageAltText` = '{$_POST['cityImageAltText']}',
              `cityImageCaption` = '{$_POST['cityImageCaption']}',
              `cityImageCaptionLink` = '{$_POST['cityImageCaptionLink']}'
               WHERE pkCityDId = '{$_POST['pkCityDId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function DeleteCityDesciption($pkCityDId) {
        $qry = "DELETE FROM `cityDescription` WHERE `pkCityDId`='{$pkCityDId}'";
        $res = $this->deleteData($qry);
    }

    function GetCityData($id){
          $qry = "SELECT* FROM `cityDescription` WHERE fkCityID ='{$id}'";
        $resqry = $this->select($qry);
        return $resqry;
    }

    /**
     * Function to get state breadcrum url status
     * @param $stateName (state name)
     * @return true or false
     */

    function stateBreadCrumUrl($stateName){
        $qry = "SELECT stateName FROM `state` WHERE stateName ='{$stateName}'";
        $resqry = $this->select($qry);
            if(!empty($resqry) && isset($resqry[0]['stateName'])) {
                $status = true;
            } else {
                $status = false;
            }   
        return $status;
    }

}

?>