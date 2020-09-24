class ReportGesture {
	constructor () {
		this.displayReport();
		this.general = new General;
	}

	displayReport () 
	{
		$(document).ready((e)=> {
			var nmbButton = $(".displayButton").length;
			for (let i = 0; i <= nmbButton; i++) {
				$(".displayButton").eq(i).on("click", (e)=> {
					let press = $(".displayButton").eq(i).val();
					this.ArchiveId = $(".displayButton").eq(i).attr("data-archive");
					this.displayReportDetails(press);
				});
			}
		});
	}

	displayReportDetails (press)
	{
		$.ajax({
			url: 'index.php?action=displayReportDetails',
			type: 'POST',
			context: this,
			data: {
				press: press
			},
			complete : function(response)
			{
				let text = response.responseText;
				if (text != "error") {
					this.data = JSON.parse(text);
					$("body").append("<div id='background'></div>");
					console.log(this.data);
					if (this.data["comment"] != undefined) {
						//////////////////// Si on à un commentaire on propose d'afficher le sujet associé.
						$("body").append(
							"<div id='displayDetails'>"+
								"<div id='commentDisplayDetails'>"+
									"<h2>Commentaire sélectionné:</h2>"+
									"<br>"+
									"<h4>Contenue</h4>"+
									"<p>"+this.data["comment"]["comment"]+"</p>"+
									"<p>Commentateur : "+this.data["comment"]["pseudo"]+"</p>"+
									"<p>Date de création : "+this.data["comment"]["post_date"]+"</p>"+
									"<p>"+
										"<button id='commentModify'>Modifier</button> "+
										"<button id='commentSuppr'>Supprimer</button> "+
										"<button id='topicShowDetails'>voir le sujet associé</button> "+
										"<button id='archive'>Archiver</button>"+
									"</p>"+
								"</div>"+

								"<div id='topicDisplayDetails'>"+
									"<h1>Gestion de snigalement</h1>"+
									"<h4>Sujet associé au commentaire</h4>"+
									"<p>"+this.data["topic"]["title"]+"</p>"+
									"<h4>Contenue</h4>"+
									"<p>"+this.data["topic"]["content"]+"</p>"+
									"<h4>Créateur du topic</h4>"+
									"<p>"+this.data["topic"]["editor"]+"</p>"+
									"<p><button id='topicModify'>Modifier</button> <button id='topicSuppr'>Supprimer</button>"+
								"</div>"+
							"</div>"
							);
							

							$("#topicShowDetails").on("click", (e)=>{
								$("#topicDisplayDetails").css({"display":"block"});
								$("#topicShowDetails").remove();
							});

							this.buttonGesture();
					} else {
						///////////////////// Sinon on affiche juste le sujet.
						$("body").append(
							"<div id='displayDetails'>"+
								"<div id='commentDisplayDetails'>"+
									"<h1>Gestion de snigalement du sujet</h1>"+
									"<p>"+this.data["topic"]["title"]+"</p>"+
									"<h4>Contenue</h4>"+
									"<p>"+this.data["topic"]["content"]+"</p>"+
									"<h4>Créateur du topic</h4>"+
									"<p>"+this.data["topic"]["editor"]+"</p>"+
									"<p><button id='topicModify' >Modifier</button> <button  id='topicSuppr'>Supprimer</button> <button id='archive'>Archiver</button></p>"+
								"</div>"+
							"</div>"
						);
						this.buttonGesture();
					}
					this.backgroundGesture();				
				}
			},
		});
	}

	backgroundGesture () 
	{
		$("body").css({"overflow":"hidden"});
		window.scroll(0,0);
		$("#background").on("click", ()=>{
			$("#background").remove();
			$("#displayDetails").remove();
			$("body").css({"overflow":"auto"});
		});
	}

	buttonGesture ()
	{
		/////////////////// Supression du signalement
		$("#archive").on("click", (e)=>{
			console.log(this.archiveId);
			$.ajax ({
				url: 'index.php?action=archiveReport',
				type: 'POST',
				context: this,
				data: {
					id: this.archiveId
				},
				complete : function () {
					location.reload();
				}
			});
		});
		//////////////////////////////////////////// Modification d'un commentaire.
		$("#commentModify").on("click", (e)=>{
			$("#commentDisplayDetails").empty();
			$("#commentDisplayDetails").append(
				"<form>"+
					"<h1>Nouveau Contenue</h1>"+
					"<input name ='newContent' cols='50' type='text' placeholder='"+this.data["comment"]["comment"]+"'></input>"+
					"<p><button id='sendNewContent'>Envoyer</button></p>"+
				"</form>"
			);

			$("#sendNewContent").on("click", (e)=>{
				e.preventDefault();
				let content = $("input[name=newContent]").val();
				$("#errorMsg").remove();
				$("input[name='newContent']").css("border","solid 0px red");
				if (this.general.emptyTest(content)) {
					$("#commentDisplayDetails").append("<p id='errorMsg'>Vous n'avez pas remplie le formulaire.</p>");
					$("input[name='newContent']").css("border","solid 3px red");
				} else {
					$.ajax ({
						url: 'index.php?action=modifyItem',
						type: 'POST',
						context: this,
						data: {
							table: this.data['tableCom'],
							id: this.data['comment']['id'],
							content: content
						},
						complete : function () {
							$("#background").click();
						}
					});
				}
			});
		});
		////////////////////////////////////////// Supression d'un commentaire.
		$("#commentSuppr").on("click", (e)=>{
			$("#commentDisplayDetails").empty();
			$("#commentDisplayDetails").append(
				"<p>Êtes vous sur de vouloir supprimmer ce commentaire?</p>"+
				"<div>"+
					'<input type="radio" id="false" name="choice" value="false" required>'+
					"<label for='false'>Non</label>"+
				"</div>"+
				"<div>"+
					'<input type="radio" id="true" name="choice" value="true" required>'+
					"<label for='true'>Oui</label>"+
				"</div>"
			);
			$("input[name=choice]").on('click', (e)=>{
				$("#pSendResponse").remove();
				$("#commentDisplayDetails").append("<p id='pSendResponse'><button id='sendResponse'>Envoyer</button></p>");
				$("#sendResponse").on('click', (e)=>{
					if ($("input[name=choice]:checked").val() == 'true') {
						$.ajax ({
							url: 'index.php?action=deleteItem',
							type: 'POST',
							context: this,
							data: {
								table: this.data['tableCom'],
								id: this.data['comment']['id']
							}
						});
						$("#background").click();
					} else {
						$("#background").click();
					}
				});
			});
		});
		////////////////////////////////////////// Modification d'un sujet.
		$("#topicModify").on("click", (e)=>{
			$("#commentDisplayDetails").empty();
			$("#topicDisplayDetails").remove();
			$("#commentDisplayDetails").append(
				"<h1>Nouveau Contenue</h1>"+
				"<input name ='newContent' type='text' cols='50' placeholder='"+this.data["topic"]["content"]+"'></input>"+
				"<p><button id='sendNewContent'>Envoyer</button></p>"
			);
			$("#sendNewContent").on("click", (e)=>{
				e.preventDefault();
				let content = $("input[name=newContent]").val();
				console.log(content, "modify suject");
				$("#errorMsg").remove();
				$("input[name='newContent']").css("border","solid 0px red");
				if (this.general.emptyTest(content)) {
					$("#commentDisplayDetails").append("<p id='errorMsg'>Vous n'avez pas remplie le formulaire.</p>");
					$("input[name='newContent']").css("border","solid 3px red");
				} else {
					$.ajax ({
						url: 'index.php?action=modifyItem',
						type: 'POST',
						context: this,
						data: {
							table: this.data['tableTopic'],
							id: this.data['topic']['id'],
							content: content,
							type: "topic"
						},
						complete : function () {
							$("#background").click();
						}
					});	
				}
			});
		});
		////////////////////////////////////////// Supression d'un sujet.
		$("#topicSuppr").on("click", (e)=>{
			$("#commentDisplayDetails").empty();
			$("#commentDisplayDetails").append(
				"<p>Êtes vous sur de vouloir supprimmer ce Sujet?</p>"+
				"<div>"+
					'<input type="radio" id="false" name="choice" value="false" required>'+
					"<label for='false'>Non</label>"+
				"</div>"+
				"<div>"+
					'<input type="radio" id="true" name="choice" value="true" required>'+
					"<label for='true'>Oui</label>"+
				"</div>"
			);
			$("input[name=choice]").on('click', (e)=>{
				$("#pSendResponse").remove();
				$("#commentDisplayDetails").append("<p id='pSendResponse'><button id='sendResponse'>Envoyer</button></p>");
				$("#sendResponse").on('click', (e)=>{
					if ($("input[name=choice]:checked").val() === 'true') {
						$.ajax ({
							url: 'index.php?action=deleteItem',
							type: 'POST',
							context: this,
							data: {
								table: this.data['tableTopic'],
								id: this.data['topic']['id'],
								type: "topic"
							},
						});
						$("#background").click()
					} else {
						$("#background").click();
					}
				});
			});
		});
	}

}