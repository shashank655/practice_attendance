<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Student.php';
require_once 'employee/class/StudentMarks.php';
require_once("dompdf/dompdf_config.inc.php");

$txt = "hello world lorem ipsum orem ipsum";
$txt = str_replace('&nbsp;', '', $txt);
$dompdf = new DOMPDF();
$dompdf->load_html(html_entity_decode($txt));
$dompdf->render();
$output = $dompdf->output();
$pdfname = md5(strtotime('now')) . '.pdf';
//file_put_contents(PDF_ATTACHMENT_ROOT . $pdfname, $output); 

$student = new Student(); 
$student_marks = new StudentMarks(); 
$studentId = (isset($_REQUEST['sID'])) ? $_REQUEST['sID'] : NULL; 
if ($studentId != NULL) { $result = $student_marks->getSampleStudentMarks($studentId); 
	if ($result == NULL) { $studentId = ''; } } 
    ?>
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<style type="text/css">
    .reportCardForm *{
        font-family: 'Source Sans Pro';
    }
    .reportCardForm p{
        font-size: 15px;
    }
    .reportCardForm h3{
        font-size: 15px;
        margin-bottom: 3px;
    }
    .reportCardForm h2{
        font-size: 26px;
        margin-bottom: 5px;
    }
    .reportCardTable input[type="text"]{
        border:0;
        width:100%;
    }
    .reportCardTable,.reportCardTable2{
        border: 1px solid black; 
    }
    .reportCardTable th,
    .reportCardTable td{
        border: 1px solid black; 
        text-align: center;
        font-size: 15px;
    }
    .reportCardTable2 th,
    .reportCardTable2 td{
        border: 1px solid black;
        font-size: 15px;
    }
    .poweredBy{
        font-size: 12px;
        color: #336699;
    }
    .poweredBy img{
        margin-left: 5px;
    }
    .reportCardForm *{
        color: #336699;
    }
