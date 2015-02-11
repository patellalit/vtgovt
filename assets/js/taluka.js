// JavaScript Document
function checkvalidation()
{
	if($('#jilla_id').val() == '')
	{
		alert("Please select jillo");
		return false;
	}
	if($('#taluka_name').val() == '')
	{
		alert("Please enter taluka");
		return false;
	}
	if($('#taluka_name_guj').val() == '')
	{
		alert("Please enter taluka");
		return false;
	}
	$('#frm').submit();	
}