


var oldTime = "";

$(document).ready(function() {
	var myDashboardTable = $('#dashboard-table').DataTable({
		data:generalLoad,
		columns:[
			{'data': 'ten_tram'},
			{'data': 'ten_cambien'},
			{'data': 'ten_dailuong'},
			{'data': 'giatri'},
			{'data': 'ten_donvi'},
			{'data': 'thoigian'},			
		],
		paging:false
	});	

	function update() {
		$.get("ajax/generalLoad/1",function(response) {
			const obj = $.parseJSON(response);
			var newTime = obj[0]['thoigian'];
			if (oldTime != newTime) {
				console.log(oldTime + " - " + newTime);
				myDashboardTable.row.add(obj[0]).draw(false);
				oldTime = newTime;
			}
		});	
	}
	
	$('#num_rows').change(function (e) {
		var num_rows = $(this).val();
		console.log(num_rows);
		location.replace("dashboard/index/"+num_rows);
	})

	setInterval(function () {
	  update();
	},100);	
});

