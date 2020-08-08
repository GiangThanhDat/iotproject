
function browse(idStation,sensorMeasuresList) {	
	sensorMeasuresList.forEach(function(elem) {		
		setValue(idStation,elem['ma_cambien'],elem['ma_dailuong']);
	});
}

function setValue(ma_tram,ma_cambien,ma_dailuong) {
	$.get("collect/get/"+ma_tram+"/"+ma_cambien+"/"+ma_dailuong,function(val){
		// console.log(val);
		val = $.parseJSON(val);		
		value = val['val'];
		time = val['time'];
		max = val['max'];
		min = val['min'];
		myColor = val['mau'];
		var myTime = time.substr(11, 8);
		if (value > max || value <= min) {
			console.log(value + " > " + max);
			// console.log($('#val_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong));
			// $('#val_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong).css("background-color", );			
			$('#val_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong).css("color", myColor);	
			$('#time_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong).css("color", myColor);	
			$('#dv_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong).css("color", myColor);	
		}
		$('#val_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong).html(value);		
		$('#time_'+ma_tram+"_"+ma_cambien+"_"+ma_dailuong).html(myTime);		
	});
}

$(document).ready(function(){
	setInterval(function(){		
		browse(idStation,sensorMeasuresList);
	}, 100);
});

