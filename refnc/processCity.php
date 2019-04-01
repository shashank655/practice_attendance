<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once "../class/City.php";
require_once "../class/MyClass.php";
require_once '../class/Pages.php';
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
$city = new City();
$pages = new Pages();
if ($_POST['type'] == 'Add' && $_POST['cityName'] != NULL) {
    //print_r($_POST);exit;
    $isLimo = (isset($_POST['isLimo'])) ? '1':'0';
    $isCharter = (isset($_POST['isCharter'])) ? '1':'0';
    $cityFullName = $_POST['cityName'].','.$_POST['state'].','.$_POST['country'];
    $cityLatLong = findCityLatLong($cityFullName);
    $res = $city->Add($cityLatLong,$isLimo,$isCharter);
    if($res){
        //entry to parent city destination
        $cityForDestination = $_POST['cityForDestination'];
        $cityid = $res;
        $parentCityId = $_POST['fkPCId'];
        $city = $city->AddDestinationParentCity($cityForDestination,$cityid, $parentCityId);
        //add url entry to pages
        if($isLimo == '1'){
        $dataCity = array(
                'pageName'=> strtolower(preg_replace('/\s+/', '-', trim($_POST['cityName']))).'-limo',
                'pageType'=>'limopage',
                'fileName'=>'limo.php'
            );
        $pageRes = $pages->add($dataCity);
        }
        if($isCharter == '1'){
            //'pageName'=> 'charter-bus/'.strtolower(preg_replace('/\s+/', '-', trim($_POST['state']))).'/'.strtolower(preg_replace('/\s+/', '-', trim($_POST['cityName']))),
            $dataState = array(
                'pageName'=> strtolower(preg_replace('/\s+/', '-', trim($_POST['state']))),
                'pageType'=>'statepage',
                'fileName'=>'state.php'
            );
        $pageRes = $pages->add($dataState);
        
        $dataCharter = array(
                'pageName'=> strtolower(preg_replace('/\s+/', '-', trim($_POST['cityName']))).'-charter-bus',
                'pageType'=>'charterpage',
                'fileName'=>'charter.php'
            );
        $pageRes = $pages->add($dataCharter);

        }
        
    }
    $_SESSION['Msg'] = "City Added Sucessfully.";
    header('Location: ../cityList.php');
} else if ($_POST['type'] == 'Update' && $_POST['citId'] != NULL && $_POST['cityName'] != NULL) {
    $isLimo = (isset($_POST['isLimo'])) ? '1':'0';
    $isCharter = (isset($_POST['isCharter'])) ? '1':'0';
    $cityFullName = $_POST[cityName].','.$_POST['state'].','.$_POST['country'];
    $cityLatLong = findCityLatLong($cityFullName);
    $prevIsLimo = $_POST['prevIsLimo'];
    $prevIsCharter = $_POST['prevIsCharter'];
    $res = $city->Update($_POST['citId'],$cityLatLong, $isLimo, $isCharter);
        if($res){
           //check entry if exist or not in parent city destination
           $checkParentCity = $city->CheckDestinationParentCity($_POST['citId']); 
           if(!$checkParentCity){
            //entry to parent city destination
            $cityForDestination = $_POST['cityForDestination'];
            $cityid =$_POST['citId'];
            $parentCityId = $_POST['fkPCId'];
            $city = $city->AddDestinationParentCity($cityForDestination,$cityid, $parentCityId);
        }else{
            //update to parent city destination
            $cityForDestination = $_POST['cityForDestination'];
            $cityid =$_POST['citId'];
            $parentCityId = $_POST['fkPCId'];
            $city = $city->UpdateDestinationParentCity($cityForDestination,$cityid, $parentCityId);
        }
        //disable old page     
        $oldLimoPage = strtolower(preg_replace('/\s+/', '-', trim($_POST['oldCityName']))).'-limo';
        $oldCharterPage = strtolower(preg_replace('/\s+/', '-', trim($_POST['oldCityName']))).'-charter-bus';
        
        //disable the entry from pages table 
        if(trim($_POST['cityName'] != trim($_POST['oldCityName']))){ 
            //if city name changes
            //$deleteOldPage = $pages->OldPagesDelete($oldLimoPage ,$oldCharterPage);
            $disablePageArr = array($oldLimoPage ,$oldCharterPage);
            $disableOldPage = $pages->PagesStatus($disablePageArr ,'disable');
        }else if(($prevIsLimo == '1' AND $isLimo == '0') OR ($prevIsCharter == '1' AND $isCharter == '0')){
            //if previously chcked and now unchecked the availability
            if($isLimo == '1')
                $oldLimoPage = '';
            if($isCharter == '1')
                $oldCharterPage = '';
            
            $disablePageArr = array();
            if($oldLimoPage != '')
                array_push ($disablePageArr,$oldLimoPage);
            if($oldCharterPage != '')
                array_push ($disablePageArr,$oldCharterPage);
            $disableOldPage = $pages->PagesStatus($disablePageArr ,'disable');
        }
        
        //add url entry to pages
        if($isLimo == '1' AND ((trim($_POST['cityName'] != trim($_POST['oldCityName']))) OR $prevIsLimo == '0') ){
        $dataCity = array(
                'pageName'=> strtolower(preg_replace('/\s+/', '-', trim($_POST['cityName']))).'-limo',
                'pageType'=>'limopage',
                'fileName'=>'limo.php'
            );
        $pageRes = $pages->add($dataCity);
        }
        if($isCharter == '1' AND ((trim($_POST['cityName'] != trim($_POST['oldCityName']))) OR $prevIsCharter == '0')){
        $dataState = array(
                'pageName'=> strtolower(preg_replace('/\s+/', '-', trim($_POST['state']))),
                'pageType'=>'statepage',
                'fileName'=>'state.php'
            );
        $pageRes = $pages->add($dataState);
        
        $dataCharter = array(
                'pageName'=> strtolower(preg_replace('/\s+/', '-', trim($_POST['cityName']))).'-charter-bus',
                'pageType'=>'charterpage',
                'fileName'=>'charter.php'
            );
        $pageRes = $pages->add($dataCharter);

        }
        
    }
    $_SESSION['Msg'] = "City Updated Sucessfully.";
    header('Location: ../cityList.php');
} else if ($_POST['type'] == 'delete' && $_POST['citId'] != NULL) {
    $res = $city->Delete($_POST['citId']);
    echo "City Deleted Sucessfully.";
} else if ($_POST['type'] == 'getstate' && $_POST['country'] != NULL ){
    $myClass = new MyClass();
    $StateData = $myClass->GetState($_POST['country']);
    echo json_encode($StateData);
    exit;
} else if($_POST['type'] == 'getstatewisecity' && $_POST['state'] != NULL ){
    $myClass = new MyClass();
    $cityData = $myClass->GetStateWiseCity($_POST['state']);
    echo json_encode($cityData);
    exit;
}else if($_POST['type'] == 'addDestination'){
    if($_POST['pkftdId']!=''){
        $res=$city->UpdateDestination();
        $_SESSION['Msg'] = "Destination Update Sucessfully.";
    }else{
        $res=$city->AddDestination();
        $_SESSION['Msg'] = "Destination Added Sucessfully.";
    }    
    header('Location: ../destinationList.php');    
} else if($_POST['type'] == 'deleteDestination' && $_POST['destinationid'] != NULL){
    $res = $city->DeleteDestination($_POST['destinationid']);
    echo "Destination Data Deleted Sucessfully.";
}else if($_POST['type']=='changetype' && $_POST['field']){
    list($field,$id)=explode('_',$_POST['field']);
    $fieldval=$_POST['fieldval'];
    $res = $city->UpdateField($id,$field,$fieldval);
    
    //pages entry add or update 
    $status='disable';
    $pageType = 'limopage';
    $fileName = 'limo.php';
    if($fieldval==1)
        $status='enable';
    if($field == 'isCharter'){
       $pageType = 'charterpage';
       $fileName = 'charter.php';
       //for state
       if($status == 'enable'){
        $dataState = array('pageName'=> $_POST['stateName'],'pageType'=>'statepage','fileName'=>'state.php');
        $pageRes1 = $pages->add($dataState);
       }
    }
    
    if($status == 'disable'){
        $pages->PagesStatus(array($_POST['pagename']),$status);
    }else{
        $dataCity = array('pageName'=> $_POST['pagename'],'pageType'=>$pageType,'fileName'=>$fileName);
        $pageRes = $pages->add($dataCity);
    }
    echo "Citytype Updated Sucessfully.";
}else {
    header("Location: ../cityList.php");
}

function findCityLatLong($cityName){
    //return '22.30 , 70.78';
    $latLong;
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($cityName).'&key=AIzaSyChmsoAG3KPVrhFm2UjUXGKZC5n7Oy8Cvc&sensor=false';
    $response = @file_get_contents(myUrlEncode($url));
    $data = json_decode($response);
    if($data->status == 'OK'){
        $lat =  $data->results[0]->geometry->location->lat  ;
        $long = $data->results[0]->geometry->location->lng;
        $latLong = $lat." , ".$long;
    }
    return $latLong;
}

function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}
?>
