// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var mp1 = document.getElementById("myPieChart").getAttribute("data-m1");
var mp2 = document.getElementById("myPieChart").getAttribute("data-m2");
var mp3 = document.getElementById("myPieChart").getAttribute("data-m3");
var mp4 = document.getElementById("myPieChart").getAttribute("data-m4");
var mp5 = document.getElementById("myPieChart").getAttribute("data-m5");
var mv1 = document.getElementById("myPieChart").getAttribute("data-mv1");
var mv2 = document.getElementById("myPieChart").getAttribute("data-mv2");
var mv3 = document.getElementById("myPieChart").getAttribute("data-mv3");
var mv4 = document.getElementById("myPieChart").getAttribute("data-mv4");
var mv5 = document.getElementById("myPieChart").getAttribute("data-mv5");

var labels = [];
var data = [];
(mp1 != null) ? labels.push(mp1) : "";
(mp2 != null) ? labels.push(mp2) : "";
(mp3 != null) ? labels.push(mp3) : "";
(mp4 != null) ? labels.push(mp4) : "";
(mp5 != null) ? labels.push(mp5) : "";

(mv1 != null) ? data.push(mv1) : "";
(mv2 != null) ? data.push(mv2) : "";
(mv3 != null) ? data.push(mv3) : "";
(mv4 != null) ? data.push(mv4) : "";
(mv5 != null) ? data.push(mv5) : "";

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#7828A7FF'],
    }],
  },
});
