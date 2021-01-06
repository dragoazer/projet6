class DisplayGameForum {
	constructor () {
		this.searchGesture();
		this.ddbCall(0,10);
		this.maxPage(10, null, null);
		this.modifDisplayTopic();
		this.actualPage = 1;
	}

	modifDisplayTopic ()
	{
		$("#maxPerPage").on("change", (e)=>{
			let max = $("#maxPerPage").val();
			$(".page").empty();
			this.maxPage(max, null, null);
			this.ddbCall(0,max);
		});

	}

	ddbCall (min, max)
	{
		$.ajax({
			url: 'index.php?action=searchGameForum',
			type: 'POST',
			data: {
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
		$.ajax({
			context: this,
			url: 'index.php?action=maxPageGame',
			type: 'POST',
			data: {
				max: topicPerPage,
			},
			complete: function(response)
			{	
				let maxPage = response.responseText;
				if (maxPage > 1){
					$(".page").empty();
					for (var i = 1; i <= maxPage; i++) {
						$(".page").append("<button class='pageButton' id='"+i+"'>"+i+"</button>");
						let z = i;
						$("#"+i+"").on("click", (e)=>{
							if (z != this.actualPage) {
								this.actualPage = z;
								let min = z * topicPerPage - topicPerPage;
								let max = z * topicPerPage;
								this.ddbCall(min,max);
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

	searchGesture ()
	{
		$("#searchButton").on("click", (e)=>{
			e.preventDefault();
			let search = $("input[name=search]").val();
			
			$.ajax({
				context: this,
				url: 'index.php?action=searchForGame',
				type: 'POST',
				data: {
					search: search,
				},
				complete: function(response)
				{
					let text = response.responseText;
					if (text != '"error"') {
						$(".page").empty();
						let datas = JSON.parse(text);
						$("#displayTopic").empty();
						for (let data of datas) {
							$("#displayTopic").append("<li>"+data.title+" "+data.editor+" "+data.creation_topic+" <a href='index.php?action=ShowTopicGame&id="+data.id+"'><button>VOIR</button></a></li>")
						}
					} else {
						$(".page").empty();
						$("#displayTopic").empty();
						$("#displayTopic").append("<p>Aucune données à afficher.</p>");
					}
				}
			});
		});	
	}
}