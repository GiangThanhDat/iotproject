// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function(n, prec) {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function browse(idStation,sensorMeasuresList) {
  sensorMeasuresList.forEach(function(elem) {
    setValue(idStation,elem['ma_cambien'],elem['ma_dailuong']);
  });
}


console.log(keys);


function addData(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  console.log(chart.data.labels);
  console.log(chart.data.datasets[0].data);
  chart.update();
}

function removeData(chart, lim) {
  if (chart.data.datasets[0].data.length >= lim) {
    chart.data.labels.shift();
    chart.data.datasets[0].data.shift();  
  }
  chart.update();
}
var time = "";


function update() {
  console.log("collect/get/"+keys['ma_tram']+"/"+keys['ma_cambien']+"/"+keys['ma_dailuong']);
  $.get("collect/get/"+keys['ma_tram']+"/"+keys['ma_cambien']+"/"+keys['ma_dailuong'],function(val){
    // console.log(val);
    val = $.parseJSON(val);
    
    value = val['val'];
    newTime = val['time'];
    if(newTime != time){     
      console.log(val);
      console.log(time);
      addData(myLineChart,newTime,value);
      removeData(myLineChart,20);
      time = newTime;
    }
  });  
}



$(document).ready(function() {
  setInterval(function () {
      update();
  },100)
});


// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    // labels: [1,2,3,4,5,6,7,8,9,10,11,12],
    datasets: [{
      label: "Earnings",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      // data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 10,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks:{
          beginAtZero:true
        }      
      }],
    }
  }
});


