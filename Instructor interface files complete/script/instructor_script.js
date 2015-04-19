$(document).ready(function(){
    $('#result-btn').addClass('disabled');
    
    $('#change-pass-success').modal({backdrop: 'static', keyboard: false, show: false}); //////////// Modal dispaly, prevent from clicking outside
    
    today=new Date;
    temp={};
    $.post('/api/get_events/', temp, function(data, success){ ////////////////////// Get the list of quizzes
        $(".responsive-calendar").responsiveCalendar({
            time: today.getFullYear()+'-'+(today.getMonth()+1),
            events: JSON.parse(data),
            onDayClick: function(events){showEventDetails($(this));}
        });
    });
    
    $("#upload-form").click(function(){
         $("#error-file-text").text("");
    });
    
    $('#datetimepicker1').datetimepicker();
    
    $(".ques-text").each(function(){ //////////// Get the questions
        if($(this).val()=="")
            errq=1;
        quesData.questions[i]={};
        quesData.questions[i].ques=$(this).val();
        i++;
    });
    
    $('.close-modal').click(function(){ //////////// Remove all the question elements when the modal is closed
       $(".ques-text").each(function(){
           $(this).parent().parent().remove();
       });
       $(".ans-text").each(function(){
           $(this).parent().parent().remove();
       });
       $('#date-error').text("");
       $('#ques-error').text("");
    });
    
    
    ///////////// Populate the first selector
    $.post("/api/get_courses/", {"request" : "course"}, function(data,success){
        //alert(data);
        a=data.split(',');
        $.unique(a);
        a.splice(-1,1);
        a.forEach(function(t){
               $('#select-course').append('<option>'+t+'</option>');
        });

        $("#select-course").selectpicker("refresh");
    });
    
    $('#select-course-result').html('');
    $.post("/api/get_courses/", {"request" : "course"}, function(data,success){
        //alert(data);
        a=data.split(',');
        $.unique(a);
        a.splice(-1,1);
        a.forEach(function(t){
               $('#select-course-result').append('<option>'+t+'</option>');
        });

        $("#select-course-result").selectpicker("refresh");
    });
    
    //////////// Change the second selectors
    $("#select-course").change(function(event){
        $("#select-class").removeAttr("disabled");
        $("#select-class").selectpicker("refresh");
        $('#select-class').html('');
        
        quesData={} //////////// The questions data to be inserted to the database
        var formData={}
        formData.course_id=$("#select-course").val()[0]
        quesData.course_id=formData.course_id;

        $.post("/api/get_classes/", formData, function(data,success){
            //alert(data);
            a=data.split(',');
            a.splice(-1,1);
            a.forEach(function(t){
                   $('#select-class').append('<option>'+t+'</option>');
            });
            $("#select-class").selectpicker("refresh");
        });
    });
    
    $("#select-course-result").change(function(event){
        $("#select-class-result").removeAttr("disabled");
        $("#select-class-result").selectpicker("refresh");
        $('#select-class-result').html('');
        
        quesData={} //////////// The questions data to be inserted to the database
        var formData={}
        formData.course_id=$("#select-course-result").val()[0]
        quesData.course_id=formData.course_id;

        $.post("/api/get_classes/", formData, function(data,success){
            //alert(data);
            a=data.split(',');
            a.splice(-1,1);
            a.forEach(function(t){
                   $('#select-class-result').append('<option>'+t+'</option>');
            });
            $("#select-class-result").selectpicker("refresh");
            $('#result-btn').removeClass('disabled');
        });
    });
    
    //////////// View the results
    $('#result-btn').click(function(){
        $('#class-result-graph').empty();
        if($("#view-result-type").val()=="graph"){
            $('#class-result-graph').append('<iframe src="/api/get_results/for_instructor/1/graph/index.php?course='+$('#select-course-result').val()+'&class='+$('#select-class-result').val()+'" height="370" width="600" style="border:0;"></iframe>');
        }
        else{
            $('#class-result-graph').append('<iframe src="/api/get_results/for_instructor/1/table/index.php?course='+$('#select-course-result').val()+'&class='+$('#select-class-result').val()+'" height="370" width="600" style="border:0; margin-top:25px;"></iframe>');
        }
    });
    
    /////////////////////// For indivisual results
    $.post("/api/get_courses/", {"request" : "course"}, function(data,success){
        //alert(data);
        a=data.split(',');
        $.unique(a);
        a.splice(-1,1);
        a.forEach(function(t){
               $('#select-course-result-1').append('<option>'+t+'</option>');
        });

        $("#select-course-result-1").selectpicker("refresh");
    });
    $("#select-course-result-1").change(function(event){
        $("#select-class-result-1").removeAttr("disabled");
        $("#select-class-result-1").selectpicker("refresh");
        $('#select-class-result-1').html('');
        
        quesData={} //////////// The questions data to be inserted to the database
        var formData={}
        formData.course_id=$("#select-course-result-1").val()[0]
        quesData.course_id=formData.course_id;

        $.post("/api/get_classes/", formData, function(data,success){
            //alert(data);
            a=data.split(',');
            a.splice(-1,1);
            a.forEach(function(t){
                   $('#select-class-result-1').append('<option>'+t+'</option>');
            });
            $("#select-class-result-1").selectpicker("refresh");
        });
    });
    
    $("#view-result-for").change(function(event){
        //alert($("#view-result-for").val());
        if($("#view-result-for").val()=="indivisual"){
            $('#select-class-div').hide('slow');
            $('#usn-div').show('slow');
        }
        else{
            $('#usn-div').hide('slow');
            $('#select-class-div').show('slow');
        }
    });
    
    //////////// Add a question
    
    $('.add-more').click(function(){
       $("#ques-edit").append("<div class='row my-row'><div class='col-sm-8'><textarea class='form-control ques-text' rows='2' placeholder='Question'></textarea></div><div class='col-sm-3'><input type='text' class='form-control ans-text' placeholder='Answer'></div><span class='col-sm-1 glyphicon glyphicon-remove remove-ques'></span></div>");
    });
    
    //////////// Remove a question
    $(document).on("click", '.remove-ques', function(){
        $(this).parent().remove();
    });
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
                event_time=[[event_time[0] >= 12 ? addZero(event_time[0]-12) : event_time[0], addZero(event_time[1]), event_time[2]].join(":"), event_time[1] >= 12 ? "PM" : "AM"].join(" ");
                
                $("#event-details").append('<div id="quiz-details"><b> Time :</b> '+event_time+' <br><b> Subject :</b> '+entry.c_name+' <br><b> Class :</b> '+entry.class_id+'</div>'); 
            });
        }
        else{
            $("#event-details").empty();
            $("#event-details").append("<div class='text-center text-danger'>( No events on the selected date )</div>");
        }   
    });
}

