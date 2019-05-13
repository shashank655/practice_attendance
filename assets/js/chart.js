    // Chart

var colorsDash = ['#0b2035', '#4e87c0' ,'#086ed5'];
Morris.Donut({
  element: 'school-chart',
  colors: colorsDash,
  resize: true,
   labels: ['Series A', 'Series B','Series C'],
  data: [
    {label: "Students", value: totalStudent},
    {label: "Teachers", value: totalTeacher},
    {label: "Parents", value: totalStudent}
  ],
    xkey: 'label',
  ykeys: ['value'],
   labels: ['Value']
});



$(function() {
      var data = [
        { month: '2018-01', value: 10 },
        { month: '2018-02', value: 20 },
        { month: '2018-03', value: 30 },
        { month: '2018-04', value: 40 },
        { month: '2018-05', value: 50 },
        { month: '2018-06', value: 60 },
        { month: '2018-07', value: 70 },
        { month: '2018-08', value: 80 },
        { month: '2018-09', value: 90 },
        { month: '2018-10', value: 100 },
        { month: '2018-11', value: 110 },
        { month: '2018-12', value: 120 }
      ];
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      new Morris.Line({
        element: 'incomeChart',
        data: data,
        xkey: 'month',
        ykeys: ['value'],
        labels: ['Value'],
        lineColors: ['#36597c'],
        lineWidth: 4,
        pointSize: 6,
        pointFillColors:['rgba(255,255,255,0.9)'],
        pointStrokeColors: ['#01c0c8'],
        gridLineColor: 'rgba(0,0,0,.5)',
        resize: true,
        gridTextColor: '#36597c',
        yLabelFormat: function(value) {
              var ranges = [
                { divider: 1e6, suffix: 'M' },
                { divider: 1e3, suffix: 'k' }
              ];
              function formatNumber(n) {
                for (var i = 0; i < ranges.length; i++) {
                  if (n >= ranges[i].divider) {
                    return Math.round((n / ranges[i].divider)).toString() + ranges[i].suffix;
                  }
                }
                return n;
              }
              return formatNumber(value);
            },
        xLabelFormat: function (x) { return months[x.getMonth()]; }
      });
    });
