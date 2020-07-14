class Connexion {
	constructor () {
		this.verifConnection();
		this.general = new General;
	}

	verifConnection () 
	{		
		$("#submitConect").on("click", (e)=>{
			e.preventDefault();
			let error = false;
			let errorMsg = '';

			$(".error").remove();

			$("input[name='emailConect']").css("border","");
			$("input[name='pwdConect']").css("border","");

			let email = $("input[name='emailConect']").val();
			let pwd = $("input[name='pwdConect']").val();

			if (!this.general.isMail(email)) {
				error = true;
				errorMsg = "Le courriel est erroné.";
				$("input[name='emailConect']").css("border","solid 3px red");
			}	
		
			if (!this.general.pwdTest(pwd)) {
				error = true;
				errorMsg = "Vous n'avez pas rempli le champs mot de passe.";
				$("input[name='pwdConect']").css("border","solid 3px red");
			}

			if (error === false) {
				this.ajaxConnexion(email, pwd);
			} else {
				$("#connexion").append("<p class='error'>"+errorMsg+"</p>");
			}
		});
	}

	ajaxConnexion (email,pwd)
	{
		$.ajax({
			url: 'index.php?action=setLogin',
			type: 'POST',
			data: {
				email: email,
				pwd: pwd,
			},
			complete : function(response) 
			{
				let text = response.responseText;
				if (text === 'error') {
					$("#connexion").append("<p class='error'>Erreur, mauvais email ou mot de passe.</p>");
				} else {
					let interval = null;
					let time = 5;
					interval = setInterval( ()=>{
						if (time > 0) {
							$("body").empty();
							$("body").append("<p class='valid'>Connexion réussi retour à la page d'accueil dans "+time+".</p>"+
							"<p> Ou cliqué ici pour retourner directement à la <a href='../projet6/public/index.php?action=home'>page d'accueil</a>.</p>");
							time -= 1;
						} else {
							window.location.replace("../projet6/public/index.php?action=home");
						}
					}, 1000);
				}
			},
			error : function ()
			{
				$("#connexion").append("<p class='error'>Erreur interne, veullez réessayer votre connexion.</p>");
			}
		});
	}
}