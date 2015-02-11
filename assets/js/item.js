// JavaScript Document
function checkvalidation()
{
	if($('#item_name').val() == '')
	{
		alert("Please enter item");
		return false;
	}
	$('#frm').submit();	
}