google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);







// Draw the chart and set the chart values
function drawChart() {
  
var data = new google.visualization.DataTable();
 data.addColumn('string', 'category');
  data.addColumn('number', 'cnt');
for(i = 0; i < 5; i++)
    data.addRow([category[i], parseInt(cnt[i])]);


  
  var options = { 'width':550, 'height':400};
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
google.setOnLoadCallback(drawChart);

}