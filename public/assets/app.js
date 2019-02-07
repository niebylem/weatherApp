function randomScalingFactor() {
    return Math.floor(Math.random() * 40);
}

jQuery(function () {
    $.getJSON("/api/threedayweather", function (data) {
        console.log(data);
        for (let i = 0; i < data.length; i++) {
            window.myLine.data.labels.push(data[i].date);
            window.myLine.data.datasets[0].data[i] = data[i].temperature;
            window.myLine.data.datasets[1].data[i] = data[i].snow;
            window.myLine.data.datasets[2].data[i] = data[i].rain;
            window.myLine.data.datasets[3].data[i] = data[i].clouds/100;
            window.myLine.update();
        }
    });

    var config = {
        type: 'bar',
        data: {
            datasets: [{
                type: 'line',
                label: 'Temperatura [°C]',
                fill: false,
                backgroundColor: '#962D3E',
                borderColor: '#962D3E',
            }, {
                type: 'bar',
                label: 'Śnieg [mm/3h]',
                backgroundColor: '#F2EBC7',
                borderColor: '#F2EBC7',
                fill: false,
            }, {
                type: 'bar',
                label: 'Deszcz [mm/3h]',
                backgroundColor: '#1073C4',
                borderColor: '#1073C4',
                fill: false,
            }, {
                type: 'line',
                label: 'Zachmurzenie [%]',
                fill: true,
                backgroundColor: '#51D3ED',
                borderColor: '#348899',
                borderDash: [5, 5],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Pogoda na najbliższe 3 dni'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                    },
                    ticks: {
                        max: 25
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Temperatura [°C]'
                    }
                }]
            }
        }
    };

    var ctx = document.getElementById('threeDayForecast').getContext('2d');
    window.myLine = new Chart(ctx, config);
});