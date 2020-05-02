<?php
include('koneksi_covid.php');
$country = mysqli_query($koneksi,"SELECT * FROM tb_country");
while($row = mysqli_fetch_array($country)){
	$nama_country[] = $row['Country'];

	$query = mysqli_query($koneksi,"SELECT new_cases, total_deaths, new_deaths, total_recovered, active_cases FROM tb_covid WHERE id_country='".$row['id_country']."'");
	$row = $query->fetch_array();
	$new_cases[] = $row['new_cases'];
	$total_deaths[] = $row['total_deaths'];
	$new_deaths[] = $row['new_deaths'];
	$total_recovered[] = $row['total_recovered'];
	$active_cases[] = $row['active_cases'];
} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>COVID-19 : Total Cases 10 Negara</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>


	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_country); ?>,
				datasets: [{
					label: 'New Cases',
					data: <?php echo json_encode($new_cases); ?>,
					backgroundColor: 'rgba(0, 0, 0, 0.5)',
					borderWidth: 1
				} , {
					label: 'Total Deaths',
					data: <?php echo json_encode($total_deaths); ?>,
					backgroundColor: 'rgba(128, 4, 0, 0.5)',
					borderWidth: 1
				}, {
					label: 'New Deaths',
					data: <?php echo json_encode($new_deaths); ?>,
					backgroundColor: 'rgba(139, 5, 0, 0.5)',
					borderWidth: 1
				} , {
					label: 'Total Recovered',
					data: <?php echo json_encode($total_recovered); ?>,
					backgroundColor: 'rgba(178, 34, 33, 0.5)',
					borderWidth: 1
				} , {
					label: 'Active Cases',
					data: <?php echo json_encode($active_cases); ?>,
					backgroundColor: 'rgba(255, 0, 0, 0.5)',
					borderWidth: 1
				}
				]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>