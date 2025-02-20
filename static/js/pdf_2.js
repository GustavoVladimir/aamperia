var grafica_tarifa = new Chart($('#grafica_tarifa'), {
	type: 'bar',
	data: {
		labels: ['1', '2', '3', '4', '5', '6'],
		datasets: [{
			data: [890, 500, 700, 600, 1200, 800],
			backgroundColor: '#F0A202'
		}]
	},
	options: {
		scales: {
			y: {
				beginAtZero: true
			}
		},
		plugins: {
			autocolors: false,
			annotation: {
				annotations: {
					line1: {
						type: 'line',
						yMin: 782,
						yMax: 782,
						borderColor: 'rgb(255, 0, 0)',
						borderWidth: 2,
						label: {
							content:"Promedio de consumo: 782 kWh",
							enabled: true,
							yAdjust: -10,
							backgroundColor: 'rgba(0,0,0,0)',
							color: '#000000'
						}
					},
					line2: {
						type: 'line',
						yMin: 653,
						yMax: 653,
						borderColor: 'rgb(146, 208, 80)',
						borderWidth: 2,
						label: {
							content:"Generación por paneles: 653 kWh",
							enabled: true,
							yAdjust: 10,
							backgroundColor: 'rgba(0,0,0,0)',
							color: '#000000'
						}
					}
				}
			},
			legend: {
				display: false
			},
			tooltip: {
				enabled: false
			},
			title: {
				display: true,
				text: "kWh consumidos",
				font: {
					size: 20
				}
			}
		}
	}
});