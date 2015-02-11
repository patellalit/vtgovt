// JavaScript Document
function checkvalidation()
{
	if($('#jilla_id').val() == '')
	{
		alert("Please select jillo");
		return false;
	}
	if($('#taluka_id').val() == '')
	{
		alert("Please select taluka");
		return false;
	}
	if($('#gaam_name').val() == '')
	{
		alert("Please enter gaam");
		return false;
	}
	if($('#gaam_name_guj').val() == '')
	{
		alert("Please enter gaam");
		return false;
	}
	$('#frm').submit();	
}
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

           },
           error: function(jqXHR, textStatus, errorThrown)
           {
           		alert("error"+textStatus);           
           }
    });
}