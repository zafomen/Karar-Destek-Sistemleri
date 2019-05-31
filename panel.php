<?php
session_start();
?>
<!DOCTYPE html>  
<html>  
    <head>  
        <title>Akademik Karar Destek Sistemleri</title>
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
						
				
				<?php
				$baglan=mysqli_connect("localhost","root","","kds");
				if($baglan){
				$message = 'Success';
				}
				else{
					die("Veritabanına Bağlanılmadı");
					}
				
				$list=mysqli_query($baglan,"select ders_ad from ders ");
				?>
                            <select name="ders_ad">
							
                                <option value="">Ders Seçiniz</option>
                            
				
				<?php
				while ($row = mysqli_fetch_assoc($list))
							{
							
							 $ders_ad=$rows['ders_ad'];
                             echo "<option value='" . $row['ders_ad'] ."'>" . $row['ders_ad'] ."</option>" ;
                            }
							
				?>
				<input type="submit" name="Submit" value="Select" />
            </select>			
			
			
			
                            
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


if (isset($_POST["ders_ad"])) {
    $ders_ad=$_POST["ders_ad"];  
} 


$_SESSION['ders_ad'] = $ders_ad;
$result1=mysqli_query($baglan,"SELECT round(((0.4 * AVG(ogrenci_ders.vize1)) + (0.6 * AVG(ogrenci_ders.final)))) AS ortalama_basari_puani ,  round(16.6 * AVG(ogrenci_ders.ogr_devam)) AS yuzde_ortalama_devamsizlik , ders.ders_ad,ogrenci_ders.ogr_yil
FROM ogrenci_ders,ders
WHERE ogrenci_ders.ders_kod=ders.ders_kod
and ogrenci_ders.ogr_yil=2018
AND ders.ders_ad='".$ders_ad."'");

$result2=mysqli_query($baglan,"SELECT round(((0.4 * AVG(ogrenci_ders.vize1)) + (0.6 * AVG(ogrenci_ders.final)))) AS ortalama_basari_puani , round(16.6 * AVG(ogrenci_ders.ogr_devam)) AS yuzde_ortalama_devamsizlik , ders.ders_ad,ogrenci_ders.ogr_yil
FROM ogrenci_ders,ders
WHERE ogrenci_ders.ders_kod=ders.ders_kod
and ogrenci_ders.ogr_yil=2019
AND ders.ders_ad='".$ders_ad."'");

$result3=mysqli_query($baglan,"SELECT round(((0.4 * AVG(ogrenci_ders.vize1)) + (0.6 * AVG(ogrenci_ders.final)))) AS ortalama_basari_puani ,  round(16.6 * AVG(ogrenci_ders.ogr_devam)) AS yuzde_ortalama_devamsizlik, ders.ders_ad
FROM ogrenci_ders,ders
WHERE ogrenci_ders.ders_kod=ders.ders_kod
AND ders.ders_ad='".$ders_ad."'");

$chart1_data = '';
$chart2_data = '';
$chart3_data = '';
while($row = mysqli_fetch_array($result1))

{

$chart1_data .= "{ogr_yil:'".$row["ogr_yil"]."', ortalama_basari_puani:".$row["ortalama_basari_puani"].", yuzde_ortalama_devamsizlik:".$row["yuzde_ortalama_devamsizlik"]."}, ";


}
while($row = mysqli_fetch_array($result2))

{

$chart2_data .= "{ogr_yil:'".$row["ogr_yil"]."', ortalama_basari_puani:".$row["ortalama_basari_puani"].", yuzde_ortalama_devamsizlik:".$row["yuzde_ortalama_devamsizlik"]."}, ";


}
while($row = mysqli_fetch_array($result3))

{

$chart3_data .= "{ders_ad:'".$row["ders_ad"]."', ortalama_basari_puani:".$row["ortalama_basari_puani"].", yuzde_ortalama_devamsizlik:".$row["yuzde_ortalama_devamsizlik"]."}, ";


}

$chart1_data = substr($chart1_data, 0, -2);
$chart2_data = substr($chart2_data, 0, -2);
$chart3_data = substr($chart3_data, 0, -2);
?>
            </div>
        </div>  
		</form>
		<form method="post" action="detay.php">
    <input type="hidden" name="varname" value="ders_ad">
    <input type="submit" value="Detaylı İnceleme">
		</form>	
		
    </body>  
</html>

<script>

Morris.Bar({
element : 'chart1',
data:[<?php echo $chart1_data; ?>],
xkey:'ogr_yil',
ykeys:['ortalama_basari_puani','yuzde_ortalama_devamsizlik'],
labels:['ortalama_basari_puani','yuzde_ortalama_devamsizlik'],
hideHover:'auto',
stacked:false
});

</script>
<script>

Morris.Bar({
element : 'chart2',
data:[<?php echo $chart2_data; ?>],
xkey:'ogr_yil',
ykeys:['ortalama_basari_puani','yuzde_ortalama_devamsizlik'],
labels:['ortalama_basari_puani','yuzde_ortalama_devamsizlik'],
hideHover:'auto',
stacked:false
});

</script>
<script>

Morris.Bar({
element : 'chart3',
data:[<?php echo $chart3_data; ?>],
xkey:'ders_ad',
ykeys:['ortalama_basari_puani','yuzde_ortalama_devamsizlik'],
labels:['ortalama_basari_puani','yuzde_ortalama_devamsizlik'],
hideHover:'auto',
stacked:false
});

</script>