</style>
<div class="page-wrapper"> <!-- content -->
    <div class="content container-fluid">
    <?php if(!empty($result)) { ?>
        <div class="col  text-center">
            <a href="javascript:void();" id="print_button" class="btn btn-primary btn-rounded float-left">Print</a>
        </div>
        <?php } ?>
	   <div class="reportCardForm print-div">
       <form id="addMarks" action="employee/process/processStudentsMarks.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
    <input type="hidden" name="type" value="sample-exam-scores" />
    <input type="hidden" name="studentId" value="<?php echo $studentId; ?>" />
    <div class="row justify-content-between mb-4 cardHeader">
        <div class="col pl-4"><img src="<?php echo BASE_ROOT. 'assets/img/logo-tc.jpg'?>" alt="school logo"></div>
        <div class="col-5 text-center pt-5">
            <h3>Doon International School</h3>
            <p class="mb-1">Panchpuri Colony, Dalanwala, Dehradun, Uttarakhand 248001</p>
            <p class="mb-1">Phone number: 0135-2658491, 26566088 </p>
            <p class="mb-1">Email: <em><strong>info@disdehradun.com</strong></em>&nbsp;&nbsp;&nbsp;Website: <em><strong>www.disdehradun.com</strong></em></p>
        </div>
        <div class="col pr-4 text-right">
            <div class="poweredBy">Powered by Adhyay <img src="<?php echo BASE_ROOT. 'assets/img/adhyay-logo-color.png'?>" style="width: 30px;"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col text-center">
            <h3>Report Card</h3>
            <p class="mb-0"><em><strong>Academic Session: 2020-21</strong></em></p>
            <h3>Report card for class IX</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <p class="mb-1"><strong>Roll No.: <?php echo $result[0]['roll_number'];?></strong></p>
        </div>
        <div class="col-12">
            <p class="mb-1"><strong>Student's Name: <?php echo $result[0]['first_name'].' '.$result[0]['last_name']?></strong></p>
        </div>
        <div class="col-12">
            <p class="mb-1"><strong>Mother's / Father's / Guardian's Name: <?php echo $result[0]['fathers_name'];?> </strong></p>
        </div>
        <div class="col-12">
            <p class="mb-1"><strong>Date of Birth: <?php echo $result[0]['dob'];?></strong></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table reportCardTable">
                <tr>
                    <th>Scholaristic Areas:</th>
                    <th colspan="6">Academic Year (100 Marks)</th>
                </tr>
                <tr>
                    <th>Sub Name</th>
                    <th>Periodic Test <br>(10)</th>
                    <th>Note <br>Book <br>(5)</th>
                    <th>Subject <br>Enrichment <br>(5)</th>
                    <th>Annual <br> Examination <br> (80)</th>
                    <th>Marks <br> Obtained (100)</th>
                    <th>Grade</th>
                </tr> 
                <tr>
                    <td>Hindi</td>
                    <td><input type="text" name="hindi_periodic_test" value="<?php if (isset($result[0]['hindi_periodic_test'])) echo $result[0]['hindi_periodic_test']; ?>"  /></td>
                    <td><input type="text" name="hindi_note_book" value="<?php if (isset($result[0]['hindi_note_book'])) echo $result[0]['hindi_note_book']; ?>"  /></td>
                    <td><input type="text" name="hindi_subject_enrichment" value="<?php if (isset($result[0]['hindi_subject_enrichment'])) echo $result[0]['hindi_subject_enrichment']; ?>"  /></td>
                    <td><input type="text" name="hindi_annual_examination" value="<?php if (isset($result[0]['hindi_annual_examination'])) echo $result[0]['hindi_annual_examination']; ?>"  /></td>
                    <td><input type="text" name="hindi_marks_obtained" value="<?php if (isset($result[0]['hindi_marks_obtained'])) echo $result[0]['hindi_marks_obtained']; ?>"  /></td>
                    <td><input type="text" name="hindi_grade" value="<?php if (isset($result[0]['hindi_grade'])) echo $result[0]['hindi_grade']; ?>"  /></td>
                </tr>
                <tr>
                    <td>English</td>
                    <td><input type="text" name="english_periodic_test" value="<?php if (isset($result[0]['english_periodic_test'])) echo $result[0]['english_periodic_test']; ?>"  /></td>
                    <td><input type="text" name="english_note_book" value="<?php if (isset($result[0]['english_note_book'])) echo $result[0]['english_note_book']; ?>"  /></td>
                    <td><input type="text" name="english_subject_enrichment" value="<?php if (isset($result[0]['english_subject_enrichment'])) echo $result[0]['english_subject_enrichment']; ?>"  /></td>
                    <td><input type="text" name="english_annual_examination" value="<?php if (isset($result[0]['english_annual_examination'])) echo $result[0]['english_annual_examination']; ?>"  /></td>
                    <td><input type="text" name="english_marks_obtained" value="<?php if (isset($result[0]['english_marks_obtained'])) echo $result[0]['english_marks_obtained']; ?>"  /></td>
                    <td><input type="text" name="english_grade" value="<?php if (isset($result[0]['english_grade'])) echo $result[0]['english_grade']; ?>"  /></td>
                </tr>
                <tr>
                    <td>Math's</td>
                    <td><input type="text" name="maths_periodic_test" value="<?php if (isset($result[0]['maths_periodic_test'])) echo $result[0]['maths_periodic_test']; ?>"  /></td>
                    <td><input type="text" name="maths_note_book" value="<?php if (isset($result[0]['maths_note_book'])) echo $result[0]['maths_note_book']; ?>"  /></td>
                    <td><input type="text" name="maths_subject_enrichment" value="<?php if (isset($result[0]['maths_subject_enrichment'])) echo $result[0]['maths_subject_enrichment']; ?>"  /></td>
                    <td><input type="text" name="maths_annual_examination" value="<?php if (isset($result[0]['maths_annual_examination'])) echo $result[0]['maths_annual_examination']; ?>"  /></td>
                    <td><input type="text" name="maths_marks_obtained" value="<?php if (isset($result[0]['maths_marks_obtained'])) echo $result[0]['maths_marks_obtained']; ?>"  /></td>
                    <td><input type="text" name="maths_grade" value="<?php if (isset($result[0]['maths_grade'])) echo $result[0]['maths_grade']; ?>"  /></td>
                </tr>
                <tr>
                    <td>General Science</td>
                    <td><input type="text" name="gs_periodic_test" value="<?php if (isset($result[0]['gs_periodic_test'])) echo $result[0]['gs_periodic_test']; ?>"  /></td>
                    <td><input type="text" name="gs_note_book" value="<?php if (isset($result[0]['gs_note_book'])) echo $result[0]['gs_note_book']; ?>"  /></td>
                    <td><input type="text" name="gs_subject_enrichment" value="<?php if (isset($result[0]['gs_subject_enrichment'])) echo $result[0]['gs_subject_enrichment']; ?>"  /></td>
                    <td><input type="text" name="gs_annual_examination" value="<?php if (isset($result[0]['gs_annual_examination'])) echo $result[0]['gs_annual_examination']; ?>"  /></td>
                    <td><input type="text" name="gs_marks_obtained" value="<?php if (isset($result[0]['gs_marks_obtained'])) echo $result[0]['gs_marks_obtained']; ?>"  /></td>
                    <td><input type="text" name="gs_grade" value="<?php if (isset($result[0]['gs_grade'])) echo $result[0]['gs_grade']; ?>"  /></td>
                </tr>
                <tr>
                    <td>Social Science</td>
                    <td><input type="text" name="ss_periodic_test" value="<?php if (isset($result[0]['ss_periodic_test'])) echo $result[0]['ss_periodic_test']; ?>"  /></td>
                    <td><input type="text" name="ss_note_book" value="<?php if (isset($result[0]['ss_note_book'])) echo $result[0]['ss_note_book']; ?>"  /></td>
                    <td><input type="text" name="ss_subject_enrichment" value="<?php if (isset($result[0]['ss_subject_enrichment'])) echo $result[0]['ss_subject_enrichment']; ?>"  /></td>
                    <td><input type="text" name="ss_annual_examination" value="<?php if (isset($result[0]['ss_annual_examination'])) echo $result[0]['ss_annual_examination']; ?>"  /></td>
                    <td><input type="text" name="ss_marks_obtained" value="<?php if (isset($result[0]['ss_marks_obtained'])) echo $result[0]['ss_marks_obtained']; ?>"  /></td>
                    <td><input type="text" name="ss_grade" value="<?php if (isset($result[0]['ss_grade'])) echo $result[0]['ss_grade']; ?>"  /></td>
                </tr>
            </table>
            </div>
            <h3 class="mb-3">Grand Total</h3>
            <div class="table-responsive">
                <table class="table reportCardTable2">
                    <tr>    
                        <td style="width: 50%;">Co- Scholastic Areas on a 5 Points (A-E) grading scale</td>
                        <td>Grade</td>
                    </tr>
                    <tr>
                        <td>Work Education ( or Pre-vocational Education)</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Art Education</td>
                        <td><input type="text" name="art_education" value="<?php if (isset($result[0]['art_education'])) echo $result[0]['art_education']; ?>"  /></td>
                    </tr>
                    <tr>
                        <td>Health & Physical Eductaion </td>
                        <td><input type="text" name="health_pysical_education" value="<?php if (isset($result[0]['health_pysical_education'])) echo $result[0]['health_pysical_education']; ?>"  /></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p>Class Teacher's Remarks ................................</p>
            <p>Result: <input type="text" name="final_result" value="<?php if (isset($result[0]['final_result'])) echo $result[0]['final_result']; ?>"  /></p>
            
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col">
            <p>Date ..................................</p>
        </div>
        <div class="col">
            <p>Signature of <br>Class Teacher</p>
        </div>
        <div class="col">
            <p>Signature of <br>Principal</p>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="form-group text-center custom-mt-form-group">
            <button class="btn btn-secondary mr-2" type="submit">Submit</button>
        </div>
    </div>
    </form>
</div>		
    </div>
</div>
    <?php require_once 'includes/footer.php'; ?>
    <script src="employee/js/printThis.js"></script>
    <script type="text/javascript">
        $('#print_button').on("click", function () {
            $('.print-div').printThis();
        });
    </script>