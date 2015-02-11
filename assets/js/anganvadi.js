// JavaScript Document
function fetchTaluko(jiloid,url){
	//alert(url+'?jilloid='+jiloid);
	$.ajax({
           url : url+'?jilloid='+jiloid,
           type: "POST",
           data : '',
           success:function(data, textStatus, jqXHR)
           {
				//alert(data);
				$('#taluka_id').html(data);
				$('#gaam_id').html('');
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
           		alert("error"+textStatus);           
           }
    });
}
function fetchGaam(gaam_id,url){
//	alert(url+'?gaam_id='+gaam_id);
	$.ajax({
           url : url+'?gaam_id='+gaam_id,
           type: "POST",
           data : '',
           success:function(data, textStatus, jqXHR)
           {
	//			alert(data);
				$('#gaam_id').html(data);
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
           		alert("error"+textStatus);           
           }
    });
}
function fetchAanganvadi(aanganvadi_id,url){
//	alert(url+'?gaam_id='+gaam_id);
	$.ajax({
           url : url+'?aanganvadi_id='+aanganvadi_id,
           type: "POST",
           data : '',
           success:function(data, textStatus, jqXHR)
           {
				//alert(data);
				$('#aanganvadi_id').html(data);
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
           		alert("error"+textStatus);           
           }
    });
}

function checkvalidation()
{
	if($('#jilla_id').val() == '')
	{
		alert("Please select jillo");
		return false;
	}
	if($('#taluka_id').val() == '')
	{
		alert("Please select taluko");
		return false;
	}
	if($('#gaam_id').val() == '')
	{
		alert("Please select gaam");
		return false;
	}
	if($('#aanganvadi_name').val() == '')
	{
		alert("Please enter aanganvadi name");
		return false;
	}
	if($('#aanganvadi_number').val() == '')
	{
		alert("Please enter aanganvadi number");
		return false;
	}
	if($('#place').val() == '')
	{
		alert("Please enter place");
		return false;
	}
	if($('#address').val() == '')
	{
		alert("Please enter address");
		return false;
	}
	if($('#karyakar_name').val() == '')
	{
		alert("Please enter karyakar name");
		return false;
	}
	if($('#karyakar_number').val() == '')
	{
		alert("Please enter karyakar number");
		return false;
	}
	if($('#tedagara_name').val() == '')
	{
		alert("Please enter tedagara name");
		return false;
	}
	if($('#tedagara_number').val() == '')
	{
		alert("Please enter tedagara number");
		return false;
	}
	$('#frm').submit();
	
	
}