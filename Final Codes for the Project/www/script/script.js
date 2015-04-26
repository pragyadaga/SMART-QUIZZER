$(document).ready(function(){
	$('input:text, input:password').click(function(){
		$('#st-id, #in-id').popover('destroy'); //////////// Warnings
	});

	$("#st-btn").click(function(){
		$('#st-lgn').show('slow');
		$('#st-btn').addClass('disabled');
		$('#in-btn').removeClass('disabled');
		$('#in-lgn').hide('slow');
		$('#st-id, #in-id').popover('destroy');
    });

    $("#in-btn").click(function(){
    	$('#in-lgn').show('slow');
        $('#st-btn').removeClass('disabled');
        $('#in-btn').addClass('disabled');
        $('#st-lgn').hide('slow');
        $('#st-id, #in-id').popover('destroy');
    });
});


//////////// Check for login details asynchronously

//////////// Login handler for student

function stLogin(){
    var formData={};
    formData.id=$('#st-id').val();
    formData.password=$('#st-pwd').val();
    formData.remember=$("#st-rem").prop('checked');
    
    if(formData.id && formData.password)
        $.post('/api/login/st-login/', formData, stLoginHandler);
    else
        $('#st-id').popover('show');

	return false;
}

function stLoginHandler(data,status){
    if(data=="nameError"){
        $('#st-id').popover('show');
        $('#st-pwd').val("");
    }
    else{
        location.reload();
    }
}


//////////// Login handler for instructor

function inLogin(){
    var formData={};
    formData.id=$('#in-id').val();
    formData.password=$('#in-pwd').val();
    formData.remember=$("#in-rem").prop('checked');
    
    if(formData.id && formData.password)
        $.post('/api/login/in-login/', formData, inLoginHandler);
    else
        $('#in-id').popover('show');
    
	return false;
}

function inLoginHandler(data,status){
    if(data=="nameError"){
        $('#in-id').popover('show');
        $('#in-pwd').val("");
    }
    else{
        location.reload();
    }
}

function addZero(num) {
    return (num >= 0 && num < 10) ? "0" + num : num + "";
}