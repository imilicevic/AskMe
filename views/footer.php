<footer>
  <div class="text-center">AskMe &copy; 2017</div>
</footer>
<script src="<?php echo ROOT_PATH ?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo ROOT_PATH ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo ROOT_PATH ?>assets/js/jquery-ui.min.js"></script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker({
      yearRange: "-80:+0",
      changeYear: true,
      dateFormat: "yy-mm-dd"
    });
    $('#ui-datepicker-div').addClass('ll-skin-nigran');
  });
</script>
</body>
</html>