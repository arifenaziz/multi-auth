var baseURL = $('body').data('baseurl');


function getDashboardStatusCount() {

$.getJSON( baseURL + "request/Dashboard/getDashboardStatusCountProcessing",function(data){

$('.active_company').text(data.active_company);
$('.active_consumer').text(data.active_consumer);
$('.pending_consumer').text(data.pending_consumer);

})

} 



function getDashboardTestPodCount() {
$.getJSON(baseURL+"request/Dashboard/getDashboardTestPodCountProcessing",function(data){

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
        {
            label: data.daily_booking.label,
            value: data.daily_booking.value,

        }, 
        {
            label: data.weekly_booking.label,
            value: data.weekly_booking.value,
        },        
        {
            label: data.monthly_booking.label,
            value: data.monthly_booking.value,
        }, 

        {
            label: data.yearly_booking.label,
            value: data.yearly_booking.value,
        }

        ],
        resize: true,
        colors:['#f9a203', '#ee534f', '#2dca0d' , '#1f73bd']
    });
});


}



function getDashboardCompanyStatsCount() {



$.getJSON(baseURL+"request/Dashboard/DashboardChartDataProcessing",function(data){
        var companyData=data.company_data;        

        var company_array=companyData.split(',').map(Number);
   

        var max=data.maxVAl*1.3;

 
        

        var chart = new Chartist.Bar('.amp-pxl', {
          labels: ['January', 'February', 'March', 'April', 'May', 'June','July', 'August', 'September', 'October', 'November', 'December'],
          series: [

            [...company_array]
     
            ]
        }, 
        {
          axisX: {
            // On the x-axis start means top and end means bottom
            position: 'end',
            showGrid: false
        },
        axisY: {
            // On the y-axis start means left and end means right
            position: 'start'
            , labelInterpolationFnc: function (value) {
                return (value / 1) + '';
            }
        },
        high: max,
        low: '0',
        plugins: [
        Chartist.plugins.tooltip()
        ]
    });


        // Offset x1 a tiny amount so that the straight stroke gets a bounding box
        // Straight lines don't get a bounding box 
        // Last remark on -> http://www.w3.org/TR/SVG11/coords.html#ObjectBoundingBox
        chart.on('draw', function(ctx) {  
          if(ctx.type === 'area') {    
            ctx.element.attr({
              x1: ctx.x1 + 0.001
          });
        }
    });

        // Create the gradient definition on created event (always after chart re-render)
        chart.on('created', function(ctx) {
          var defs = ctx.svg.elem('defs');
          defs.elem('linearGradient', {
            id: 'gradient',
            x1: 0,
            y1: 1,
            x2: 0,
            y2: 0
        }).elem('stop', {
            offset: 0,
            'stop-color': 'rgba(255, 255, 255, 1)'
        }).parent().elem('stop', {
            offset: 1,
            'stop-color': 'rgba(38, 198, 218, 1)'
        });
    });


        var chart = [chart];

    // ============================================================== 
    // This is for the animation
    // ==============================================================
    
    for (var i = 0; i < chart.length; i++) {
        chart[i].on('draw', function(data) {
            if (data.type === 'line' || data.type === 'area') {
                data.element.animate({
                    d: {
                        begin: 500 * data.index,
                        dur: 500,
                        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                        to: data.path.clone().stringify(),
                        easing: Chartist.Svg.Easing.easeInOutElastic
                    }
                });
            }
            if (data.type === 'bar') {
                data.element.animate({
                    y2: {
                        dur: 500,
                        from: data.y1,
                        to: data.y2,
                        easing: Chartist.Svg.Easing.easeInOutElastic
                    },
                    opacity: {
                        dur: 500,
                        from: 0,
                        to: 1,
                        easing: Chartist.Svg.Easing.easeInOutElastic
                    }
                });
            }
        });
    }


});



}




$(function() {
    getDashboardStatusCount();
    getDashboardCompanyStatsCount();
    getDashboardTestPodCount();
});



 