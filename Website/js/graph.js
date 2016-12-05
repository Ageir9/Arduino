$( document ).ready(function() {
    var temp_data = [];
    $.getJSON("results.json", function(data) {
        for (var i = 0; i < data.posts.length; i++) {
            var temp = {};
            temp.y = data.posts[i].TEMP;
            temp.x = i;
            temp_data.push(temp);
        }
        console.log(temp_data);
    });

    var ctx = $("#myChart");
    var scatterChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Temparature Dataset',
                data: temp_data

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



    var hum_data = [];
    $.getJSON("results.json", function(data) {
        for (var i = 0; i < data.posts.length; i++) {
            var hum = {};
            hum.y = data.posts[i].HUMIDITY;
            hum.x = i;
            hum_data.push(hum);
        }
        console.log(hum_data);
    });

    var ctx1 = $("#myChart1");
    var scatterChart = new Chart(ctx1, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Humidity Dataset',
                data: hum_data

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



    var CO_data = [];
    $.getJSON("results.json", function(data) {
        for (var i = 0; i < data.posts.length; i++) {
            var co = {};
            co.y = data.posts[i].CO;
            co.x = i;
            CO_data.push(co);
        }
        console.log(CO_data);
    });

    var ctx2 = $("#myChart2");
    var scatterChart = new Chart(ctx2, {
        type: 'line',
        data: {
            datasets: [{
                label: 'CO Dataset',
                data: CO_data

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
