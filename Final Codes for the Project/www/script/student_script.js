///////////////////////////// Scripts needed for student interface

$(document).ready(function(){
    today=new Date;
    temp={};
    $.post('/api/get_events/', temp, function(data, success){ ////////////////////// Get the list of quizzes
        $(".responsive-calendar").responsiveCalendar({
            time: today.getFullYear()+'-'+(today.getMonth()+1),
            events: JSON.parse(data),
            onDayClick: function(events){showEventDetails($(this));}
        });
    });
    
    $.post("/api/get_courses/", {"request" : "course"}, function(data,success){ ////////////////////// Get the list of courses
        //alert(data);
        a=data.split(',');
        $.unique(a);
        a.splice(-1,1);
        a.forEach(function(t){
               $('#select-course').append('<option>'+t+'</option>');
        });

        $("#select-course").selectpicker("refresh");
    });
    
    $('#view-result-for').change(function(){
        if($('#view-result-for').val()=="all")
            $('#select-course-div').hide('slow');
        else
            $('#select-course-div').show('slow');
    });
    
    quizTimer();
});

function showEventDetails(event){ ////////////////////// Display details of a quiz
    event_date={};
    event_date.day=addZero(event.data('day'));
    event_date.month=addZero(event.data('month'));
    event_date.year=event.data('year');
    
    $.post('/api/get_event_details/', event_date, function(data, success){
        if(data!=""){
            data=JSON.parse(data);
            
            $("#event-details").empty();
             $("#event-details").append('<div class="text-center"><b> Quizzes on '+data.tests[0].date+'</b></div>');
            data.tests.forEach(function(entry) {
                var event_time=entry.time.split(':');
                event_time=[[event_time[0] >= 12 ? addZero(event_time[0]-12) : event_time[0], addZero(event_time[1]), event_time[2]].join(":"), event_time[0] >= 12 ? "PM" : "AM"].join(" ");
                $("#event-details").append('<div id="quiz-details"><b> Time :</b> '+event_time+' <br><b> Subject :</b> '+entry.c_name); 
            });
        }
        else{
            $("#event-details").empty();
            $("#event-details").append("<div class='text-center text-danger'>( No events on the selected date )</div>");
        }   
    });
}

function changePass(){
    errc=0;   //////////// Current password error flag
    errnp=0;  //////////// New password error flag
   
    $('#cur-pass-err, #new-pass-1-err, #new-pass-2-err').text("");
    
    if($('#new-pass-1').val() != $('#new-pass-2').val()){
        errnp=1;
        $('#new-pass-2-err').text('Passwords do not match');
    }
    if($('#new-pass-1').val()==""){
        errnp=1;
        $('#new-pass-1-err').text('Cannot be empty');
    }
    else if($('#new-pass-1').val().length < 6){
        errnp=1;
        $('#new-pass-2-err').text('Password must contain minumum 6 charcters');
    }
    if($('#new-pass-2').val()==""){
        errnp=1;
        $('#new-pass-2-err').text('Cannot be empty');
    }
    else if($('#new-pass-2').val().length < 6){
        errnp=1;
        $('#new-pass-2-err').text('Password must contain minumum 6 charcters');
    }
    
    if($('#cur-pass').val()==""){
        errc=1;
        $('#cur-pass-err').text('Cannot be empty');
    }
    else{
        if(errc==0 && errnp==0){
            currPass={};
            currPass.cur_password=$('#cur-pass').val();
            currPass.new_password=$('#new-pass-1').val();
            
            $.post('/api/change_password/', currPass, function(data, success){ ////////////////////// Change the password
                if(data=="success")
                    $('#change-pass-success').modal('show');
                else
                    $('#cur-pass-err').text('Invalid password');
            });
        }  
    }

    return false;
}

function changeEmail(){
    errp=0;   //////////// Password error flag
    errm=0;  //////////// Email error flag
   
    $('#new-email-err, #new-email-pass-err').text("");
    
    if($('#new-email-pass').val()==""){
        errp=1;
        $('#new-email-pass-err').text('Cannot be empty');
    }
    
    if($('#new-email').val()==""){
        errm=1;
        $('#new-email-err').text('Cannot be empty');
    }
    else if($('#new-email').val().length < 6){
        errm=1;
        $('#new-email-err').text('Invalid email');
    }
    
    else{
        if(errp==0 && errm==0){
            mailData={};
            mailData.password=$('#new-email-pass').val();
            mailData.new_email=$('#new-email').val();
            
            $.post('/api/change_email/', mailData, function(data, success){ ////////////////////// Change the email
                if(data=="success")
                    $('#change-email-success').modal('show');
                else
                    $('#new-email-pass-err').text('Invalid password');
            });
        }  
    }
    return false;
}

function quizTimer(){
    $('#upcoming-quiz-details').empty();
    
    $('#upcoming-quiz-details').append('<iframe src="/api/get_upcoming_quizzes/index.php" id="upcoming-quiz-frame"></iframe>');
    setTimeout(quizTimer, 10000); ////////////////////// Show a list of upcoming quizzes
}

function showResults(){
    var course_id=$('#select-course').val();
    if($('#view-result-for').val()=="all"){
        if($('#view-as').val()=="graph"){ ////////////////////// Show results as graph
            $('#result-div').empty();
            $('#result-div').append('<iframe src="/api/get_results/for_student/1/graph/index.php" id="result-frame" height="300" width="600"></iframe>');
        }
        else{  ////////////////////// Show results as a table
            $('#result-div').empty();
            $('#result-div').append('<iframe src="/api/get_results/for_student/1/table/index.php" id="result-table-frame" height="300" width="600"></iframe>');
        }
    }
    else{
        if($('#view-as').val()=="graph"){
            $('#result-div').empty();
            $('#result-div').append('<iframe src="/api/get_results/for_student/2/graph/index.php?course='+course_id+'" id="result-frame" height="300" width="600"></iframe>');
        }
        else{
            $('#result-div').empty();
            $('#result-div').append('<iframe src="/api/get_results/for_student/2/table/index.php?course='+course_id+'" id="result-table-frame" height="300" width="620"></iframe>');
        }
    }
}