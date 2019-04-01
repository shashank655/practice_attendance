<?php
require_once 'config/config.php';
require_once 'class/dbclass.php';
require_once 'class/City.php';
require_once 'class/MyClass.php';
$myClass = new MyClass();
$countryData = $myClass->GetCountry();

$city = new City();
$cityData = $city->AllGetCity();
//echo "<pre>";
//print_r($CityData);
//echo "</pre>";
$citId = (isset($_REQUEST['citId'])) ? $_REQUEST['citId'] : NULL;
if ($citId != NULL) {
    $result = $city->GetCity($citId);
    $resultDestParentCity  = $city->GetDestinationParentCity($citId);
//    echo "<pre>";
//    print_r($resultDestParentCity);
//    echo "</pre>";
    if ($result == NULL) {
        $citId = '';
    }
}
?>
<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>
<script src="ckeditor/ckeditor.js"></script>
<style>
    input[type="text"],select{
        width: 350px !important;
    }
    textarea{
        height: 200px;
    }
    .select2-search input[type='text']{
        width:100% !important;
    }
</style>
<div id="content">
    <div id="content-header">
        <h1>City</h1>        
    </div>
    <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#" class="current">City</a>
    </div>
    <div class="container-fluid">        
        <div class="row-fluid">
            <div class="span12">
                <div class="alert alert-success <?php echo (isset($_SESSION['Msg']) && $_SESSION['Msg'] != '') ? '' : 'hide' ?>">
                    <button data-dismiss="alert" class="close">×</button>
                    <?php
                    if (isset($_SESSION['Msg'])) {
                        echo $_SESSION['Msg'];
                        $_SESSION['Msg'] = '';
                        unset($_SESSION['Msg']);
                    }
                    ?>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-align-justify"></i>									
                        </span>
                        <h5>City</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal"  method="post" action="process/processCity.php" name="city-form" id="city-form" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="<?php echo $citId == '' ? 'Add' : 'Update'; ?>"/>
                            <input type="hidden" name="citId" value="<?php echo $citId; ?>"/>
                            <input type="hidden" name="oldCityName" value='<?php if (isset($result[0]['cityName'])) echo $result[0]['cityName']; ?>'  />
                            <input type="hidden" name="oldStateName" value='<?php if (isset($result[0]['state'])) echo $result[0]['state']; ?>'  />
                            <input type="hidden" name="prevIsLimo" value='<?php if (isset($result[0]['isLimo'])) echo $result[0]['isLimo']; ?>'  />
                            <input type="hidden" name="prevIsCharter" value='<?php if (isset($result[0]['isCharter'])) echo $result[0]['isCharter']; ?>'  />
                            <input type="hidden" name="finalGeoLatLong" id="finalGeoLatLong" value='<?php if (isset($result[0]['geoLatLong'])) echo $result[0]['geoLatLong']; ?>'  />
                            <div class="control-group">
                                <label class="control-label">City Name</label>
                                <div class="controls">
                                    <input type="text" id="cityFirstName" name="cityName" value="<?php
                    if (isset($result[0]['cityName']))
                        echo $result[0]['cityName'];
                    ?>"  />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Country</label>
                                <div class="controls">
                                    <select id="country" name="country" style="width:220px;" onclick="getstate(this.value);" >                                    
                                        <option value="">Country</option>
                                        <?php for ($i = 0; $i < count($countryData); $i++) : ?>
                                            <option <?php
                                        if (isset($result[0]['country'])) {
                                            if ($result[0]['country'] == $countryData[$i]['two_letter']) {
                                                echo 'selected';
                                            }
                                        }else{
                                            if(isset($_GET['cu']))
                                                if ($_GET['cu'] == $countryData[$i]['two_letter']) {
                                                echo 'selected';
                                            }
                                        }
                                            ?>  value="<?php echo $countryData[$i]['two_letter']; ?>" ><?php echo $countryData[$i]['long_name']; ?></option>
                                            <?php endfor; ?> 
                                    </select>
                                    <!--input type="text" id="country" name="country" value="<?php
                                            if (isset($result[0]['country']))
                                                echo $result[0]['country'];
                                            ?>"  /-->
                                </div>
                            </div>                            
                            <div class="control-group">
                                <label class="control-label">State</label>
                                <div class="controls">
                                    <select id="state" name="state" style="width:220px;" >                                    
                                        <option value=" " selected="selected" >State/Province</option>                                        
                                    </select>                  
                                </div>                                
                                <!--input type="text" id="state" name="state" value="<?php
                                    if (isset($result[0]['state']))
                                        echo $result[0]['state'];
                                            ?>"  /-->                                
                            </div>                            
                            <div class="control-group">
                                <label class="control-label">Zip</label>
                                <div class="controls">
                                    <input type="text" id="zip" name="zip" value="<?php
                                if (isset($result[0]['zip']))
                                    echo $result[0]['zip'];
                                            ?>"  />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Available</label>
                                <div class="controls">
                                <input type="checkbox" name="isLimo" value="1" <?php echo (isset($result)) ? ($result[0]['isLimo'] == 1) ? 'checked' : ''  : ''; ?>  />Limo
                                <input type="checkbox" name="isCharter" value="1" <?php echo (isset($result)) ? ($result[0]['isCharter'] == 1) ? 'checked' : ''  : ''; ?>  />Charter
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">City for Destination</label>
                                <div class="controls">
                                    <label> <input type="radio" name="cityForDestination" <?php echo (isset($resultDestParentCity[0]['cityForDestination'])) ? ($resultDestParentCity[0]['cityForDestination'] == 'parentCity') ? 'checked' : ''  : 'checked'; ?> value="parentCity"  /> Parent City </label>
                                    <label><input type="radio" name="cityForDestination" <?php echo (isset($resultDestParentCity[0]['cityForDestination'])) ? ($resultDestParentCity[0]['cityForDestination'] == 'subCity') ? 'checked' : ''  : ''; ?> value="subCity" /> Sub City</label>
                                </div>
                            </div>
                             <div class="control-group parent-city hide">
                                <label class="control-label"> Parent City</label>
                               <div class="controls">
                                    <select id="fkPCId" name="fkPCId">
                                        <?php for ($i = 0; $i < count($cityData); $i++) : ?>
                                             <?php if($citId != $cityData[$i]['pkCId']) :   ?>
                                            <option value="<?php echo $cityData[$i]['pkCId']; ?>"  <?php echo (isset($resultDestParentCity)) ? ($resultDestParentCity[0]['fkPCId'] == $cityData[$i]['pkCId'] ) ? 'selected' : ''  : ''; ?> ><?php echo $cityData[$i]['cityName']; ?></option>
                                            
                                        <?php endif;endfor; ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">City Type</label>
                                <div class="controls">
                                    <label> <input type="radio" name="cityType" <?php echo (isset($result[0]['cityType'])) ? ($result[0]['cityType'] == 'radius') ? 'checked' : ''  : 'checked'; ?> value="radius"  /> Radius</label>
                                    <label><input type="radio" name="cityType" <?php echo (isset($result[0]['cityType'])) ? ($result[0]['cityType'] == 'geofence') ? 'checked' : ''  : ''; ?> value="geofence" /> Geofence</label>
                                </div>
                            </div>
                            <div class="control-group geo-latlong hide">
                                <label class="control-label">Geofence</label>
                                <div class="controls">
                                    <textarea rows="8" cols="5" class="span5" id="geoLatLong" name="geoLatLong"></textarea> 
                                    <textarea rows="8" readonly class="span5" id="geoData" name="geoData"><?php if (isset($result[0]['geoLatLong'])) echo $result[0]['geoLatLong']; ?></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Page Title</label>
                                <div class="controls">
                                    <input type="text" id="pageTitle" name="pageTitle"  style="width: 320px;" value="<?php if (isset($result[0]['pageTitle'])) echo $result[0]['pageTitle']; ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">H1 Tag</label>
                                <div class="controls">
                                    <input type="text" id="pageH1Tag" name="pageH1Tag" style="width: 320px;" value="<?php if (isset($result[0]['pageH1Tag'])) echo $result[0]['pageH1Tag']; ?>"  />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Basic Info</label>
                                <div class="controls">
                                    <div>
                                        <textarea id="pageBasicInfo" name="pageBasicInfo" class="input-xxlarge ckeditor"><?php if (isset($result[0]['pageBasicInfo'])) echo $result[0]['pageBasicInfo']; ?></textarea>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">City Title</label>
                                <div class="controls">
                                    <input type="text" id="cityTitle" name="cityTitle" value="<?php
                                    if (isset($result[0]['cityTitle'])) {
                                        echo $result[0]['cityTitle'];
                                    }
                                    ?>"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Page Content</label>
                                <div class="controls">
                                    <div>
                                        <textarea id="pageContent" name="pageContent" class="input-xxlarge ckeditor"><?php if (isset($result[0]['pageContent'])) echo $result[0]['pageContent']; ?></textarea>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Header Contact Number</label>
                                <div class="controls">
                                    <input type="text" id="headerPhoneNumber" name="headerPhoneNumber" value="<?php
                                if (isset($result[0]['headerPhoneNumber']))
                                    echo $result[0]['headerPhoneNumber'];
                                            ?>"  />
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Phone Number Box</label>
                                <div class="controls">
                                    <input type="text" id="phoneNumberBox" name="phoneNumberBox" value="<?php
                                if (isset($result[0]['phoneNumberBox']))
                                    echo $result[0]['phoneNumberBox'];
                                            ?>"  />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">City Description</label>
                                <div class="controls">
                                    <textarea name="cityDescription" id="cityDescription" class="input-xxlarge ckeditor"><?php
                                    if (isset($result[0]['cityDescription'])) {
                                        echo $result[0]['cityDescription'];
                                    }
                                    ?></textarea>
                              
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Google Javascript</label>
                                <div class="controls">
                                    <div style="width: 78.7%;">                                  
                                        <textarea id="pageJavascript" name="pageJavascript" class="input-xxlarge" style="width: 100% !important;height: 200px;"><?php if (isset($result[0]['pageJavascript'])) echo $result[0]['pageJavascript']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Banner Image</label>
                                <div class="controls">
                                    <input type="file" id="imgurl" name="imgurl" style="width: 320px;"/>
                                      <?php if ($citId): ?>
                                        <input type="hidden" name="bannerImage" id="bannerImage" value="<?php if (isset($result[0]['bannerImageName'])) echo $result[0]['bannerImageName']; ?>"/>
                                        <?php if (!empty($result[0]['bannerImageName'])): ?>
                                            <span id="bannerImageContainer">    
                                            <img src="<?php if (isset($result[0]['bannerImageName'])) echo CITY_IMAGE_PATH . $result[0]['bannerImageName']; ?>" height="100" width="100"/>
                                            <span class="del_slider_img">
                                                <img src="<?php echo BASE_ROOT; ?>employee/img/cancel.png" style="cursor:pointer"/>
                                            </span>
                                        </span>
                                    <?php endif; endif; ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">City Image</label>
                                <div class="controls">
                                    <input type="file" id="cityImageUrl" name="cityImageUrl" />
                                    <?php if ($citId): ?>
                                        <input type="hidden" name="cityImageName" id="cityImageName" value="<?php if (isset($result[0]['cityImageName'])) echo $result[0]['cityImageName']; ?>"/>
                                    <?php if (!empty($result[0]['cityImageName'])): ?>
                                            <span id="cityImageContainer">    
                                            <img src="<?php if (isset($result[0]['cityImageName'])) echo CITY_IMAGE_PATH . $result[0]['cityImageName']; ?>" height="100" width="100"/>
                                            <span class="del_city_image_img">
                                                <img src="<?php echo BASE_ROOT; ?>employee/img/cancel.png" style="cursor:pointer"/>
                                            </span>
                                        </span>
                                    <?php endif; endif; ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">City Image Alt Text</label>
                                <div class="controls">
                                    <input type="text" id="cityImageAltText" name="cityImageAltText" value="<?php
                                    if (isset($result[0]['cityImageAltText'])) {
                                        echo $result[0]['cityImageAltText'];
                                    }
                                    ?>"  />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">City Image Caption</label>
                                <div class="controls">
                                    <input type="text" id="cityImageCaption" name="cityImageCaption" value="<?php
                                    if (isset($result[0]['cityImageCaption'])) {
                                        echo $result[0]['cityImageCaption'];
                                    }
                                    ?>"  />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">City Image Caption Link</label>
                                <div class="controls">
                                    <input type="text" id="cityImageCaptionLink" name="cityImageCaptionLink" value="<?php
                                    if (isset($result[0]['cityImageCaptionLink'])) {
                                        echo $result[0]['cityImageCaptionLink'];
                                    }
                                    ?>"  />
                                </div>
                            </div>

                            <div class="form-actions">
                                <input type="submit" value="Submit" name="<?= ($citId) ? 'update' : 'insert' ?>" class="btn btn-primary">
                                <a href="cityList.php" class="btn">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>			
        </div>
    </div>        
