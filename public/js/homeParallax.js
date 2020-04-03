$(window).on("load", ()=> {
	$('body').on("mousemove", (event) => {
		let gameTabOffset = $('#gameTab').offset();

		let gameTabWidth = $('#gameTab').width();
		let gameTabHeight =  $('#gameTab').height();
		let gameTabMidleWidth = gameTabWidth/2;
		let gameTabMidleHeight = gameTabHeight/2;

		let bodyWidth = $('body').width();
		let bodyHeight = $('body').height();
		let bodyMidleWidth = bodyWidth/2;
		let bodyMidleHeight = bodyHeight/2;

		let mouseX = event.pageX - gameTabOffset.top;
		let mouseY = event.pageY - gameTabOffset.left;
		console.log(mouseX,mouseY);
		if (mouseX > bodyMidleHeight) {
			var x = (mouseX - bodyMidleHeight)*-0.10;  
		} else {
			var x = (bodyMidleHeight - mouseX)*0.10;
		}
		if (mouseY > bodyMidleWidth) {
			var y = (mouseY - bodyMidleWidth)*-0.10;  
		} else {
			var y = (bodyMidleWidth - mouseY)*0.10;
		}

		console.log(y,x);
		$("#game").css({
			"top": y,
			"left": x
		});
	});	
});
