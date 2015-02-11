// JavaScript Document
function checkvalidation()
{
	if($('#agegroup_id').val() == '')
	{
		alert("Please select agegroup");
		return false;
	}
	if($('#activities_name').val() == '')
	{
		alert("Please enter activities");
		return false;
	}
	
	$('#frm').submit();	
}