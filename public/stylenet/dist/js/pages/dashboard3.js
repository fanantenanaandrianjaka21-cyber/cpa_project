$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: 'blue',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : ['JUIN', 'JULLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'],
      datasets: [
        {
          backgroundColor: '#00ABE4',
          borderColor    : '#007bff',
          data           : [1500, 2300, 3000, 2100, 2800, 2000, 3000]
        },
        {
          backgroundColor: 'black',
          borderColor    : '#ced4da',
          data           : [1400, 1900, 2700, 2900, 1950, 1200, 2600]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += '0000Ar'
              }
              return '1000' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })

  var $visitorsChart = $('#visitors-chart')
  var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      labels  : ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
      datasets: [{
        type                : 'line',
        data                : [150, 100, 160, 148, 123, 147, 180],
        backgroundColor     : 'transparent',
        borderColor         : '#00ABE4',
        pointBorderColor    : '#00ABE4',
        pointBackgroundColor: '#00ABE4',
        fill                : false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      },

      // ilay ovana
        {
          type                : 'line',
          data                : [16, 70, 31, 69, 84, 72, 106],
          backgroundColor     : 'tansparent',
          borderColor         : 'black',
          pointBorderColor    : '#ced4da',
          pointBackgroundColor: 'black',
          fill                : false
          // pointHoverBackgroundColor: '#ced4da',
          // pointHoverBorderColor    : '#ced4da'
        }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero : true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
})