</div>
<?php
require_once 'includes/footer.php';
?>
<script>
    var geofenceLatLong = new Array;
    var countryName = '';
    var state='';
    <?php  if($citId!=''){ ?>        
        state='<?php echo $result[0]['state']; ?>';
        getstate('<?php echo $result[0]['country']; ?>');
     <?php }else{ ?>
        state='<?php echo isset($_GET['s'])?trim($_GET['s']):''; ?>';
        countryName = '<?php echo isset($_GET['cu'])?trim($_GET['cu']):''; ?>';
         if(countryName != '')
            getstate(countryName);
    <?php } ?>    
    function getstate(country){         
        $.ajax({
            type: "POST",
            url: "process/processCity.php",
            data:{type:'getstate',country:country},
            beforeSend : function () {
                //$('#wait').html("Wait for checking");
            },
            success:function(data){                
                
                data = $.parseJSON(data);                
                if(data){
                    $("#state").html("<option value=' '>State/Province</option>");
                    for(var i=0;i<data.length;i++){             
                       var option="<option value='"+data[i].state_name+"'";
                           if(data[i].state_name==state){
                               option+=" selected";
                           }
                           option+=" >"+data[i].state_name+"</option>"
                        $("#state").append(option);
                    }                    
                }else{
                    $("#state").html("<option value=' ' selected >State/Province</option>");
                }
                $("#fkVId, #state").select2();
                
            }
        });
    }
    
    jQuery.validator.addMethod("custSelect", function(value, element, params) {        
        return $.trim(value) != '';
    },'This field is required.');
        
    $(function(){
        $("#city-form").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                cityName:{
                    required:true
                },
                state:{
                    required:true,
                    custSelect:true
                },
                country:{
                    required:true,
                    custSelect:true
                },                
                zip:{
                    required:true
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.appendTo(element.parents(".controls:first"));
            },
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
                $(element).parents('.control-group').removeClass('success');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        }); 
        
        $('input[name=cityType]').live('change',function(){
            //console.log($('input[name=cityType]:checked').val())
            var cityType = $('input[name=cityType]:checked').val();
            if(cityType == 'geofence'){
                $('.geo-latlong').show();
                $("#geoData").rules("add", {
                    required: true
                });
            }
            else{
                $('.geo-latlong').hide();
                $("#geoData").rules("remove");
            }
        });
        //hide show trigger geofences
        $('input[name=cityType]:checked').trigger('change');
        
        $('input[name=cityForDestination]').live('change',function(){
            var cityForDestination = $('input[name=cityForDestination]:checked').val();
            if(cityForDestination == 'subCity'){
                $('.parent-city').show();
            }
            else{
                $('.parent-city').hide();
            }
        });
        $('input[name=cityForDestination]:checked').trigger('change');
        
        
        //chnge of geofence
        $('#geoLatLong').bind('input propertychange',function(){
            geofenceLatLong.length = 0;
            var geoLatLong = $.trim($(this).val());
            //console.log(geoLatLong);
            geoLatLong = JSON.stringify(geoLatLong);
            console.log('parse json strigyfy: ',geoLatLong);
            geoLatLong = geoLatLong.replace(/"/g, '');
            //console.log('replace strng:',geoLatLong);
            //var geoSplit = JSON.parse(geoLatLong);
            var geoSplit = geoLatLong.split('\\n');
            console.log('split parse arr: ',geoSplit);
            $.each(geoSplit,function(key,value){
                var objectLatLong = {};
                // console.log(key);
                // console.log(value)
                var latLong = value.split(',');
                //console.log(latLong.length);
                if(latLong.length == 3){
                    objectLatLong.lat = latLong[1];
                    objectLatLong.lng = latLong[0];
                    geofenceLatLong.push(objectLatLong);
                }
                
            });
            //            var geoSplitComma = geoSplit[0].split(', ');
            //console.log('split parse arr: ',geoSplitComma);
            console.log('finalarr : ',geofenceLatLong);
            console.log(geofenceLatLong.length);
            var finalGeoLatLong = JSON.stringify(geofenceLatLong);
            if(geofenceLatLong.length == 0){
                console.log('all r blank')
                $('#finalGeoLatLong').val('');
                $('#geoData').text('');
            }else{
                $('#finalGeoLatLong').val(finalGeoLatLong);
                $('#geoData').text(finalGeoLatLong);
            }
            
            console.log('finlarrjson:',finalGeoLatLong);
        });

        // for delete image
        $('.del_slider_img').live('click', function () {
            var r = confirm("Are you sure to delete this image?");
            if (r == true) {
               $("#bannerImageContainer").hide();
               $("#bannerImage").val('');
            }
        });

        $('.del_city_image_img').live('click', function () {
            var r = confirm("Are you sure to delete this image?");
            if (r == true) {
               $("#cityImageContainer").hide();
               $("#cityImageName").val('');
            }
        });
    });
</script>
