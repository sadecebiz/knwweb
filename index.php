<?php
if (!file_exists("baglanti.php")){
		require("install.php");
		die;
	}
include("baglanti.php");
require("meta.php");
error_reporting(0);
session_start();
ob_start();

$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id = ?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch();

$kullanicisor = $db->prepare("select * from authme where username=:username");
$kullanicisor->execute(array('username' => $_SESSION['user_nick']));

$kullanici = $kullanicisor->fetch(PDO::FETCH_ASSOC);

if($_POST){
		$kadi = $_POST["kadi"];
		$sifre = md5($_POST["sifre"]);
		$yetki = "a";
		$kullanicisor=$db->prepare("SELECT * FROM authme WHERE username=? and password=?");
		$kullanicisor->execute(array($kadi,$sifre));
		$islem=$kullanicisor->fetch();
		$yetkisor=$db->prepare("SELECT * FROM authme WHERE yetki=? and id=?");
		
		if($islem){
			$_SESSION['user_nick'] = $islem['username'];
			$_SESSION['yetki'] = $islem['yetki'];
			$_SESSION['uyeid'] = $islem['id'];
			?>
			<div>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
			<script type="text/javascript">swal.fire("Giriş Başarılı!", "Başarıyla giriş yaptınız!", "success");
			</script>
			</div>			
			<?php
		} else{
			?>
			<div>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
			<script type="text/javascript">swal.fire("Giriş Hatalı!", "Bilgileriniz hatalı! Tekrar deneyiniz.", "error");
			</script>
			</div>
			<?php
		} 
	}
?>

<?php
	include ('ayar.php');
	
	$sayfa = intval($_GET["s"]);
	
	if(!$sayfa){
		$sayfa = 1;
	}
	
	$say = $db->query("SELECT * from yazilar");
	$toplamveri = $say->rowCount();
	$sayfa_sayisi = ceil($toplamveri/$yazi_limit);
	
	if($sayfa > $sayfa_sayisi){
		$sayfa = 1;
	}
	
	$goster = $sayfa * $yazi_limit - $yazi_limit;
	$gorunensayfa = 6;
?>
	<!DOCTYPE html>
		<html>
			<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<style type="text/css">
					.swal2-popup {
  font-size: 1.6rem !important;
}

				</style>
				<title><?php echo $ayarcek['site_title']; ?></title>
				
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<link rel="stylesheet" type="text/css" href="libs/css/main.css" >
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.4.0/balloon.min.css">
				<link rel="stylesheet" type="text/css" href="libs/ion/css/ionicons.min.css">
				<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
				<link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
				<link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700|Montserrat:400,700|Share+Tech+Mono" rel="stylesheet">
 
 
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5031375987916829",
    enable_page_level_ads: true
  });
</script>
				<style>
					body,h1,h2,h3,h4,h5,p,li {font-family: 'Montserrat', sans-serif;}
				 
				</style>
			</head>
 
<body>
<div class="header">
	<br>
	<br>
	<center>
		<img src="libs/img/logo.png" width="30%" />
	</center>
 
	<div class="container">
	 

		<div id="navbar" class="navbar navbar-default nav"> 

			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#joseph-photos-nav-collapse" aria-expanded="false"> 
					<i class="ion-navicon-round"></i>
					</button>
				</div>
				<?php include "topbar.php"; ?>
			</div> 
 
		</div> 

 
<br>
<div class="content-2">
		<div class="col-lg-8">
<?php
					function kisalt($kelime, $str = 10)
					{
						if (strlen($kelime) > $str)
						{
							if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
							else $kelime = substr($kelime, 0, $str).'...';
						}
						return $kelime;
					}
			$duyuru_cek = $db->query("SELECT * FROM yazilar ORDER BY id DESC limit $goster,$yazi_limit");
			$duyuru_cek->execute();		
			if($duyuru_cek->rowCount() != 0)
			{

				foreach ($duyuru_cek as $duyuru_oku) 
				{

			?>
			<div style="border: 0px solid; border-radius: 10px;" class="MainNews">
				<div style="border: 0px solid; border-radius: 10px;" class="NewsTitle">
					<h3><b>  <?php echo $duyuru_oku['baslik'] ?></b></h3>
					<h5><b>  Yayınlanma tarihi: <?php echo $duyuru_oku['tarih'] ?></b></h5>
					<h5><b>  Duyuru Kategorisi: <?php echo $duyuru_oku['kategori'] ?></b></h5>
					
				</div>
		 
				<div class="NewsATT">
				 
					<div>&nbsp;</div>
					<p>
						<?php 
					?>
					
					<?php 

					echo kisalt($duyuru_oku['yazi'], 120);
					if (strlen($duyuru_oku['yazi']) > 120) 
						{ ?>
					 <br><br><b> <div><a href="devam.php?id=<?=$duyuru_oku['id']?>"> Devamını okuyun</a></div></b>
					<?php } ?>
					</p> 
				</div>
		  
  
    		<div style="border: 0px solid; border-radius: 10px;" class="NewsFooter">
				<h5><b><i class="fa fa-pencil"></i>  Yazar: <?php echo $duyuru_oku['yazar'] ?></b></h5>
				
			</div>
			<br>
			</div>
			<div>&nbsp;</div>
			<br>
  <?php
			}
			?>
			<?php if($sayfa > 1){ ?>
			<?php } ?>
			
			<?php
				for ($i = $sayfa - $gorunensayfa; $i < $sayfa + $gorunensayfa + 1; $i++){
					
					if($i > 0 and $i <= $sayfa_sayisi){
						
						if($i == $sayfa){
							
						?>
						
						<?php } else{ ?>
						<?php
						}
						
					}
				}
			?>
			
			<?php if($sayfa != $sayfa_sayisi){ ?>
			<?php }
			}else{
			echo'
				<h3><b style="color:black;">Yönetici tarafından henüz duyuru eklenmemiş.</b></h3>
			';
			}
			?>
			<?php
				for ($i = $sayfa - $gorunensayfa; $i < $sayfa + $gorunensayfa + 1; $i++){
					
					if($i > 0 and $i <= $sayfa_sayisi){
						
						if($i == $sayfa){
							
						?>
						
						<a href="sayfa.php?s=<?php echo $i ?>"><button class="btn btn-succcess"><?php echo $i ?></button></a>
						<?php } else{ ?>
						<a href="sayfa.php?s=<?php echo $i ?>"><button class="btn btn-succcess"><?php echo $i ?></button></a>
						
						<?php
						}
						
					}
				}
			?>
 
<div>&nbsp;</div>
 
</div> 

<?php include "sag.php"; ?>
 <?php include "footer.php"; ?>
 
 
<div>&nbsp;</div>


<script type="text/javascript" src="libs/bootstrap/js/bootstrap.min.js"></script>


<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("navbar-fixed")
  } else {
    navbar.classList.remove("navbar-fixed");
  }
}
</script> 

 <script>
		$(function() {
		  $(window).on("scroll", function() {
			if($(window).scrollTop() > 290) {
			  $("#lk2").addClass("sticky");
			} else {
			  $("#lk2").removeClass("sticky");
			}
		  });
		});
</script>
</body>
 
 
 
 
 
 
 
 
 
 
</html>