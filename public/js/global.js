$.version = "?v=0.01";
$.rootName = 'fileupd';

function displayNextFileUpload()
{
	$("input[type='file']").change(function(e){
		var name = $(this).attr('name');
		var fileUpdNr = name.substring(name.length - 1, name.length);
		fileUpdNr++;
		var nextFileUpdName = 'fileupd'.concat(fileUpdNr);
		
		var inputValue = $(this).val();
		
		if(inputValue != null && inputValue != "" && fileUpdNr < 7)
		{
			$("input[name='" + nextFileUpdName + "']").removeAttr('disabled');
		}
	});	
}

function disableAdditionalInputFiles()
{		
	$("input[type='file']").each(function(index)
	{
		var name = $(this).attr('name');
		if (name != "fileupd1") {
			$(this).attr("disabled", true);
		}
	});
}

function enableAllInputFiles()
{	
	$('#submitUploadedPhotos').click(function() 
	{		
		$("input[type='file']").each(function(index)
		{
			$(this).removeAttr('disabled');
		});
	});		
}

function activateCarousel(machineId)
{
	jQuery('#carousel' + machineId +'').jcarousel({
		vertical: false,
		scroll: 1,
		visible: 2
	});
}

function refreshCss()
{
	var currentUrl = document.URL;
	
	if(currentUrl.indexOf($.version) == -1)
	{
		window.location.replace(currentUrl + $.version);	
	}	
}

function deleteConfirmation() 
{
	 $(document).ready(function() {
		   
		 $("input[type='submit'][value='Delete']").bind('click', function() {
			 
			 var x = $(this).parents(".left").siblings(".right").find("span.machineName").first().html();
			    if(!confirm("Do you want delete machine: '" + x + "'") )
			        return false;				
		 });		 
	 });

	
	
}