class Registration {
	constructor () {
		this.verifInscription();
		this.general = new General;
	}

	verifInscription ()
	{
		$("#submitSignin").on('click', (e)=> {
			e.preventDefault();

			let error = false;
			let errorMsg = '';

			$("input[name='email']").css("border","");
			$("input[name='pseudo']").css("border","");
			$("input[name='pwd']").css("border","");

			$(".error").remove();
			$(".valid").remove();

			let email= $("input[name='email']").val();
			let pseudo = $("input[name='pseudo']").val();
			let pwd = $("input[name='pwd']").val();


			if (!this.general.isMail(email)) {
				error = true;
				errorMsg = "Le champs Email n'est pas valide.";
				$("input[name='email']").css("border","solid 3px red");
			}
			if (this.general.emptyTest(pseudo)) {
				error = true;
				errorMsg = "Le champs nom est vide.";
				$("input[name='first_name']").css("border","solid 3px red");
			}

			if (this.general.pwdTest(pwd) === false) {
				error = true;
				errorMsg = "Le champs mot de passe ne compte pas huit caractères une majuscule et un chiffre.";
				$("input[name='pwd']").css("border","solid 3px red");
			}

			if (!error) {
				this.ajaxInscription(email,pseudo,pwd);
				$("#inscription").append("<p class='valid'>inscription validé, veuillez vous connecter</p>");
			} else {
				$("#inscription").append("<p class='error'>"+errorMsg+"</p>");
			}
		});
	}

	ajaxInscription (email,pseudo,pwd)
	{
		$.ajax({
			url: 'index.php?action=newTopicGame',
			type: 'POST',
			data: {
				email : email,
				pseudo: pseudo,
				pwd: pwd,
			},

			complete: function(response) 
			{		
				var text = response.responseText;
				$("#inscription").empty();
				if (text === "error") {
					$("#inscription").append("<p class='error'>Ce compte existe déjà, veuillez vous <a href='index.php?action=displayLogin'>connecter.</a>.</p>");
				} else {
					$("#inscription").append("<p class='valid'>Votre inscription a été pris compte, veuillez vous <a href='index.php?action=displayLogin'>connecter.</a></p>");
				}
			},
			error: function ()
			{
				$("#inscription").append("<p class='error'>Erreur interne, veullez réessayer votre inscription.</p>");
			}
		});
	}
}