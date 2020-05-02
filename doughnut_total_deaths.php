<?php
include('koneksi_covid.php');
$country = mysqli_query($koneksi,"SELECT * FROM tb_country");
while($row = mysqli_fetch_array($country)){
	$nama_country[] = $row['Country'];

	$query = mysqli_query($koneksi,"SELECT total_deaths FROM tb_covid WHERE id_country='".$row['id_country']."'");
	$row = $query->fetch_array();
	$total_deaths[] = $row['total_deaths'];
} 
?>
<!doctype html>
<html>

<head>
	<title>Doughnut Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>

<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data:<?php echo json_encode($total_deaths); ?>,
					backgroundColor: [
					'rgba(0, 0, 0, 0.5)',
					'rgba(128, 4, 0, 0.5)',
					'rgba(139, 5, 0, 0.5)',
					'rgba(178, 34, 33, 0.5)',
					'rgba(255, 0, 0, 0.5)',
					'rgba(205, 92, 92, 0.5)',
					'rgba(233, 150, 122, 0.5)',
					'rgba(250, 128, 114, 0.5)',
					'rgba(250, 99, 71, 0.5)',
					'rgba(253, 218, 185, 0.5)'
					],
					label: 'Presentase Total Cases Covid-19 10 Negara'
				}],
				labels: <?php echo json_encode($nama_country); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>