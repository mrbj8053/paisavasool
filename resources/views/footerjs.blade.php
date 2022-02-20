
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script>
  $(document).ready(function() {
    $('.dataTable').DataTable( {
        dom: 'Bfrtip',
        pageLength:100,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );

     $('select').select2();
} );

$(document).ready(function(){
  $("#bloodymodal").modal('toggle');



})

$(".toggler").click(function(e){
    var type = $(".passwordToggle").attr("type");
    // now test it's value
    if( type === 'password' ){
      $(".passwordToggle").attr("type", "text");
      $(".toggler").removeClass("fa-eye");
      $(".toggler").addClass("fa-eye-slash");

    }else{
      $(".passwordToggle").attr("type", "password");

      $(".toggler").removeClass("fa-eye-slash");
      $(".toggler").addClass("fa-eye");
    }
})


</script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/modernizr/js/css-scrollbars.js"></script>

<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/assets/js/common-pages.js"></script>


<script type="text/javascript" src="../files/bower_components/chart.js/js/Chart.js"></script>


<script src="{{ asset('webadmin') }}/assets/pages/widget/gauge/gauge.min.js"></script>
<script src="{{ asset('webadmin') }}/assets/pages/widget/amchart/amcharts.js"></script>
<script src="{{ asset('webadmin') }}/assets/pages/widget/amchart/serial.js"></script>
<script src="{{ asset('webadmin') }}/assets/pages/widget/amchart/gauge.js"></script>
<script src="{{ asset('webadmin') }}/assets/pages/widget/amchart/pie.js"></script>
<script src="{{ asset('webadmin') }}/assets/pages/widget/amchart/light.js"></script>

<script src="{{ asset('webadmin') }}/assets/js/pcoded.min.js"></script>
<script src="{{ asset('webadmin') }}/assets/js/vartical-layout.min.js"></script>
<script src="{{ asset('webadmin') }}/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/assets/pages/dashboard/crm-dashboard.min.js"></script>
<script type="text/javascript" src="{{ asset('webadmin') }}/assets/js/script.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote();
      });
</script>

