class ChatGesture {
	constructor () 
	{
		this.general = new General;	
		this.sendMessage();
		this.buttonGesture();
		this.showChat();
	}

	sendMessage () 
	{
		$("#sendMessage").on("click", (e)=>{
			e.preventDefault();
			let inputMessage = $("#inputMessage").val();
			$("#inputMessage").val("");
			if (!this.general.emptyTest(inputMessage) && inputMessage.length < 50 && inputMessage.length > 1) {
				$.ajax({
					url: 'index.php?action=sendChatMessage',
					type: 'POST',
					context: this,
					data: {
						inputMessage: inputMessage
					},

					complete: function(response) 
					{		
						var text = response.responseText;
						if (text != "error") {
							this.showChat();
						}
					}
				});
			}
		});
	}

	showChat()
	{
		$.ajax({
			url: 'index.php?action=showChat',
			complete: function(response) 
			{		
				var text = response.responseText;
				if (text != "error") {
					let datas = JSON.parse(text);
					$("#displayChat").empty();
					for (let data of datas) {
						$("#displayChat").append("<li>"+data.pseudo+" : "+data.message+"</li>")
					}
				}
				let heightChat = $("#displayChat").height();
				$("#displayChat").scrollTop(heightChat);
			}
		});
	}

	buttonGesture ()
	{
		$("#reduceChat").on("click", (e)=>{
			e.preventDefault();
			$("#displayChat,#infoChat,#chatGesture").css({"display":"none"});
			$('#chat').append(
				"<p id='chatGestureExpand'>"+
					"<button id='expandChat'>+</button>"+
					"Agrandir le chat"+
				"</p>"
			);
			$('#chat').css({"height":"auto"});
			$('#chatGestureExpand').css({"margin":"auto"});
			$("#expandChat").on("click", (e)=>{
				$("#displayChat,#infoChat,#chatGesture").css({"display":"block"});
				let chatHeight = $("#chat").height() * 0.60 ;
				$("#displayChat").css({"height":chatHeight});
				$("#chatGestureExpand").remove();
			});
		});
	}
}