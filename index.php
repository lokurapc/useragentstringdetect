<?php
require_once 'browser.php';
$br = new Browser($_SERVER['HTTP_USER_AGENT']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Identificando el navegador con PHP</title>
	</head>
	<body>
		<p>
			<strong><?php echo $br->Agent ?></strong>
		</p>
		<p>
			Sitema Operativo: <strong><?php echo $br->Platform." ".$br->Pver?></strong><br>
			Navegador: <strong><?php echo $br->Name." ".$br->Version ?></strong>
		</p>
		<p>
		<?php
		echo '<img src="./img/os/'.$br->PlatformImage.'.png" alt="'.$br->Platform.' '.$br->Pver.'" title="'.$br->Platform.' '.$br->Pver.' '.$br->Architecture.'"> ';
		echo '<img src="./img/net/'.$br->BrowserImage.'.png" alt="'.$br->Name.' '.$br->Version.'" title="'.$br->Name.' '.$br->Version.'">';
		?>
		</p>
		<p>
		<?php echo $br->Architecture; ?>
		</p>
	</body>
</html>
