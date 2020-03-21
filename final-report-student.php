<?php 
   require_once 'employee/config/config.php';
   require_once 'employee/class/dbclass.php';
   require_once 'employee/class/SessionTerms.php';
   $sessionTerm=new SessionTerms(); 
   $sessionId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
   if ($sessionId != NULL) { 
      $result = $sessionTerm->getSessionInfo($sessionId);
   }
   require_once 'includes/header.php'; 
   require_once 'includes/sidebar.php';
   ?>
<div class="page-wrapper">
   <!-- content -->
   <div class="content container-fluid">
      <div class="page-header">
         <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-12">
               <h5 class="text-uppercase">Session Terms</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item"> Add Terms</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="report-card">
  <div class="table-responsive">
    <table class="table table-bordered mb-3">
      <thead>
        <tr>
          <th>Student's Name : Aadhya Dabral</th>
          <th>Class: 1st</th>
          <th>Sec: A</th>
          <th>Roll: </th>
        </tr>
        <tr>
          <th>Admission No: 1419</th>
          <th>House: </th>
          <th colspan="3">D.O.B: 6/11/12</th>
        </tr>
      </thead>      
    </table>
    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th>Scholastic Area:</th>
          <th colspan="6">TERM 1st - ( 100 MARKS )</th>
        </tr>
        <tr>
          <th>Sub Name</th>
          <th>1st <br> U.Test <br> (10)</th>
          <th>Note Book <br> (5)</th>
          <th>Subject <br> Enrichment <br> (5)</th>
          <th>Half Yearly Exam <br> (80)</th>
          <th>Marks <br> Obtained (100)</th>
          <th>Grade</th>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <td>English Communnicative</td>
          <td>7</td>
          <td>4</td>
          <td>3</td>
          <td>70</td>
          <td>84.00</td>
          <td>A2</td>
        </tr>
        <tr>
          <td>Hindi - A</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>Mathematics</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>EVS</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>Computer</td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>G.K</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
      </tbody>    
    </table>

    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th>Scholastic Area:</th>
          <th colspan="8">TERM IInd - ( 100 MARKS )</th>
        </tr>
        <tr>
          <th>Subjects</th>
          <th>IInd <br> U.Test <br> (10)</th>
          <th>Note Book <br> (5)</th>
          <th>Subject <br> Enrichment <br> (5)</th>
          <th>Final <br> Exams <br> (80)</th>
          <th>Marks <br> Obtained <br> (100)</th>
          <th>Gr</th>
          <th>Term <br> 1+2 <br> (100) </th>
          <th>Gr</th>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <td>English Communnicative</td>
          <td>7</td>
          <td>4</td>
          <td>3</td>
          <td>70</td>
          <td>84.00</td>
          <td>A2</td>
          <td>A2</td>
          <td>A2</td>
        </tr>
        <tr>
          <td>Hindi - A</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>Mathematics</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>EVS</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>Computer</td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td>G.K</td>  
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
          <td></td> 
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Total</td>
          <td>42</td>
          <td>7%</td>
        </tr>
      </tbody>    
    </table>

    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th>Co-Scholastic Area: [ on 3-point (A-C) Grade Scale]</th>
          <th>Grade(Term I)</th>
          <th>Grade(Term II)</th>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <td>Work Education (on Pre-vocational Education)</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Art Education</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Craft</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Music / Dance</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Health & Physical Education</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>    
    </table>

    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th>Discipline Term- I & II [ on 3-point (A-C) Grade Scale]</th>
          <th>Grade(Term I)</th>
          <th>Grade(Term II)</th>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>    
    </table>

    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th></th>
          <th>Term I</th>
          <th>Term II</th>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <td>Total Attendance</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Total Working Days</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Sign of Class Teacher</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>    
    </table>

    <table class="report-table mb-3">
      <tbody>
        <tr>
          <td>Class Teacher's Remarks:</td>
        </tr>
        <tr>
          <td>Over All Result: Granted to Class</td>
          <td>Grade: </td>
        </tr>
        <tr>
          <td>New Session Begins On: April 2019, Sharp at 8:00am.</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>    
    </table>

    <p class="text-right px-2">
      <strong><em>Signature of principal</em></strong>
    </p>
  </div>
</div>
      </div>
   </div>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
   var sectionLength = $('.add_terms').length;
   var k = (sectionLength > 0) ? sectionLength + 1 : 1;
   
       function addAnother() {
               var aboutAddrow = $("#clone-sections-div").clone().removeAttr('style');
               aboutAddrow.attr("id", "trans-fees-" + k);
               
               var textboxname = aboutAddrow.find('.addTerm').attr('name', 'addTerm[]');    
               textboxname.attr('id', 'addTerm' + k);
    
               var deleteicon = aboutAddrow.find('#delete-icon');
                deleteicon.attr('id', 'newdelete' + k);
                deleteicon.attr('name', 'trans-fees-' + k);
   
               $("#main-sections-div").append(aboutAddrow);
   
               k = k + 1;
       }
       
       $(function(){
           $("#addSessionTerm").validate({
               ignore: "input[type='text']:hidden",
               rules:{
                   session_year:{
                       required:true
                   },
                   'addTerm[]':{
                       required:true
                   }
               }
           });
       });
   
       function deleteAddress(deleteid) {
            $('#' + deleteid).remove();
        }
</script>