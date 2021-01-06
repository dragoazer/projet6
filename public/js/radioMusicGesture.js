class RadioMusicGesture {
	constructor ()
	{
		this.actualRadsioMusic();
	}

	actualRadsioMusic () 
	{
		$.ajax({
			url: 'index.php?action=actualRadioMusic',
			type: 'GET',
			complete: function(response) 
			{		
				var text = response.responseText;
				if (text != "error") {
					
				}
			}
		});
	}
}