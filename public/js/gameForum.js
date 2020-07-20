class GameForum {
	
	constructor {
		this.verifForm();
	}

	verifForm ()
	{
		$("#sendForm").on("click", function{
			e.preventDefault();

			let error = false;
			let errorMsg = '';

			$("input[name='name']").css("border","");
			$("input[name='date']").css("border","");
			$("input[name='creator']").css("border","");
			$("input[name='content']").css("border","");
			$("input[name='title']").css("border","");

			$(".error").remove();
			$(".valid").remove();

			let name= $("input[name='name']").val();
			let date = $("input[name='date']").val();
			let creator = $("input[name='creator']").val();
			let content = $("input[name='content']").val();
			let title = $("input[name='title']").val();

			if (this.general.emptyTest(title) || title.length > 50) {
				error = true;
				errorMsg = "Le titre n'est pas renseigné";
				$("input[name='name']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(name) || name.length > 50) {
				error = true;
				errorMsg = "Le nom du jeu n'est pas renseigné";
				$("input[name='name']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(date) || date.length > 50) {
				error = true;
				errorMsg = "La date de parution du jeu n'est pas renseigné.";
				$("input[name='date']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(creator) || creator.length > 50) {
				error = true;
				errorMsg = "Le nom de l'entreprise n'est pas renseigné.";
				$("input[name='creator']").css("border","solid 3px red");
			}

			if (this.general.emptyTest(content)) {
				error = true;
				errorMsg = "Aucun contenue de topic !";
				$("input[name='content']").css("border","solid 3px red");
			}

			if (!error) {
				this.ajaxNewTopic(name,date,creator,content,title);
				$("#newTopic").append("<p class='valid'>Le topic à bien été crée;</p>");
			} else {
				$("#newTopic").append("<p class='error'>"+errorMsg+"</p>");
			}
		});
	}

	ajaxNewTopic(name,date,creator,content)
	{
		$.ajax({
			url: 'index.php?action=setRegistration',
			type: 'POST',
			data: {
				name: name,
				date: date,
				creator: creator,
				content: content,
				title: title
			},

			complete: function(response) 
			{		
				var text = response.responseText;
				$("#inscription").empty();
				if (text === "error") {
					$("#newTopic").append("<p class='error'>Le titre est déjà utilisé.</a>.</p>");
				} else {
					$("#newTopic").append("<p class='valid'>Le topic à bien été crée, vous allez être renvoyé dessue.</p>");
				}
			},
			error: function ()
			{
				$("#newTopic").append("<p class='error'></p>");
			}
		});
	}
}