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

function activateCarousel(machineId)
{
	jQuery('#carousel' + machineId +'').jcarousel({
		vertical: false,
		scroll: 1,
		visible: 2
	});
}