$(document).ready(function () {
    tinymce.init({
        selector: '#message_body',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '+1d'
    });

    $('.start_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '+1d'
    });

    $('.end_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '+1d'
    });

    $('.reg_start_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '+1d'
    });

    $('.reg_end_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '+1d'
    });

    $('#start_time').datetimepicker({
        format: 'HH:ss'
    });

    $('#end_time').datetimepicker({
        format: 'HH:ss'
    });

    $('#session_id').change(function () {
        var session_id = $('#session_id').val();

        if (session_id > 0 && session_id != '' && session_id != undefined && session_id != null) {
            $.ajax(url + "outline/getOutlineTimeTable/" + session_id )
                .done(function(result) {
                    $('#outline_id').html(result);
                })
                .fail(function() {
                    $('#outline_id').html('<option value="">-- Select Option --</option>');
                })
                .always(function() {
                    // this will ALWAYS be executed, regardless if the ajax-call was success or not
                });
        }
    });

    $('#get_student_session_id').change(function () {
        var session_id = $('#get_student_session_id').val();

        if (session_id > 0 && session_id != '' && session_id != undefined && session_id != null) {
            $.ajax(url + "message/getStudentinSession/" + session_id )
                .done(function(result) {
                    $('#receiver_id').html(result);
                })
                .fail(function() {
                    $('#receiver_id').html('<option value="">-- Select Option --</option>');
                })
                .always(function() {
                    // this will ALWAYS be executed, regardless if the ajax-call was success or not
                });
        }
    });

    $('#feedback_session_id').change(function () {
        var session_id = $('#feedback_session_id').val();

        if (session_id > 0 && session_id != '' && session_id != undefined && session_id != null) {
            $.ajax(url + "feedback/getFacilatorsForSession/" + session_id )
                .done(function(result) {
                    $('#facilitator_id').html(result);
                })
                .fail(function() {
                    $('#facilitator_id').html('<option value="">-- Select Option --</option>');
                })
                .always(function() {
                    // this will ALWAYS be executed, regardless if the ajax-call was success or not
                });
        }
    });

    $("#has_prerequisite").click(function () {
        var display = $("#has_prerequisite").val();

        if (display == 1) {
            $("#course_options").show();
        } else {
            $("#course_options").hide();
        }

    });

    $("#add_course_form").validate();
    
//    $("button").addClass("btn btn-primary");
//   alert('Here');
});