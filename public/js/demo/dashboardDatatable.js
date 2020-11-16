


var oldTime = "";

$(document).ready(function() {
	var staticData = true;
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
		"pagingType": "full_numbers",
		dom: 'Bfrtip',
        // buttons: [
        //     'copyHtml5',
        //     'excelHtml5',
        //     'csvHtml5',
        //     'pdfHtml5'
        // ],
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]

    });	

	function update() {
		if (staticData === false) {
			$.get("ajax/getLastRecord",function(response) {
				const obj = $.parseJSON(response);
				var newTime = obj[0]['thoigian'];
				if (oldTime != newTime) {
					console.log(oldTime + " - " + newTime);
					myDashboardTable.row.add(obj[0]).draw(false);
					oldTime = newTime;
				}
			});				
		}

	}
	
	$('#num_rows').change(function (e) {
		staticData = false;
		var num_rows = $(this).val();
		var month = $('#month').val();
		month = parseInt(month);
		if ((0 < month && month < 13)) {
			staticData = true;
			getMonthFilter(month,0,num_rows);
		}else{
			getGeneralLoad(0,num_rows);
		}
	});

	$('#month').change(function (e) {
		staticData = true;
		const myMonth = $(this).val();
		$('#MyDate').val("");
		console.log(myMonth);
		getMonthFilter(myMonth);
	});


	$('#MyDate').change(function (e) {
		staticData = true;
		const myDate = $(this).val();
		getDateFilter(myDate);
	})

	function getGeneralLoad(){
		$.get('ajax/generalLoad',function (result) {
			var data = $.parseJSON(result);
			generalLoad = data;
			$('#dashboard-table').dataTable().fnClearTable();
			$.each(generalLoad, function(i, item) {
				myDashboardTable.row.add(item).draw(false);
			});
		});		
	}

	function getMonthFilter(month) {
		$.get('ajax/monthFilter/'+month,function (result) {
			var data = $.parseJSON(result);
			generalLoad = data;
			$('#dashboard-table').dataTable().fnClearTable();
			$.each(generalLoad, function(i, item) {
				myDashboardTable.row.add(item).draw(false);
			});
		});
	}

	function getDateFilter(myDateFilter) {
		$.get('ajax/dateFilter/'+myDateFilter,function (result) {
			var data = $.parseJSON(result);
			generalLoad = data;
			$('#dashboard-table').dataTable().fnClearTable();
			$.each(generalLoad, function(i, item) {
				myDashboardTable.row.add(item).draw(false);
			});
		});
	}
	setInterval(function () {
		
		update();		
		
	},100);	


});

