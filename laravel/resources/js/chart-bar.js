// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var m1 = document.getElementById("myBarChart").getAttribute("data-m6");
var m2 = document.getElementById("myBarChart").getAttribute("data-m5");
var m3 = document.getElementById("myBarChart").getAttribute("data-m4");
var m4 = document.getElementById("myBarChart").getAttribute("data-m3");
var m5 = document.getElementById("myBarChart").getAttribute("data-m2");
var m6 = document.getElementById("myBarChart").getAttribute("data-m1");
var mv1 = document.getElementById("myBarChart").getAttribute("data-mv6");
var mv2 = document.getElementById("myBarChart").getAttribute("data-mv5");
var mv3 = document.getElementById("myBarChart").getAttribute("data-mv4");
var mv4 = document.getElementById("myBarChart").getAttribute("data-mv3");
var mv5 = document.getElementById("myBarChart").getAttribute("data-mv2");
var mv6 = document.getElementById("myBarChart").getAttribute("data-mv1");
var month = ["Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"];
var barMonth = [month[m1-1], month[m2-1], month[m3-1], month[m4-1], month[m5-1], month[m6-1]];

var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: barMonth,
    datasets: [{
      label: "Revenue",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [mv1, mv2, mv3, mv4, mv5, mv6],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 60,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
