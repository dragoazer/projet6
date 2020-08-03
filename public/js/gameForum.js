class GameForum {
	
	constructor ()
	{
		this.verifForm();
		this.general = new General;
	}

	verifForm ()
	{
		$("#sendForm").on("click", (e)=>{
			e.preventDefault();

			let error = false;
			let errorMsg = '';

			$("input[name='name']").css("border","");
			$("input[name='creator']").css("border","");
			$("input[name='content']").css("border","");
			$("input[name='title']").css("border","");

			$(".error").remove();
			$(".valid").remove();

			let title = $("input[name='title']").val();
			let name = $("input[name='name']").val();
			let creator = $("input[name='creator']").val();
			let content = $("input[name='content']").val();

			if (this.general.emptyTest(name) || name.length > 50) {
				error = true;
				errorMsg = "Le nom du jeu n'est pas renseigné ou trop long";
				$("input[name='name']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(creator) || creator.length > 50) {
				error = true;
				errorMsg = "Le nom de l'entreprise n'est pas renseigné ou trop long.";
				$("input[name='creator']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(content)) {
				error = true;
				errorMsg = "Aucun contenue de topic !";
				$("input[name='content']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(title) || title.length > 50) {
				error = true;
				errorMsg = "Le titre n'est pas renseigné ou trop long";
				$("input[name='title']").css("border","solid 3px red");
			}

			if (!error) {
				this.ajaxNewTopic(name,creator,content,title);
			} else {
				$("#newTopic").append("<p class='error'>"+errorMsg+"</p>");
			}
		});
	}

	ajaxNewTopic(name,creator,content,title)
	{
		$.ajax({
			url: 'index.php?action=newTopicGame',
			type: 'POST',
			data: {
				name: name,
				creator: creator,
				content: content,
				title: title
			},

			complete: function(response) 
			{		
				var text = response.responseText;
				$("#inscription").empty();
				if (text === "error") {
					$("#newTopic").append("<p class='error'>Le titre est déjà utilisé.</a></p>");
				} else {
					let interval = null;
					let time = 5;
					interval = setInterval( ()=>{
						if (time > 0) {
							$("body").empty();
							$("body").append("<p class='valid'>Le topic à bien été crée, vous allez être renvoyé dessue dans "+time+".</p>"+
							"<p> Ou cliqué ici pour retourner directement au <a href='index.php?action=displayGameForum'>Topic</a>.</p>");
							time -= 1;
						} else {
							window.location.replace("index.php?action=displayGameForum");
						}
					}, 1000);
				}
			},
			error: function ()
			{
				$("#newTopic").append("<p class='error'></p>");
			}
		});
	}
}