$( document ).ready(function() {
    var table_data = [];
    $.getJSON("results.json", function(data) {
        for (var i = 0; i < data.posts.length; i++) {
            var temp = {};
            temp.y = data.posts[i].TEMP;
            temp.x = i;
            table_data.push(temp);
        }
        console.log(table_data);
    });

    var ctx = $("#myChart");
    var scatterChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Temparature Dataset',
                data: table_data,
                fill: true
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'linear',
                    position: 'bottom'
                }]
            }
        }
    });
});