function uploadQuestions(){
    minQues=3; //////////// Minimun number of questions
    var errt=0; //////////// Invalid filetype
    var errs=0; //////////// File size
    var errpg=0; //////////// Page numbers
    
    var start_page;
    var end_page;
    
    $("#upload-btn").text("Uploading...");
    $("#error-select-text, #error-page-number").text("");
    
    if($("#select-course").val()==null || $("#select-class").val()==null){
            $("#error-select-text").text("Select course and respective classes");
            errt=1;
    }
    if(($('#start-page').val()>=0 || $('#start-page').val()=="" )&& ($('#end-page').val()>=0 || $('#end-page').val()=="" )){
        if($('#start-page').val() > $('#end-page').val()){
            errpg=1;
            $("#error-page-number").text('Invalid page numbers');
        }
        if($('#start-page').val()=="")
            start_page="NULL"
        else
            start_page=$('#start-page').val();
        
        if($('#end-page').val()=="")
            end_page="NULL"
        else
            end_page=$('#end-page').val();
    }
    else{
        errpg=1;
        $("#error-page-number").text('Invalid page numbers');
    }
    if($("#upload-form").val()!=""){
        $("#error-file-text").text("");
        
        filename=$("#upload-form")[0].files[0].name
        filetype=filename.split('.');
        filetype=filetype[filetype.length-1];
        
        if(filetype!="pdf" && filetype!="txt" && filetype!="doc"){ //////////// Check for file types
            $("#error-file-text").text("Please select only PDF, Text and Doc files");
            errt=1;
        }
        if(document.getElementById('upload-form').files[0].size>5000000){  //////////// Check for file size
            $("#error-file-text").text("File size can't be greater than 5MB");
            errt=1;
        }
    }
    else{
        $("#error-file-text").text("Please select a file to upload");
         errt=1;
    }
    
    if($("#upload-form2").val()!=""){
        $("#error-file-text2").text("");
        filename2=$("#upload-form2")[0].files[0].name
        filetype2=filename2.split('.');
        filetype2=filetype2[filetype2.length-1];
        
        if(filetype2!="pdf" && filetype2!="txt" && filetype2!="doc"){ //////////// Check for file types
            $("#error-file-text2").text("Please select only PDF, Text and Doc files");
            errt=1;
            errs=1;
        }
        if(document.getElementById('upload-form2').files[0].size>5000000){  //////////// Check for file size
            $("#error-file-text2").text("File size can't be greater than 5MB");
            errt=1;
            errs=1;
        }
    }
    else
        errs=1;
    
    if(errt==0 && errpg==0){
        genQues={};
        dateData={};
        genQues.file1=filename;
        
        genQues.start_page=start_page;
        genQues.end_page=end_page;
        
        
        quesData.class_id=$("#select-class").val();
        dateData.class_id=$("#select-class").val();
 
        file_data = $('#upload-form').prop('files')[0];
        form_data = new FormData();
        form_data.append('file1', file_data);
        
        if(errs==0){
            genQues.file2=filename2;
            file_data2 = $('#upload-form2').prop('files')[0]; 
            form_data.append('file2', file_data2);
        }
        //////////// Upload the file

        $.ajax({
            url: '/upload/',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response){
               // alert(php_script_response);
            }
        });

       
        
        $('#basicModal').modal('show');
        //////////// Get the questions back in JSON format from the NLTK script
        //////////// 
        
        
        //////////// Call the NLTL script to generate questions
        //////////// Pass the names of the files
        
        $('#questions-header').text('Please wait... Questions are being generated...');
        $.post('/api/generate_questions/', genQues, function(data, success){
            $('#questions-header').text('Questions to be submitted');
            //alert(data);
            temp_data=data;
        
            if(temp_data.split(' ')[0].localeCompare("Please")==0){
                $("#error-file-text").text("Please input a bigger file or give more number of pages");
                closeModal();
                return;
            }
            
            jsonData=JSON.parse(data);
            
            for(i=0; i<jsonData.questions.length; i++){
                $("#ques-edit").append("<div class='row my-row'><div class='col-sm-8'><textarea class='form-control ques-text' rows='2'>"+jsonData.questions[i].ques+"</textarea></div><div class='col-sm-3'><input type='text' class='form-control ans-text' value='"+jsonData.questions[i].ans+"'></div><span class='col-sm-1 glyphicon glyphicon-remove remove-ques'></span></div>");
            }
        });
        //////////// Post
//        $(":file").filestyle('clear'); 
        }
    $("#upload-btn").text("Upload");
}

