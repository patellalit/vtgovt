// JavaScript Document
function checkvalidation()
{
	if($('#jilla_name').val() == '')
	{
		alert("Please enter jillo");
		return false;
	}
	if($('#jilla_name_guj').val() == '')
	{
		alert("Please enter jillo");
		return false;
	}
	$('#frm').submit();	
}