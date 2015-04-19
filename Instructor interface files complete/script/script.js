$(document).ready(function(){
	$('input:text, input:password').click(function(){
		$('#st-pwd, #st-id, #in-id, #in-pwd').popover('destroy'); //////////// Warnings
	});
    
	//$('#myTab li:eq(1) a').tab('show'); // Switching the tabs

	$('#basicModal').modal({backdrop: 'static', keyboard: false, show: false}); //////////// Modal dispaly, prevent from clicking outside
    $('#post-success').modal({backdrop: 'static', keyboard: false, show: false});
    
    $('.remove-file').click(function(){
        $("#upload-form2").filestyle('clear');
    });

	$("#btn1").click(function(){
		$('#st-lgn').show('slow');
		$('#btn1').addClass('disabled');
		$('#btn2').removeClass('disabled');
		$('#in-lgn').hide('slow');
		$('#st-pwd, #st-id, #in-id, #in-pwd').popover('destroy');
    });

    $("#btn2").click(function(){
    	$('#in-lgn').show('slow');
        $('#btn1').removeClass('disabled');
        $('#btn2').addClass('disabled');
        $('#st-lgn').hide('slow');
        $('#st-pwd, #st-id, #in-id, #in-pwd').popover('destroy');
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