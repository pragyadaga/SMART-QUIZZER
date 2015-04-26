//////////// Check for login details asynchronously

//////////// Login handler for admin

function adminLogin(){
    formData={};
    $('#admin-id').popover('destroy');
    formData.id=$('#admin-id').val();
    
    formData.password=$('#admin-pwd').val();
    
    formData.remember=$("#admin-rem").prop('checked');
    
    if(formData.id && formData.password)
        $.post('/api/login/ad-login/', formData, adminLoginHandler);
    else
        $('#admin-id').popover('show');
    
	return false;
}

function adminLoginHandler(data,status){
    if(data=="nameError"){
        $('#admin-id').popover('show');
        $('#admin-pwd').val("");
    }
    else{
        location.reload();
    }
}

function regStudent(){ ////////////////////////// Add a new student
    err_u=0;
    err_n=0;
    err_e=0;
    err_cl=0;
    err_co=0;
    
    $('#usn-err, #st-name-err, #st-email-err, #st-class-err, #st-course-err').text("");
    
	if($('#usn').val()==""){
        err_u=1;
        $('#usn-err').text("Can't be empty");
    }
    if($('#st-name').val()==""){
        err_n=1;
        $('#st-name-err').text("Can't be empty");
    }
    if($('#st-email').val()==""){
        err_e=1;
        $('#st-email-err').text("Can't be empty");
    }
    if($('#st-class').val()==""){
        err_cl=1;
        $('#st-class-err').text("Can't be empty");
    }
    if($('#st-course').val()==""){
        err_co=1;
        $('#st-course-err').text("Can't be empty");
    }
    
    if(err_u==0 && err_n==0 && err_e==0 && err_cl==0 && err_u==0 && err_co==0){
        studData={};
        studData.usn=$('#usn').val()
        studData.name=$('#st-name').val()
        studData.email=$('#st-email').val()
        studData.class=$('#st-class').val()
        studData.course=$('#st-course').val()
        
        $.post('/api/add_student/', studData, function(data, success){
            if(data=="USN")
                $('#usn-err').text("already exists");
            if(data=="Email")
                $('#st-email-err').text("already registered");
            if(data=="Class")
                $('#st-class-err').text("There's no such class");
            if(data=="Course")
                $('#st-course-err').text("Courses entered Doesn't exists");
            if(data=="ok")
                $('#post-success').modal('show');
        });
    }
    
    return false;
}


function regInstructor(){ ////////////////// Add a new instructor
    err_u=0;
    err_n=0;
    err_e=0;
    err_cl=0;
    err_co=0;
    
    $('#in-err, #in-name-err, #in-email-err, #in-class-err, #in-course-err').text("");
    
	if($('#i_id').val()==""){
        err_u=1;
        $('#in-err').text("Can't be empty");
    }
    if($('#in-name').val()==""){
        err_n=1;
        $('#in-name-err').text("Can't be empty");
    }
    if($('#in-email').val()==""){
        err_e=1;
        $('#in-email-err').text("Can't be empty");
    }
    if($('#in-class').val()==""){
        err_cl=1;
        $('#in-class-err').text("Can't be empty");
    }
    if($('#in-course').val()==""){
        err_co=1;
        $('#in-course-err').text("Can't be empty");
    }
    
    if(err_u==0 && err_n==0 && err_e==0 && err_cl==0 && err_u==0 && err_co==0){
        instructorData={};
        instructorData.id=$('#i_id').val()
        instructorData.name=$('#in-name').val()
        instructorData.email=$('#in-email').val()
        instructorData.class=$('#in-class').val()
        instructorData.course=$('#in-course').val()
        
        $.post('/api/add_instructor/', instructorData, function(data, success){
           // alert(data);
            if(data=="i_id")
                $('#in-err').text("already exists");
            if(data=="Email")
                $('#in-email-err').text("already registered");
            if(data=="Class")
                $('#in-class-err').text("There's no such class");
            if(data=="Course")
                $('#in-course-err').text("Courses entered Doesn't exists");
            if(data=="took")
                $('#in-course-err').text("Specify Course and class is taken by Some other Instructor");
            if(data=="ok")
                $('#reg-success').modal('show');
        });
    }
    
    return false;
}