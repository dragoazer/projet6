class DisplayGameForum {
	constructor () {
		this.ddbCall(false,0,10);
		this.modifDisplayTopic();
	}

	modifDisplayTopic ()
	{
		$("input[name='maxPerPage'], input[name='search']").on("change", (e)=>{

		});

	}

	ddbCall (search, min, max)
	{
		$.ajax({
			url: 'index.php?action=searchGameForum',
			type: 'POST',
			data: {
				search: search,
				min: min,
				max: max
			},
			complete: function(response)
			{	
				console.log(response);
				let datas = response.responseText;
				console.log(datas);
				datas = JSON.parse(datas);
				console.log(datas);
				for (let data of datas) {
					$("#displayTopic").append("<li>"+data.title+"</li>")
				}
			},

			error: function()
			{
				$("#displayTopic").append("<li>Aucune données à afficher.</li>")
			}

		});
	}
}