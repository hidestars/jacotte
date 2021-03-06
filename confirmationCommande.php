<?php 
include('fonctions.php');
session_start();

$array = $_SESSION['cart'];
$json = __json_encode($array);

function getHolidays($year = null)
{
  if ($year === null)
  {
    $year = intval(date('Y'));
  }
 
  $easterDate  = easter_date($year);
  $easterDay   = date('j', $easterDate);
  $easterMonth = date('n', $easterDate);
  $easterYear   = date('Y', $easterDate);
 
  $holidays = array(
    // Dates fixes
    mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
    mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
    mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
    mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
    mktime(0, 0, 0, 8,  15, $year),  // Assomption
    mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
    mktime(0, 0, 0, 11, 11, $year),  // Armistice
    mktime(0, 0, 0, 12, 25, $year),  // Noel
 
    // Dates variables
    mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
    mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
    mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
  );
 
  sort($holidays);
 
  return $holidays;
}

function isHoliday($timestamp)
{
    $iDayNum = strftime('%u', $timestamp);
    $iYear = strftime('%Y', $timestamp);

    $aHolidays = getHolidays($iYear);

    /*
    * On est oblige de convertir les timestamps en string a cause des decalages horaires.
    */
    $aHolidaysString = array_map(function ($value)
    {
            return strftime('%Y-%m-%d', $value);
    }, $aHolidays);

    if (in_array(strftime('%Y-%m-%d', $timestamp), $aHolidaysString) OR $iDayNum == 6 OR $iDayNum == 7)
    {
            return true;
    }
    return false;
}

try
  {
  	$news = false;

  	if(isset($_POST["newsletter"])){
  		$news = true;
  	}
  	else{
  		$news = false;
  	}
  	
  	$date = "";

	$date_actu = date('G');
	$date_fin= 10; // 18
	$date_debut= 0; // 9
	 
	if($date_debut <= $date_actu and $date_actu<= $date_fin)
	{
		if(date("N")=="6"){
			$date = new DateTime('+1 day');
			$date ->modify('+ 1 day');
			$date = $date->format('d/m/Y');
		}else{
			if(date("N")=="7"){
			$date = new DateTime('+1 day');
			$date = $date->format('d/m/Y');
			}
			else{
				if(isHoliday(time())){
					$date = new DateTime('+1 day');
					$date = $date->format('d/m/Y');
				}else{
					$date = date("d/m/Y");
				}
			}
		}		
	}
	else
	{
		if(date("N")=="6"){
			$date = new DateTime('+1 day');
			$date ->modify('+ 1 day');
			$date = $date->format('d/m/Y');
		}
		else{
			if(date("N")=="7"){
			$date = new DateTime('+1 day');
			$date = $date->format('d/m/Y');
			}
			else{
				if(isHoliday(time() + 86400)){
					$date = new DateTime('+1 day');
					$date ->modify('+ 1 day');
					$date = $date->format('d/m/Y');
				}else{
					$date = new DateTime('+1 day');
					$date = $date->format('d/m/Y');
				}
			}
		}
	}
    $bdd = new PDO('mysql:host=localhost;dbname=jacotte;charset=utf8', 'root', 'root');
    $query="INSERT INTO commande values (
    DEFAULT,
    '".$_POST["ville"]."',
    '".$_POST["adresse"]."',
    '".$_POST["nom"]."',
    '".$_POST["tel"]."',
    '".$_POST["mail"]."',
    '".$news."',
    '".$date."',
    '".$_SESSION["prixTotal"]."'
    )";
    $bdd->query($query);
    $query = "SELECT id FROM commande WHERE id = LAST_INSERT_ID()";
    $id = $bdd->query($query);
    $id = $id->fetch();

    for($i = 0;$i<sizeof($_SESSION["cart"]);$i++){
	    	$query="INSERT INTO commandemenu values(
	    DEFAULT,
	    '".$_SESSION["cart"][$i]["idMenu"]."',
	    '".$id[0]."',
	    '".$_SESSION["cart"][$i]["qte"]."'
	    )";
	    $bdd->query($query);
	    if(isset($_SESSION["cart"][$i]["idEntree"])){
		    $query = "UPDATE entree
				  SET qte = qte - ".$_SESSION["cart"][$i]["qte"].
				  " WHERE id = ".$_SESSION["cart"][$i]["idEntree"].
				  ";";

			$bdd->query($query);
		}
		if(isset($_SESSION["cart"][$i]["idPlat"])){
			$query = "UPDATE plat
				  SET qte = qte - ".$_SESSION["cart"][$i]["qte"].
				  " WHERE id = ".$_SESSION["cart"][$i]["idPlat"].
				  ";";

			$bdd->query($query);
		}
		if(isset($_SESSION["cart"][$i]["idDessert"])){
			$query = "UPDATE dessert
				  SET qte = qte - ".$_SESSION["cart"][$i]["qte"].
				  " WHERE id = ".$_SESSION["cart"][$i]["idDessert"].
				  ";";

			$bdd->query($query);
		}
		if(isset($_SESSION["cart"][$i]["idFromage"])){
			$query = "UPDATE fromage
				  SET qte = qte - ".$_SESSION["cart"][$i]["qte"].
				  " WHERE id = ".$_SESSION["cart"][$i]["idFromage"].
				  ";";

			$bdd->query($query);
		}
		if(isset($_SESSION["cart"][$i]["idBoisson"])){
			$query = "UPDATE boisson
				  SET qte = qte - ".$_SESSION["cart"][$i]["qte"].
				  " WHERE id = ".$_SESSION["cart"][$i]["idBoisson"].
				  ";";

			$bdd->query($query);
		}
    }
    
    $mail = '<html>
	<body style="background: #f2f2f2;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;">
		<div style="max-width: 560px;padding: 20px;background: #ffffff;border-radius: 5px;margin:40px auto;font-family: Open Sans,Helvetica,Arial;font-size: 15px;color: #666;"><div style="max-width: 560px;padding: 20px;background: #ffffff;border-radius: 5px;margin:40px auto;font-family: Open Sans,Helvetica,Arial;font-size: 15px;color: #666;">
				<div style="color: #444444;font-weight: normal;">
						<div style="text-align: center;font-weight:600;font-size:26px;padding: 10px 0;border-bottom: solid 3px #eeeeee;"><a href="https://lacuisinedejacotte.fr/"><img src="https://www.lacuisinedejacotte.fr/img/logo.jpg"></a></div>
						
						<div style="clear:both"></div>
				</div>
				
				<div style="padding: 0 30px 30px 30px;border-bottom: 3px solid #eeeeee;">
						<div style="padding:20px 0;font-size: 24px;text-align: center;line-height: 40px;">Merci de votre confiance<span style="display:block;">Votre commande est prise en compte</span></div>
						<div style="font-size: 16px;text-align: center;line-height: 40px;">Livraison :<span style="display:block;">'.$_POST["adresse"].', '.$_POST["ville"].'</span></div>';
					for($i = 0;$i<sizeof($_SESSION["cart"]);$i++){
						$mail.='<div style="padding-bottom:10px;font-size:14px;text-align:left; height:40px; display:block;"><img src=https://www.lacuisinedejacotte.fr/img/produit/'.$_SESSION["cart"][$i]["image"].' width="30" height="30" style="vertical-align:middle;margin-right:10px"> <span style="line-height:40px">'.$_SESSION["cart"][$i]["nom"].'</span></div>';
					}
						
					$mail.='
					</div>
					
					<div style="color: #999;padding: 20px 30px">
							<div style="">Merci !</div>
							
					</div>
			</div>
			</body>
