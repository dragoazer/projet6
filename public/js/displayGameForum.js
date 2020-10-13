class DisplayGameForum {
	constructor () {
		this.ddbCall(false,0,10);
		this.maxPage(10);
		this.modifDisplayTopic();
		this.actualPage = 1;
	}

	modifDisplayTopic ()
	{
		$("#maxPerPage").on("change", (e)=>{
			let max = $("#maxPerPage").val();
			$(".page").empty();
			this.ddbCall(false,0,max);
			this.maxPage(max);
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
				let text = response.responseText;
				if (text != '"error"') {
					let datas = JSON.parse(text);
					$("#displayTopic").empty();
					for (let data of datas) {
						$("#displayTopic").append("<li>"+data.title+" "+data.editor+" "+data.creation_topic+" <a href='index.php?action=ShowTopicGame&id="+data.id+"'><button>VOIR</button></a></li>")
					}
				} 
			},

			error: function()
			{
				$("#displayTopic").append("<li>Aucune données à afficher.</li>")
			}

		});
	}

	maxPage (topicPerPage)
	{
		const that = this;
		$.ajax({
			url: 'index.php?action=maxPageGame',

			complete: function(response)
			{	
				let maxPage = response.responseText;
				console.log(maxPage);
				if (maxPage > 1){
					for (var i = 1; i <= maxPage; i++) {
						$(".page").append("<button class='pageButton' id='"+i+"'>"+i+"</button>");
						let z = i;
						$("#"+i+"").on("click", (e)=>{
							if (z != this.actualPage) {
								let min = z * topicPerPage - topicPerPage;
								let max = z * topicPerPage;
								that.ddbCall(false,min,max);
								this.actualPage = z;
							}
						});
					}
				}
			},

			error: function()
			{
				$(".page").append("<li>Aucune page à afficher.</li>");
			}

		});
	}
}