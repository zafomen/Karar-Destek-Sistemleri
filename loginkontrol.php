 <?php
require("connection.php");
$sorgula=mysqli_query($baglan,"SELECT eposta,sifre FROM admin 
WHERE eposta='".$_POST["eposta"]."' AND sifre='".$_POST["sifre"]."'");
if(mysqli_num_rows($sorgula)>0){
 echo "<script> location.href='http://localhost/panel.php'; </script>";
        exit;
}else{
echo "Kullanıcı Adı ve Parola Yanlış";
?>
<form method="post" action="login.html">
    <button type="submit">Tekrar Deneyiniz</button>
</form>
<?php
}
?>