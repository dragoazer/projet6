class ChatGesture {
	construtor () {
		this.general = new General;
		this.sendMessage();
		this.showChat();
		this.chatGesture();
	}

	sendMessage () 
	{
		$("#sendMessage").on("click", (e)=>{
			let inputMessage = $("#inputMessage").val();
			if (this.general.emptyTest(inputMessage) || inputMessage.length < 50) {
				$.ajax({
					url: 'index.php?action=sendChatMessage',
					type: 'POST',
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
				}
			}
		});
	}

	chatGesture ()
	{
		$("#").on("click", (e)=>{
			$("#displayChat").css({"display":"hidden"});
			$("#displayChat").css({"display":"hidden"});
		});
	}
}