function validateQuestions(){
    //////////// Display the questions
    //////////// Make changes to the questions
    
    errq=0; //////////// Invalid questions
    errd=0; //////////// Invalid date
    errn=0; //////////// Invalid number of questions
    
    $("#ques-error").text("");
    $('#date-error').text("");
    
    quesData.questions=new Array();
    
    //////////// Validate the input
    //////////// Upload the questions to the database
   
    var i=0;
    $(".ques-text").each(function(){ //////////// Get the questions
        if($(this).val()=="")
            errq=1;
        quesData.questions[i]={};
        quesData.questions[i].ques=$(this).val();
        i++;
    });
    var i=0;
    $(".ans-text").each(function () { //////////// Get the answers
        if($(this).val()==""){
            errq=2;
        }
        quesData.questions[i].ans=$(this).val();
        i++;
    });
    
    if(i<minQues){
        $("#ques-error").text("Must contain minimum 20 questions. ");
        errq+=1;
    }
    
    if(errq>=2){
        $("#ques-error").text($("#ques-error").text()+"  Questions / Answers should not be empty");
    }
    
    if($('#date-time').val()==''){
        errd=1;
        $('#date-error').text("Date and time should be specified.");
    }
    else{ //////////// check whether its a future date or not
        date_time=$('#date-time').val();
        var now=new Date();
        var current_time=[[addZero(now.getMonth() + 1), addZero(now.getDate()), now.getFullYear()].join("/"), [now.getHours() >= 12 ? now.getHours()-12 : now.getHours(), addZero(now.getMinutes())].join(":"), now.getHours() >= 12 ? "PM" : "AM"].join(" ");

        if(date_time.localeCompare(current_time)<=0){
            //////////// Not future date
            errd=1;
            $('#date-error').text("Please select a future date and time");
        }
        else{ //////////// Check for the date collisions
            
            dateData.date=date_time;
            quesData.date=date_time;
            
            $.post('/api/date_validate/', dateData, function(data, success){
                if(data!='valid'){
                    errd=1;
                    $('#date-error').text("Tests are already assigned on that time for the given class");
                }
                else{
                    if(errd==0 && errq==0){ //////////// Upload the questions
                        $.post('/api/post_quiz/', quesData, function(data, success){
                            //alert(data)
                            $('#quiz-date').text(date_time);
                            $('#post-success').modal('show');
                        });
                    }
                }
            });
        }
    }
     //////////// Notify the students through email
}

