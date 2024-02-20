// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var w1 = document.querySelector("#myAreaChart").getAttribute("data-w1");
var w2 = document.querySelector("#myAreaChart").getAttribute("data-w2");
var w3 = document.querySelector("#myAreaChart").getAttribute("data-w3");
var w4 = document.querySelector("#myAreaChart").getAttribute("data-w4");
var w5 = document.querySelector("#myAreaChart").getAttribute("data-w5");
var count_days = document.querySelector("#myAreaChart").getAttribute("data-count-days");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["7 Днів", "14 Днів", "21 Днів", "28 Днів", count_days + " Днів"],
    datasets: [{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [w1, w2, w3, w4, w5],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 20,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
