class ReportGesture {
	constructor () {
		this.general = new General;
		this.displayReport();
		this.modifyTable();
		this.pageGesture();
		this.pageNumber = 1;
	}

	displayReport () 
	{
		$(document).ready((e)=> {
			var nmbButton = $(".displayButton").length;
			for (let i = 0; i <= nmbButton; i++) {
				$(".displayButton").eq(i).on("click", (e)=> {
					let press = $(".displayButton").eq(i).val();
					this.displayReportDetails(press);
				});
			}
		});
	}

	pageGesture()
	{
		$(document).ready((e)=>{
			var nmbButton = $(".page").length;
			for (let i = 0; i <= nmbButton; i++) {
					$(".page").eq(i).on("click", (e)=> {
						this.pageNumber = $(".page").eq(i).val();
						let typeTopic = $("#typeTopic").val();
						let topicCom = $("#typeTopicCom").val();
						let numberDisplay = $("#numberDisplay").val();
						let orderBy = $("#orderBy").val();
						this.maxPage(typeTopic,topicCom,numberDisplay,orderBy,this.pageNumber);
					});
				}
		});
	}

	modifyTable ()
	{
		$( document ).ready((e)=> {
			$('#typeTopic,#typeTopicCom,#numberDisplay,#orderBy').on("change", (e)=>{
				let typeTopic = $("#typeTopic").val();
				let topicCom = $("#typeTopicCom").val();
				let numberDisplay = $("#numberDisplay").val();
				let orderBy = $("#orderBy").val();
				this.maxPage(typeTopic,topicCom,numberDisplay,orderBy,this.pageNumber);
			});
		});
	}

	maxPage (typeTopic, topicCom, numberDisplay, orderBy, page)
	{
		let max = numberDisplay;
		let min = page * numberDisplay-numberDisplay;
		$.ajax({
			url:'index.php?action=maxPageReport',
			type: "POST",
			context: this,
			data: {
				typeTopic: typeTopic,
				topicCom: topicCom,
				orderBy: orderBy,
				min: min,
				max: max
			},
			complete: function(response)
			{
				let text = response.responseText;
				if (text != 'error') {
					$("#refreshGesture").empty();
					var data = JSON.parse(text);
					for (var i = 0; i < data.topicDetails.length; i++) {
						if (data.report_type == "offensiveInsult") {
			    			var reportType = "Propos injurieux";
			    		} else if (data.topicDetails[i].report_type == "unsuitableContent") {
			    			var reportType = "Contenue inapproprié";
			    		} else if (data.topicDetails[i].report_type == "spam") {
			    			var reportType = "Spam";
			    		} else {
			    			var reportType = "Fausses informations";
		    			}

		    			if (data.topicDetails[i].comment_id == null) {
						    var typeOfContent = "Sujet";
		    			} else {
							var typeOfContent = "Commentaire";
		    			}

						var nmbOcc = data.topicDetails[i].total;

						if (data.topicDetails[i].comment_id == null &&  data.topicDetails[i].topic_type == "game") {
						  var buttonDetails = `<td><button class="displayButton" data-archive="${data.topicDetails[i].id}" value='{"type":"game_forum", "id":"${data.topicDetails[i].topic_id}"}'>Voir</button></td>`;
						} else if (data.topicDetails[i].comment_id != "" &&  data.topicDetails[i].topic_type == "game") {
						   var buttonDetails = `<td><button class="displayButton" data-archive="${data.topicDetails[i].id}" value='{"type":"game_comment", "id":"${data.topicDetails[i].comment_id}", "foreign":"game_forum"}'>Voir</button></td>`;
						}
						$("#refreshGesture").append(
							"<tr>"+
		    					"<td>"+reportType+"</td>"+
		    					"<td>"+typeOfContent+"</td>"+
			    				"<td>"+data.topicDetails[i].creation_date+"</td>"+
			    				"<td id='nmbOcc'>"+nmbOcc+"</td>"+
			    				buttonDetails+
		    				"</tr>"
						);
					}
					if (data.nmbData > 1) {
						$("#showPage").empty();
						$("#showPage").append("<p>Page</p>");
						for (var i = 0; i < data.nmbData; i++) {
							let x = i+1;
							$("#showPage").append(`<button class='page' value='${x}'>${x}</button>`);
						}
					}
					this.pageGesture();
					this.displayReport();
				} else {
					$("#refreshGesture").empty();
					$("#refreshGesture").append("Aucune données.");
					return 'error';
				}
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
					console.log(this.data);
					$("body").append("<div id='background'></div>");
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
										"<button id='archive' value='"+this.data["comment"]["id"]+",com'>Archiver</button>"+
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
									"<button id='archive' value='"+this.data["topic"]["id"]+",topic'>Archiver</button>"+
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
									"<p><button id='topicModify'>Modifier</button> <button  id='topicSuppr'>Supprimer</button> <button id='archive' value='"+this.data["topic"]["id"]+",topic'>Archiver</button></p>"+
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
			var val = $("#archive").val().split(",");
			$.ajax ({
				url: 'index.php?action=archiveReport',
				type: 'POST',
				context: this,
				data: {
					id: val[0],
					comOrTopic: val[1]
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
							content: content,
						},
						complete : function () {
							location.reload();
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
								comOrTopic: this.data['tableCom'],
								id: this.data['comment']['id']
							}
						});
						location.reload();
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
							table: this.data['table'],
							id: this.data['topic']['id'],
							content: content,
						},
						complete : function () {
							location.reload();
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
								table: this.data['table'],
								id: this.data['topic']['id']
							},
						});
						location.reload();
					} else {
						$("#background").click();
					}
				});
			});
		});
	}

}