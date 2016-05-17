<?php

require './includes/BarcodeBase.php';
require './includes/QRCode.php';
require './includes/DataMatrix.php';
require './includes/Code39.php';
require './includes/Code128.php';

$bcode = array();

#$bcode['qr']	= array('name' => 'QR Code', 'obj' => new emberlabs\Barcode\QRCode());
#$bcode['dm']	= array('name' => 'DataMatrix', 'obj' => new emberlabs\Barcode\DataMatrix());
#$bcode['c39']	= array('name' => 'Code39', 'obj' => new emberlabs\Barcode\Code39());
$bcode['c128']	= array('name' => 'Code128', 'obj' => new emberlabs\Barcode\Code128());

function bcode_error($m)
{
	echo "<div class='error'>{$m}</div>";
}

function bcode_success($bcode_name)
{
	echo "<div class='success'>A $bcode_name barcode was successfully created</div>";
}

function bcode_img64($b64str)
{
	echo "<img src='data:image/png;base64,$b64str' /><br />";
}

?>
<html>
<head>

<title>Barcode Tester</title>

<style type="text/css">
	.error, .success {
		margin: 20px 0 20px 0;
		font-weight: bold;
		padding: 15px;
		color: #FFF;
	}

	.error {
		background-color: #A00;
	}

	.success {
		background-color: #0A0;
	}
</style>

</head>
<body>

<form action="index.php" method="post">

Enter Data to encode: <input type="text" name="encode" value="<?php echo htmlspecialchars($_POST['encode']); ?>" /><br />
<input type="submit" value="Encode" name="submit" />

</form>

<hr />

<?php 

if (isset($_POST['submit'])) {

?>
Data to be encoded: <strong><?php echo htmlspecialchars($_POST['encode']); ?></strong><br />

<?php
	foreach($bcode as $k => $value)
	{
		try
		{
			$bcode[$k]['obj']->setData($_POST['encode']);
			$bcode[$k]['obj']->setSubType(0);
			$bcode[$k]['obj']->setData('|01055480080980010000002294501000000400250000');
			$bcode[$k]['obj']->setDimensions(800, 150);
			$bcode[$k]['obj']->draw();
			$b64 = $bcode[$k]['obj']->base64();

			bcode_success($bcode[$k]['name']);
			bcode_img64($b64);
		}
		catch (Exception $e)
		{
			bcode_error($e->getMessage());
		}
	}
?>

<?php } ?>

</body>
</html>