</html>';
$headers = 'From: La cuisine de Jacotte <lacuisinedejacotte@outlook.fr>' . "\r\n";	
$headers .= "X-Mailer: PHP ".phpversion()."\n";
$headers .= "X-Priority: 1 \n";
$headers .= "Mime-Version: 1.0\n";
$headers .= "Content-Transfer-Encoding: 8bit\n";
$headers .= "Content-type: text/html; charset= utf-8\n";
$headers .= "Date:" . date("D, d M Y h:s:i") . " +0200\n";	
$to      = $_POST["mail"];
$subject = 'Confirmation de votre commande - La cuisine de Jacotte';
$message = $mail;

mail($to, $subject, $message, $headers);
}
  catch (Exception $e)
  {
    die('Erreur : ' . $e->getMessage());
  }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>La cuisine de Jacotte</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php include('navbar.php'); ?>
	<div class="container menu">
		<div class="row">
			<div class="col-lg-offset-4 col-lg-4">
				<h1 class="titleCheckout">Merci pour votre confiance !</h1>
				<div>
				<a id="hiddenCart" style="display:none"><?php echo $json ?></a>
				</div>
				<p class="textEnd">Je prépare dès à présent votre commande, un e-mail de confirmation vient d'être envoyé à l'adresse : <b><?php echo $_POST["mail"]; ?></b></p>
				<p class="textEnd">Livraison prévue le <b><?php echo $date; ?></b> entre <b>11h et 12h30</b> à <?php echo $_POST["adresse"]; ?> pour 
				<?php if($_POST["prenom"]==""){
					echo $_POST["nom"];
					} else {
						echo $_POST["prenom"]." ".$_POST["nom"];
					} ?></b></p>
				<p class="textEnd">Total de votre commande : <b><?php echo $_SESSION["prixTotal"]; ?>€</b></p>
			</div>
		</div>
	</div>

	<?php include('footer.php'); ?>
	<script type="text/javascript" src="js/jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://cdn.jsdelivr.net/vue.resource/1.2.1/vue-resource.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript">
		console.log("Coucou");
		setTimeout(function(){
			vm.calcPrixTotal();
		},100);
	</script>
</body>

</html>