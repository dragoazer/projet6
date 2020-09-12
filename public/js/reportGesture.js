class ReportGesture {
	constructor () {
		this.displayReport();
	}

	displayReport () 
	{
		$(document).ready((e)=> {
			var nmbButton = $(".displayButton").length;
			for (let i = 0; i <= nmbButton; i++) {
				$(".displayButton").eq(i).on("click", (e)=> {
					console.log(i);
					let press = $(".displayButton").eq(i).val();
					console.log(press);
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
			data: {
				press: press
			}
		});
	}

}