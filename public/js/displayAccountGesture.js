class DisplayAccountGesture {
	constructor () 
	{
		this.ImageProfileGesture();
		this.showGesture();
		this.general = new General;
	}

	ImageProfileGesture ()
	{			
		$("#newImage").on("change", ()=>{
			$("#preview").remove();
			$("#errorMsg").remove();
			let file = $('#newImage').prop("files");
			$("#showDownloadImage").append(
				'<div id="preview"><img src="'+
				URL.createObjectURL(file[0])+
				'"/></div><br>'
			);
		});
		$("#sendNewProfile").on("click", (e)=> {
			e.preventDefault();
			let file = $('#newImage').prop("files");
			const acceptedImageTypes = ['image/gif', 'image/jpeg', 'image/png'];	
			if (file[0]["size"] < 1000000 && acceptedImageTypes.indexOf(file[0]["type"]) === 1) {
				var imgFile = new FormData($('#showDownloadImage')[0]);
				$.ajax({
					url: 'index.php?action=changeImageProfile',
					type: 'POST',
					data: imgFile,
					contentType: false,
					processData: false,
					complete: function(response)
					{
						let responseVar = response.responseText;
						$("#errorMsg").remove();
						if (responseVar != 'error') {
							$("#showDownloadImage").append("<p id='errorMsg' class='valid'>Image de profile modifié.</p>");
							let accountName = $("#accName").text().split(": ")[1];
							let imgType = file[0]["type"].split("/")[1];
    						$("#actualProfile").attr('src', './img/profile/'+accountName+'ImgProfile.'+imgType+'?'+new Date().getTime());
							setTimeout(function() {
    							$("#preview").remove();
								$("#errorMsg").remove();
    							$("#greyBackground").click();
  							}, 3000);
						} else {
							$("#showDownloadImage").append("<p id='errorMsg' class='error'>Image de profile n'a pu être modifié.</p>");
						}
					},
				});
			}	
		});
	}

	showGesture () {
		/////////////////// IMG
		$("#showChangeProfile").on("click", ()=>{
			$("#showDownloadImage").fadeIn();
			$("#greyBackground").fadeIn();
			$("body").css({"overflow":"hidden"});
			$("#greyBackground").on("click", ()=>{
				$("#showDownloadImage").fadeOut();
				$("#greyBackground").fadeOut();
				$("body").css({"overflow":"auto"});
				$("#showDownloadImage").get(0).reset()
			});
		});
		///////////////////////////// PASSWORD
		$("#pwdGesture").append(
			"<form id='pwdForm'>"+
			'<p>Minimum 8 caractères, une majuscule et un chiffre</p>'+
			'<label>Ancien mot de passe</label>'+
			'<input type="password" name="oldPwd">'+
			'<button id="eyesOldPwd">eyes</button>'+

			'<label>Nouveau mot de passe</label>'+
			'<input type="password" name="newPwd">'+
			'<button id="eyesNewPwd">eyes</button>'+

			'<button id="sendNewPwdForm">Envoyer</button>'+
			"</form>"
		);
		$("#changePwd").on("click", ()=>{
				$("#errorMsgPwd").remove();
				$("#pwdForm").fadeIn();
				$("#greyBackground").fadeIn();
				$("body").css({"overflow":"hidden"});
				$("#greyBackground").on("click", ()=>{
					$("#pwdForm").fadeOut();
					$("#greyBackground").fadeOut();
					$("body").css({"overflow":"auto"});
					$("#pwdForm").get(0).reset()
				});

				var cliked = false;
				var cliked2 = false;

				$("#eyesNewPwd").on("click", (e)=>{
					e.preventDefault();
					if (cliked == true) {
						$("[name='newPwd']").get(0).type = 'password';
						$("#eyesNewPwd").text("eyes");
						cliked = false;
					} else {
						$("[name='newPwd']").get(0).type = 'text';
						$("#eyesNewPwd").text("eye");
						cliked = true;
						
					}
				});

				$("#eyesOldPwd").on("click", (e)=>{
					e.preventDefault();
					if (cliked2 == true) {
						$("[name='oldPwd']").get(0).type = 'password';
						$("#eyesOldPwd").text("eyes");
					
						cliked2 = false;
					} else {
						$("[name='oldPwd']").get(0).type = 'text';
						$("#eyesOldPwd").text("eye");
						cliked2 = true;		
					}
				});		
		});
		this.sendNewPwd();
	}

	sendNewPwd() {
		$("#sendNewPwdForm").on("click", (e)=>{
			e.preventDefault();
			$("#errorMsgPwd").remove();
			let oldPwd = $("[name='oldPwd']").val();
			let newPwd = $("[name='newPwd']").val();
			if (this.general.pwdTest(oldPwd) && this.general.pwdTest(newPwd) && oldPwd != newPwd) {
				$.ajax({
					url: 'index.php?action=changePwd',
					type: 'POST',
					data: {
						oldPwd : oldPwd,
						newPwd : newPwd
					},
					complete: function(response)
					{
						let responseVar = response.responseText;
						console.log(responseVar);
						if (responseVar !='error') {
							$("#pwdForm").append(
								"<p id='errorMsgPwd' class='valid'>Mot de passe modifié.</p>"
							);
							setTimeout(function() {
								$("#greyBackground").click();
							},3000);
						} else {
							$("#pwdForm").append(
								"<p id='errorMsgPwd' class='error'>Ancien mot de passe incorect.</p>"
							);
						}
					}	
				});
			} else {
				$("#pwdForm").append(
					"<p id='errorMsgPwd' class='error'>Nouveau mot de passe incorect.</p>"
				);
			}
		});
	}
}