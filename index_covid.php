<?php
include('koneksi_covid.php');
$country = mysqli_query($koneksi,"SELECT * FROM tb_country");
while($row = mysqli_fetch_array($country)){
	$nama_country[] = $row['Country'];

	$query = mysqli_query($koneksi,"SELECT totalcase AS Total FROM tb_total WHERE id_country='".$row['id_country']."'");
	$row = $query->fetch_array();
	$jumlah_case[] = $row['Total'];
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
					label: 'Grafik Total Cases Covid-19 10 Negara',
					data: <?php echo json_encode($jumlah_case); ?>,
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				}]
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