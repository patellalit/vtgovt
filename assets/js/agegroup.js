// JavaScript Document
function checkvalidation()
{
	if($('#agegroup_name').val() == '')
	{
		alert("Please enter agegroup name");
		return false;
	}
	
	$('#frm').submit();	
}