function clearEventList(){
    $("#event-details").empty();
    $("#event-details").append('<div class="text-center text-danger">( Please select a date )</div>');
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
            
            $.post('/api/change_password/', currPass, function(data, success){
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
            
            $.post('/api/change_email/', mailData, function(data, success){
                if(data=="success")
                    $('#change-email-success').modal('show');
                else
                    $('#new-email-pass-err').text('Invalid password');
            });
        }  
    }

    return false;
}

function viewIndivisualResult(){
    $('#indivisual-result-graph').empty();
    errc=0;
    erru=0;
    $('#course-error, #usn-error').text('');
    if($('#view-result-for').val()=="indivisual"){
        if($('#select-course-result-1').val()==null){
            errc=1;
            $('#course-error').text('Please select a course');
        }
        if($('#usn').val()==""){
            erru=1;
            $('#usn-error').text('Please enter a USN');
        }
        else{
            usnResult={};
            usnResult.usn=$('#usn').val();
            usnResult.course_=$('#select-course-result-1').val()[0];
            
            $.post('/api/validate_usn/', usnResult, function(data, success){
                if(data=="invalid"){
                    erru=1;
                    $('#usn-error').text("Doesn't exist");
                }
                else if(data=="notexist"){
                    erru=1;
                    $('#usn-error').text("Doesn't belong to the given course");
                }
                else{
                    if(errc==0 && erru==0){
                        $('#indivisual-result-graph').append('<iframe src="/api/get_results/for_instructor/2/graph/index.php?course='+$('#select-course-result-1').val()+'&usn='+$('#usn').val()+'" height="370" width="600" style="border:0;"></iframe>');
                    }
                }
            });
        }
    }
    else{
        if($('#select-course-result-1').val()==null){
            $('#course-error').text('Please select a course');
        }
        else{
            allResult={};
            allResult.course=$('#select-course-result-1').val()[0];
            allResult.class=$('#select-class-result-1').val();
            $('#indivisual-result-graph').append('<iframe src="/api/get_results/for_instructor/2/table/index.php?course='+allResult.course+'&class='+allResult.class+'" height="370" width="600" style="border:0;"></iframe>');
            
        }
    }
}

function closeModal(){ //////////// Remove all the question elements when the modal is closed
   $('#basicModal').modal('hide');
   $(".ques-text").each(function(){
       $(this).parent().parent().remove();
   });
   $(".ans-text").each(function(){
       $(this).parent().parent().remove();
   });
   $('#date-error').text("");
   $('#ques-error').text("");
}