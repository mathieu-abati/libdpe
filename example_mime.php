<?php
/**
* Génération et retour d'une image PNG de DPE vers le navigateur. Du point de
* vue du client, le fichier PHP est vu comme une image.
*
* @copyright Copyright (c) 2010-2025 Mathieu ABATI (mathieu.abati@gmail.com)
* @author Mathieu ABATI
*/

header ("Content-type: image/png");

include('libdpe.php');

$type = $_GET['type'];
$emiss = $_GET['emiss'];
if (isset($_GET['special_zone']) && $_GET['special_zone'] == 1)
    $special_zone = true;
else
    $special_zone = false;
if (isset($_GET['conso']))
    $conso = $_GET['conso'];
$height = $_GET['height'];

if($type == 'ges')
    $image = get_dpe_ges($emiss, $height, $special_zone);
else
    $image = get_dpe_energ($conso, $emiss, $height, $special_zone);

if($image == null)
    $image = new Imagick();

$image->setImageFormat('png');
echo $image;

?>

