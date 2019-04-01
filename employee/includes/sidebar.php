<?php
require_once 'config/config.php';
require_once 'class/dbclass.php';
/*$path = $_SERVER['PHP_SELF'];
$page_name = basename($path);
$super_access = "";
$user_access_string = str_replace("'", "", $_SESSION['userAccess']); 
$super_access = explode(',',$user_access_string);
array_push($super_access, 'index.php');
//$super_access = array('cityList.php','vehicleList.php','citysVehicle.php','userList.php','user.php','account.php','rateList.php','careerlist.php','testimonialList.php');
if($_SESSION['userType'] != 'super'  )
{    
    
    if (!in_array($page_name, $super_access)) 
    { 
        //header("Location:index.php");
        echo "<meta http-equiv='refresh' content='0; url=index.php' />";
        exit;
    }
}*/
$db = new MySQLCN();

//Due Date notification (Reservation Tab)
$qrynoti = "select res.pkReservationId,trip.payment_DueDate,ROUND(trip.tripTotal,0), (select ROUND(SUM(transactionAmount),0) from transaction t where t.isRefund='no' and t.fkTripId=trip.pkTId) as tAmount from reservation res JOIN trip ON res.fkTripId=trip.pkTId
        where res.isCancelled = '0' and trip.isCompleted='no' and trip.payment_type= 'partial' and trip.payment_DueDate < NOW() and (select ROUND(SUM(transactionAmount),0) from transaction t where t.isRefund='no' and t.fkTripId=trip.pkTId) < ROUND(trip.tripTotal,0)";
$resnoti = $db->select($qrynoti);

$notiCount = count($resnoti);
//Trip notification not in reservation (Trip Tab)
$qry = "select pkTId from trip where isRegistered='0' and isReserved = '0' ";
$res = $db->select($qry);
$tripCount = count($res);
//Trip Registered notification not in reservation (Trip(registered) Tab)
$qry = "select pkTId from trip where isRegistered='1' and isReserved = '0' ";
$res = $db->select($qry);
$tripRegCount = count($res);
if($_SESSION['userType'] == 'super')
    $qry = "select * from menu_list";
else
    $qry = 'select * from menu_list where menu_link IN ('. $_SESSION['userAccess'] . ')';

$menuList = $db->selectForJason($qry);
//echo "<pre>";
//print_r($menuList);
//echo "</pre>";
?>
<div id="sidebar">
    <a href="index.php" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>            
        <li class="<?= ($page_name == 'index.php' || $page_name == '') ? 'active' : '' ?>"><a href="index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>        
        <?php  $cms_pages = array(
                                     'pagesList.php','pages.php','pageMeta.php',
                                     'careerlist.php','Career.php','fleetList.php','fleet.php',
                                     'shofurList.php','shofur.php','reviewList.php','review.php',
                                     'eventsList.php','events.php', 'crossStateList.php',  
                                     'thingsToDoList.php','thingsToDo.php','newsList.php','news.php',
                                     'destinationList.php','destination.php'
                                    ); 
        ?>

        <?php 
        ?>


        <?php
         $cms_links = "";
         ?>   
        <?php for($i = 0; $i < count($menuList); $i++) : 
            
            if (in_array($menuList[$i]['menu_link'], $MenuSubOptionEnum))
                continue;
            $menus = explode(',', $menuList[$i]['menu_link'] );
            $innerPage = isset($menus[1]) && ($menus[1] != 'trip.php') ? $menus[1] : "" ;
            if ($menus[0] == 'tripList.php') 
                $tripNotification_count = ($tripCount > 0) ? "<span class='label'>$tripCount</span>" : "";
            else
                $tripNotification_count = "";
            if ($menus[0] == 'tripListRegister.php')
                $tripRegNotification_count =  ($tripRegCount > 0)? "<span class='label'>$tripRegCount</span>" : "";
            else
                $tripRegNotification_count =  "";
            if ($menus[0] == 'reservationList.php')
                $notification_count = ($notiCount > 0) ? "<span class='label'>$notiCount</span>" : "";
            else
                $notification_count = "";
        ?>  
        
            <?php 
           
            if (in_array($menus[0], $cms_pages)){
                $cms_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $cms_links.="active";
                }
                $cms_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";
                
            } else if (in_array($menus[0], $states_pages)) {
                $states_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $states_links.="active";
                }
                $states_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else if (in_array($menus[0], $bus_comparison_page)) {
                $bus_comparison_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $bus_comparison_links.="active";
                }
                $bus_comparison_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else if (in_array($menus[0], $city_child_pages)) {
                $city_child_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $city_child_links.="active";
                }
                $city_child_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else if (in_array($menus[0], $city_charter_pages)) {
                $city_charter_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $city_charter_links.="active";
                }
                $city_charter_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else if (in_array($menus[0], $national_charter_pages)) {
                $national_charter_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $national_charter_links.="active";
                }
                $national_charter_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else if (in_array($menus[0], $event_charter_pages)) {
                $event_charter_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $event_charter_links.="active";
                }
                $event_charter_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else if (in_array($menus[0], $lp_charter_pages)) {
                $lp_charter_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus)){ 
                    $lp_charter_links.="active";
                }
                $lp_charter_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span></a></li>";

            } else {  
                $admin_links .= "<li class='";
                if($page_name == $menus[0] || in_array($page_name ,$menus) ){ 
                    $admin_links.="active";
                }
                $admin_links.="'><a href=".$menus[0]."><i class='icon  icon-book'></i> <span>".$menuList[$i]['menu_name']."</span>". $notification_count . $tripNotification_count . $tripRegNotification_count."</a></li>";
                
             }
           endfor;?>
                <?= $admin_links  ?>
    </ul>
</div>    
<!--</div><li class="<?= ($page_name == $menus[0] || $page_name == $innerPage ) ? 'active' : '' ?>"><a href="<?= $menus[0] ?>"><i class="icon  icon-book"></i> <span><?= $menuList[$i]['menu_name'] ?></span></a></li>-->