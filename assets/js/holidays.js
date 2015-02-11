// JavaScript Document
function checkvalidation()
{
	if($('#holiday_name').val() == '')
	{
		alert("Please enter holiday");
		return false;
	}
	if($('#holiday_date').val() == '')
	{
		alert("Please enter date");
		return false;
	}
	$('#frm').submit();	
}