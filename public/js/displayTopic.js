class DisplayTopic {
	constructor ()
	{
		this.newComment();
		this.newContent();
		this.popupDisapear();
		this.supprTopic();
		this.general = new General;
	}

	newComment ()
	{
		$("#comment").on("click", (e)=>{
			$("body").css("overflow", "hidden");
			$("#background").css({"display":"block"});
			$("#displayNewComment").css({"display":"block"});
			this.verifNewComment();
		});

	}

	newContent ()
	{
		$("#modifTopic").on("click", (e)=>{
			$("body").css("overflow", "hidden");
			$("#background").css({"display":"block"});
			$("#displayModifTopic").css({"display":"block"});
			this.verifNewContent();
		});
	}

	popupDisapear ()
	{
		$("body").append("<div id='background'><div>");
		$("#background").on('click', (e)=>{
			$("#background").css({"display":"none"});
			$("#displayModifTopic").css({"display":"none"});
			$("#displayNewComment").css({"display":"none"});
			$("#verifSuppr").css({"display":"none"});
		});
	}

	supprTopic ()
	{
		$("#supprTopic").on("click", (e)=>{
			$("#verifSuppr").css({"display":"block"});
			$("#background").css({"display":"block"});
			$.ajax({
				url: 'index.php?action=',

				complete : function(response) 
				{
					let text = response.responseText;
					if (text === 'error') {
						$("#connexion").append("<p class='error'>Erreur, vous ne pouvez pas supprimer ce sujet.</p>");
					} else {
						
					}
				},
				error : function ()
				{
					$("#connexion").append("<p class='error'>Erreur interne, veullez réessayer votre connexion.</p>");
				}
			});
		});
	}

	verifNewComment ()
	{
		$("#sendNewComment").on("click",(e)=>{
			e.preventDefault();

			let error = false;
			let errorMsg = '';

			$("input[name='comment']").css("border","");

			$(".error").remove();
			$(".valid").remove();

			let comment = $("input[name='comment']").val();


			if (this.general.emptyTest(comment)) {
				error = true;
				errorMsg = "Vous n'avez pas remplie le formulaire.";
				$("input[name='comment']").css("border","solid 3px red");
			}

			if (!error) {
				this.ajaxNewComment(comment);
			} else {
				$("#displayNewComment").append("<p class='error'>"+errorMsg+"</p>");
			}
		});
	}

	verifNewContent ()
	{
		$("#sendNewContent").on("click",(e)=>{
			e.preventDefault();

			let error = false;
			let errorMsg = '';

			$("input[name='newContent']").css("border","");

			$(".error").remove();
			$(".valid").remove();

			let newContent = $("input[name='newContent']").val();


			if (this.general.emptyTest(newContent)) {
				error = true;
				errorMsg = "Vous n'avez pas remplie le formulaire.";
				$("input[name='newContent']").css("border","solid 3px red");
			}

			if (!error) {
				this.ajaxNewContent(newContent);
			} else {
				$("#displayModifTopic").append("<p class='error'>"+errorMsg+"</p>");
			}
		});
	}

	ajaxNewComment (comment)
	{
		$.ajax({
			url: 'index.php?action=addGameComment',
			type: 'POST',
			data: {
				comment: comment,
			},
			complete : function(response) 
			{
				let text = response.responseText;
				if (text === 'error') {
					$("#connexion").append("<p class='error'>Erreur, vous ne pouvez pas commenter ce sujet.</p>");
				} else {
					
				}
			},
			error : function ()
			{
				$("#connexion").append("<p class='error'>Erreur interne, veullez réessayer votre connexion.</p>");
			}
		});
	}

	ajaxNewContent (newContent)
	{
		$.ajax({
			url: 'index.php?action=modifyTopicGame',
			type: 'POST',
			data: {
				newContent: newContent,
			},
			complete : function(response) 
			{
				let text = response.responseText;
				if (text === 'error') {
					$("#connexion").append("<p class='error'>Erreur, vous ne pouvez pas modifier ce sujet.</p>");
				} else {
					
				}
			},
			error : function ()
			{
				$("#connexion").append("<p class='error'>Erreur interne, veullez réessayer votre connexion.</p>");
			}
		});
	}
}