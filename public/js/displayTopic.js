class DisplayTopic {
	constructor ()
	{
		this.general = new General;
		this.searchUrl = new URLSearchParams(document.location.search.substring(1));
		this.id = this.searchUrl.get("id");
		this.ajaxDisplayComment(0,10);
		this.pageGesture();
		this.newComment();
		this.newContent();
		this.popupDisapear();
		this.supprTopic();
		this.report();
	}


	reportComment ()
	{
		$(document).ready((e)=> {
			for (var i = 0; i <= $(".reportButton").length-1; i++) {
				let z = i;
				$(".reportButton").eq(z).on("click", (e)=>{
					e.preventDefault();
					let value = $(".reportButton").eq(z).val();
					$("body").css("overflow", "hidden");
					$("#background").css({"display":"block"});
					$("#verifCommentReport").css({"display":"block"});
					this.sendCommentReport(value);
				});
			}
		});
	}

	sendCommentReport (comment_id)
	{
		$("#sendReportComment").on("click", (e)=>{
			e.preventDefault();
			let report_type = $("#reportCommentValue").val();	
			$.ajax({
				url: 'index.php?action=reportGammeComment',
				type: 'POST',
				context: this,
				data: {
					topic_id: this.id,
					report_type: report_type,
					comment_id: comment_id
				},
				complete : function(response)
				{
					$("#background").click();
				},
				error : function ()
				{
					$("verifReport").append("<p class='error'>Erreur interne.</p>");
				}
			});
		});
	}

	report ()
	{
		$("#report").on("click", (e)=>{
			e.preventDefault();
			$("body").css("overflow", "hidden");
			$("#background").css({"display":"block"});
			$("#verifReport").css({"display":"block"});
			this.sendReport();
		});
	}

	sendReport ()
	{
		$("#sendReportInfo").on("click", (e)=>{
			e.preventDefault();
			let report_type = $("#reportValue").val();	
			$.ajax({
				url: 'index.php?action=reportGameTopic',
				type: 'POST',
				context: this,
				data: {
					topic_id: this.id,
					report_type: report_type
				},
				complete : function(response)
				{
					$("#background").click();
				},
				error : function ()
				{
					$("verifReport").append("<p class='error'>Erreur interne.</p>");
				}
			});
		});
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
			$("#verifReport").css({"display":"none"});
			$("#verifCommentReport").css({"display":"none"});
		});
	}

	verifNewComment ()
	{
		$("#sendNewComment").unbind()
		$("#sendNewComment").on("click",(e)=>{
			e.preventDefault();

			$("#background").click();

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
		if (this.id >= 0 ) {
			$.ajax({
				url: 'index.php?action=addGameComment',
				type: 'POST',
				context: this,
				data: {
					id: this.id,
					comment: comment,
				},
				complete : function(response) 
				{
					let text = response.responseText;
					if (text === 'error') {
						$("#displayNewComment").append("<p class='error'>Erreur, vous ne pouvez pas commenter ce sujet.</p>");
					} else {
						this.ajaxDisplayComment(0,10);
						this.pageGesture();
					}
				},
				error : function ()
				{
					$("#displayNewComment").append("<p class='error'>Erreur interne.</p>");
				}
			});
		}
	}

	ajaxNewContent (newContent)
	{
		if (this.id >= 0 ) {
			$.ajax({
				url: 'index.php?action=modifyTopicGame',
				type: 'POST',
				context: this,
				data: {
					id: this.id,
					content: newContent,
				},
				complete : function(response) 
				{
					let text = response.responseText;
					if (text === 'error') {
						$("#mainContent").append("<p class='error'>Erreur, vous ne pouvez pas modifier ce sujet.</p>");
					} else {
						document.location.reload(true);
					}
				},
				error : function ()
				{
					$("").append("<p class='error'>Erreur interne.</p>");
				}
			});
		}
	}

	ajaxDisplayComment (min, max)
	{
		$("#displayComment").empty();
		if (this.id >= 0 ) {
			$.ajax({
				url: 'index.php?action=displayGameComment',
				type: 'POST',
				context: this,
				data: {
					forumId: this.id,
					min: min,
					max: max,
				},
				complete : function(response)
				{
					let text = response.responseText;
					if (text != 'errorNoCount') {

						let datas = JSON.parse(text);
						$("#displayComment").empty();
						for (var i = 0; i < datas.length; i++) {
							$("#displayComment").append("<li>"+datas[i].pseudo+" "+datas[i].post_date+" "+datas[i].comment+"<button class='reportButton' value='"+datas[i].id+"'>Signaler</button></li>")
						}
						$(window).on("load", this.reportComment());
					} else {
						$("#displayComment").empty();
						$("#displayComment").append("<p id='firstComment'>Soyez le premier à commenter ! </p>");
					} 
				},
				error : function ()
				{
					$("displayComment").append("<p class='error'>Erreur interne.</p>");
				}
			});
		}
	}

	supprTopic ()
	{
		$("#supprTopic").on("click", (e)=>{
			$("#verifSuppr").css({"display":"block"});
			$("#background").css({"display":"block"});
			$("#spprTrue").on("click", (e)=>{
				e.preventDefault();
				this.ajaxSuppr();
			});
			$("#spprFalse").on("click", (e)=>{
				e.preventDefault();
				$("#background").click();
			});
		});
	}

	ajaxSuppr ()
	{
		$.ajax({
			url: 'index.php?action=supprGameTopic',
			context: this,
			type: "POST",
			data: {
				id: this.id
			},
			complete : function(response) 
			{
				let text = response.responseText;
				if (text === 'error') {
					$("#verifSuppr").append("<p class='error'>Erreur, vous ne pouvez pas supprimer ce sujet.</p>");
				} else {
					window.location.replace("index.php?action=displayGameForum");
				}
			},
			error : function ()
			{
				$("#verifSuppr").append("<p class='error'>Erreur interne.</p>");
			}
		});
	}

	pageGesture ()
	{
		 $.ajax({
		 	context: this,
		 	type: 'POST',
		 	url: 'index.php?action=maxPageComment',
		 	data: {
		 		id: this.id,
		 	},
		 	complete : function (response)
		 	{
		 		let text = response.responseText;
		 		if (text != "error") {
		 			let maxPage = Math.ceil(text / 10);
		 			$(".page").empty();
		 			if (maxPage > 1) {
			 			for (let i = 1; i <= maxPage; i++) {
			 				$(".page").append("<button id='page"+i+"'>"+i+"</button>");
			 				$("#page"+i).on("click",(e)=>{
			 					let min = i*10-10;
			 					let max = i*10;
			 					this.ajaxDisplayComment(min,max);
			 				});
			 			}
		 			}
		 		}
		 	}
		 });
	}
}