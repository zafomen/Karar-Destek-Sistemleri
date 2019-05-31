<?php
session_start();
?>
<!DOCTYPE html>  
<html>  
    <head>  
        <title>Detaylı Gösterim</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
		
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

 
		
    </head>  
    <body> 
	
	 <form id="form1" name="form1" method="post">
	 
        <br /><br />
        <div class="container">  
            <h3 align="center">Akademik Karar Destek Sistemleri</h3>  
            <br />  
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="panel-title">Ders Notları ve Devamsızlıkları</h3>
                        </div>
                        <div class="col-md-8">
						
				
				
			
			
			
                            
                        </div>
                    </div>
				
                </div>
				 
                <div class="panel-body" > 
				<table>
				<tr>
					<td>2018 Verileri<div id="chart1" style="width: 550px; height: 310px;"></div>
					<td>2019 Verileri<div id="chart2" style="width: 550px; height: 310px;"></div>
				<tr>
				<table>
					
					<div id="chart3" style="width: 900px; height: 310px; padding-left: 300px;"></div>
				</div>
				<?php

include ('connection.php');
$ders_ad = $_SESSION['ders_ad'];
$result1=mysqli_query($baglan,"SELECT ogrenci.ogr_No,ogrenci_ders.vize1,ogrenci_ders.final, round(16.6 *(ogrenci_ders.ogr_devam)) AS yuzde_ogr_devam
FROM ogrenci_ders,ogrenci,ders
WHERE ogrenci_ders.ders_kod=ders.ders_kod
AND ogrenci.ogr_No=ogrenci_ders.ogr_No
and ogrenci_ders.ogr_yil=2018
and ders_ad = '".$ders_ad."'");


$result2=mysqli_query($baglan,"SELECT ogrenci.ogr_No,ogrenci_ders.vize1,ogrenci_ders.final, round(16.6 *(ogrenci_ders.ogr_devam)) AS yuzde_ogr_devam
FROM ogrenci_ders,ogrenci,ders
WHERE ogrenci_ders.ders_kod=ders.ders_kod
AND ogrenci.ogr_No=ogrenci_ders.ogr_No
and ogrenci_ders.ogr_yil=2019
and ders_ad = '".$ders_ad."'");

$chart1_data = '';
$chart2_data = '';

while($row = mysqli_fetch_array($result1))

{

$chart1_data .= "{ ogr_No:'".$row["ogr_No"]."', vize1:".$row["vize1"].",  final:".$row["final"].",yuzde_ogr_devam:".$row["yuzde_ogr_devam"]."}, ";


}
while($row = mysqli_fetch_array($result2))

{

$chart2_data .= "{ ogr_No:'".$row["ogr_No"]."', vize1:".$row["vize1"].", final:".$row["final"].",yuzde_ogr_devam:".$row["yuzde_ogr_devam"]."}, ";


}

$chart1_data = substr($chart1_data, 0, -2);
$chart2_data = substr($chart2_data, 0, -2);
?>
            </div>
        </div>  
		</form>
		<form action="panel.php">
			<input type="submit" value="Geri Dön">
		</form>	
    </body>  
</html>

<script>

Morris.Bar({
element : 'chart1',
data:[<?php echo $chart1_data; ?>],
xkey:'ogr_No',
ykeys:['vize1','final','yuzde_ogr_devam'],
labels:['vize1','final','yuzde_ogr_devam'],
hideHover:'auto',
stacked:false
});

</script>
<script>

Morris.Bar({
element : 'chart2',
data:[<?php echo $chart2_data; ?>],
xkey:'ogr_No',
ykeys:['vize1','final','yuzde_ogr_devam'],
labels:['vize1','final','yuzde_ogr_devam'],
hideHover:'auto',
stacked:false
});

</script>

