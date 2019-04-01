<div class="row-fluid">
    <div id="footer" class="span12">
        <?php echo date('Y'); ?> &copy; Send SMS Admin.
    </div>
</div>
</div>
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/unicorn.js"></script>
<script src="js/unicorn.form_validation.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.validate.js"></script>        
<script src="js/bootstrap-timepicker.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script>    
    $(function(){
        $('.datepicker').datepicker({
            currentText: "Now",
            format: 'yyyy-mm-dd',
            autoclose : true
        });       
    });
</script>
<?php
$_SESSION['Msg'] = '';
unset($_SESSION['Msg']);
?>
</body>
</html>
