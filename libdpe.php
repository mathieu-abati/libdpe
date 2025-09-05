<?php
/**
* libDPE - Une librairie pour générer des diagrammes de Diagnostic de Performance
* Énergétique et climatique (DPE).
* @copyright Copyright (c) 2010-2025 Mathieu ABATI (mathieu.abati@gmail.com)
* @author Mathieu ABATI
*/

define('NORMAL_FONT_SIZE', 0.027);
define('LOGEMENT_PERFORMANT_TEXT', "logement extrêmement performant");
define('LOGEMENT_PERFORMANT_TEXT_X', 0.333);
define('LOGEMENT_PERFORMANT_TEXT_Y', 0.07);
define('LOGEMENT_PEU_PERFORMANT_TEXT', "logement extrêmement peu performant");
define('LOGEMENT_PEU_PERFORMANT_TEXT_X', 0.333);
define('LOGEMENT_PEU_PERFORMANT_TEXT_Y', 0.913);
define('CONSOMMATION_TEXT', "consommation");
define('CONSOMMATION_TEXT_X', 0.05);
define('CONSOMMATION_TEXT_Y_OFFSET', -0.152);
define('CONSOMMATION_TEXT_CLASS_A_Y_OFFSET', 0.106);
define('EMISSIONS_TEXT', "émissions");
define('EMISSIONS_TEXT_X', 0.22);
define('EMISSIONS_TEXT_Y_OFFSET', -0.120);
define('EMISSIONS_TEXT_CLASS_A_Y_OFFSET', 0.108);
define('ENERGIE_PRIMAIRE_TEXT', "(énergie primaire)");
define('ENERGIE_PRIMAIRE_TEXT_X', 0.036);
define('ENERGIE_PRIMAIRE_TEXT_Y_OFFSET', -0.118);
define('ENERGIE_PRIMAIRE_TEXT_CLASS_A_Y_OFFSET', 0.14);
define('PASSOIRE_TEXT', "passoire");
define('PASSOIRE_TEXT_X', 0.213);
define('PASSOIRE_TEXT_Y', 0.777);
define('ENERGETIQUE_TEXT', "énergétique");
define('ENERGETIQUE_TEXT_X', 0.18);
define('ENERGETIQUE_TEXT_Y', 0.81);
define('ENERG_VALUES_FONT_SIZE', 0.075);
define('ENERG_CONSO_TEXT_X', 0.12);
define('ENERG_EMISS_TEXT_X', 0.26);
define('ENERG_EMISS_ASTERISK_FONT_SIZE', 0.035);
define('ENERG_EMISS_ASTERISK_TEXT_X', 0.265);
define('ENERG_EMISS_ASTERISK_TEXT_Y_OFFSET', -0.029);
define('ENERG_KWH_TEXT', "kWh/m²/an");
define('ENERG_KWH_TEXT_X', 0.064);
define('ENERG_KWH_TEXT_Y_OFFSET', 0.033);
define('ENERG_CO2_TEXT', "kg CO₂/m²/an");
define('ENERG_CO2_TEXT_X', 0.208);
define('ENERG_CO2_TEXT_Y_OFFSET', 0.033);
define('DONT_EMISSIONS_FONT_SIZE', 0.035);
define('DONT_EMISSIONS_TEXT', "* Dont émissions de gaz\nà effet de serre");
define('DONT_EMISSIONS_TEXT_X', 0.128);
define('DONT_EMISSIONS_TEXT_Y', 0.157);
define('PEU_EMISSIONS_TEXT', "peu d’émissions de CO₂");
define('PEU_EMISSIONS_TEXT_X', 0.134);
define('PEU_EMISSIONS_TEXT_Y', 0.265);
define('EMISSIONS_IMPORTANTES_TEXT', "émissions de CO₂\ntrès importantes");
define('EMISSIONS_IMPORTANTES_TEXT_X', 0.134);
define('EMISSIONS_IMPORTANTES_TEXT_Y', 0.675);
define('GES_VALUE_FONT_SIZE', 0.048);
define('GES_UNIT_FONT_SIZE', 0.022);
define('GES_CO2_TEXT', "kg CO₂/m²/an");
define('GES_CO2_TEXT_X_OFFSET', 0.01);
define('GES_CO2_TEXT_Y_OFFSET', 0);

/*
 * Donne la classe énergétique en fonction des valeurs
 * @param[in] consommation
 * @param[in] émissions
 * @param[in] zone climatique spéciale?
 * @return classe DPE
 */
function dpe_energ_val_to_class($conso, $emiss, $special_zone)
{
    if ($conso < 70 && $emiss < 6)
        return 'A';
    else if ((70 <= $conso && $conso < 110 && $emiss < 11)
	    || (6 <= $emiss && $emiss < 11 && $conso < 110))
        return 'B';
    else if ((110 <= $conso && $conso < 180 && $emiss < 30)
	    || (11 <= $emiss && $emiss < 30 && $conso < 180))
        return 'C';
    else if ((180 <= $conso && $conso < 250 && $emiss < 50)
	    || (30 <= $emiss && $emiss < 50 && $conso < 250))
        return 'D';
    else if ($special_zone == false) {
	    if ((250 <= $conso && $conso < 330 && $emiss < 70)
		    || (50 <= $emiss && $emiss < 70 && $conso < 330))
            return 'E';
	    else if ((330 <= $conso && $conso < 420 && $emiss < 100)
		    || (70 <= $emiss && $emiss < 100 && $conso < 420))
            return 'F';
        else // if ($conso >= 420 || $emiss >= 100)
            return 'G';
    } else { // zones H1b, H1c et H2d ou altitude > 800m
	    if ((250 <= $conso && $conso < 390 && $emiss < 80)
		    || (50 <= $emiss && $emiss < 80 && $conso < 390))
            return 'E';
	    else if ((390 <= $conso && $conso < 500 && $emiss < 110)
		    || (80 <= $emiss && $emiss < 110 && $conso < 500))
            return 'F';
        else // if ($conso >= 500 || $emiss >= 110)
            return 'G';
    }
}

/*
 * Donne la classe climatique en fonction de la valeur
 * @param[in] émissions
 * @param[in] zone climatique spéciale?
 * @return classe DPE
 */
function dpe_ges_val_to_class($emiss, $special_zone)
{
    if ($emiss < 6)
        return 'A';
    else if (6 <= $emiss && $emiss < 11)
        return 'B';
    else if (11 <= $emiss && $emiss < 30)
        return 'C';
    else if (30 <= $emiss && $emiss < 50)
        return 'D';
    else if ($special_zone == false) {
        if (50 <= $emiss && $emiss < 70)
            return 'E';
        else if (70 <= $emiss && $emiss < 100)
            return 'F';
        else // $emiss >= 100
            return 'G';
    } else { // zones H1b, H1c et H2d ou altitude > 800m
        if (50 <= $emiss && $emiss < 80)
            return 'E';
        else if (80 <= $emiss && $emiss < 110)
            return 'F';
        else // $emiss >= 110
            return 'G';
    }
}

/*
 * Donne la position Y de la valeur dans le diagramme énergétique en fonction
 * de la classe
 * @param[in] classe DPE
 * @return position Y
 */
function dpe_energ_class_to_y_pos($dpe_class)
{
    switch($dpe_class) {
        case 'A':
            return 0.193;
        case 'B':
            return 0.29;
        case 'C':
            return 0.393;
        case 'D':
            return 0.495;
        case 'E':
            return 0.602;
        case 'F':
            return 0.705;
        case 'G':
        default:
            return 0.805;
    }
}

/*
 * Donne la position X de la valeur dans le diagramme climatique en fonction de
 * la classe
 * @param[in] classe DPE
 * @return position X
 */
function dpe_ges_class_to_x_pos($dpe_class)
{
    switch($dpe_class) {
        case 'A':
            return 0.43;
        case 'B':
            return 0.48;
        case 'C':
            return 0.52;
        case 'D':
            return 0.57;
        case 'E':
            return 0.602;
        case 'F':
            return 0.61;
        case 'G':
        default:
            return 0.62;
    }
}

/*
 * Donne la position Y de la valeur dans le diagramme climatique en fonction de
 * la classe
 * @param[in] classe DPE
 * @return position Y
 */
function dpe_ges_class_to_y_pos($dpe_class)
{
    switch($dpe_class) {
        case 'A':
            return 0.337;
        case 'B':
            return 0.385;
        case 'C':
            return 0.43;
        case 'D':
            return 0.478;
        case 'E':
            return 0.525;
        case 'F':
            return 0.57;
        case 'G':
        default:
            return 0.615;
    }
}

/*
 * Générer un diagramme de performance énergétique ou climatique.
 * @param[in] hauteur du diagramme
 * @param[in] zone climatique spéciale?
 * @param[in] émissions
 * @param[in] consommation (optionnel, si non présent un diagramme énergétique
 * est produit, si présent un diagramme climatique est produit)
 * @return Imagick, représentant le diagramme (à libérer après utilisation)
 */
function gen_dpe($dpe_height, $special_zone, $emiss, $conso=null)
{
    if($emiss < 0 || ($conso !== null && $conso < 0))
        return null;

    // calcul de classe DPE et position de la valeur dans l'image
    if ($conso !== null)
        $dpe_class = dpe_energ_val_to_class($conso, $emiss, $special_zone);
    else
        $dpe_class = dpe_ges_val_to_class($emiss, $special_zone);

    // définition des couleurs
    $color_none = new ImagickPixel( "transparent" );
    $color_white = new ImagickPixel("white");
    $color_black = new ImagickPixel('black');
    $color_green = new ImagickPixel('#00a06c');
    $color_red = new ImagickPixel('#d71d20');
    $color_gray = new ImagickPixel('#918f90');
    $color_blue = new ImagickPixel('#89b2d1');
    $color_purple = new ImagickPixel('#1e162a');

    // chargement du schéma DPE vierge
    if ($conso !== null) {
        $image_template_filename = "pics/DPE__etiquette energie $dpe_class.png";
    } else {
        $image_template_filename = "pics/DPE__etiquette GES $dpe_class.png";
    }
    $image_template = new Imagick($image_template_filename);
    $image_template_width = $image_template->getImageWidth();
    $image_template_height = $image_template->getImageHeight();
    $dpe_width = ($dpe_height / $image_template_height) * $image_template_width;
    $image_template->adaptiveResizeImage($dpe_width, $dpe_height, false);
    $image_template->setImageFormat('png');
    $image_template->setImageMatte(true);

    // préparation de l'image du DPE à compléter
    $image_dpe = new Imagick();
    $image_dpe->newImage($dpe_width, $dpe_height, "white");
    $image_dpe->setImageFormat('png');
    $image_dpe->setImageMatte(true);

    // copie du DPE vierge dans l'image du DPE
    $image_template->transparentPaintImage('#ffffff', 0.0, 0.0, false);
    $image_dpe->compositeImage($image_template, imagick::COMPOSITE_OVER, 0, 0,
	    Imagick::CHANNEL_ALL);

    // écriture des textes
    $texts = new ImagickDraw();
    if ($conso !== null) {
        $value_y_pos = dpe_energ_class_to_y_pos($dpe_class);
        $texts->setFont("fonts/IBMPlexSans-Medium.otf");
        $texts->setFontSize(NORMAL_FONT_SIZE * $dpe_height);
        // "logement extrêmement performant"
        $texts->setFillColor($color_green);
        $texts->annotation($dpe_width * LOGEMENT_PERFORMANT_TEXT_X,
		$dpe_height * LOGEMENT_PERFORMANT_TEXT_Y,
		LOGEMENT_PERFORMANT_TEXT);
        // "logement extrêmement peu performant"
        $texts->setFillColor($color_red);
        $texts->annotation($dpe_width * LOGEMENT_PEU_PERFORMANT_TEXT_X,
		$dpe_height * LOGEMENT_PEU_PERFORMANT_TEXT_Y,
		LOGEMENT_PEU_PERFORMANT_TEXT);
        // "consommation"
        $texts->setFont("fonts/IBMPlexSansCondensed-Medium.otf");
        $texts->setFillColor($color_black);
        if ($dpe_class != 'A') {
            $texts->annotation($dpe_width * CONSOMMATION_TEXT_X,
		    $dpe_height * ($value_y_pos + CONSOMMATION_TEXT_Y_OFFSET),
		    CONSOMMATION_TEXT);
        } else {
            $texts->annotation($dpe_width * CONSOMMATION_TEXT_X,
		    $dpe_height * ($value_y_pos + CONSOMMATION_TEXT_CLASS_A_Y_OFFSET),
		    CONSOMMATION_TEXT);
        }
        // "émissions"
        if ($dpe_class != 'A') {
            $texts->annotation($dpe_width * EMISSIONS_TEXT_X,
		    $dpe_height * ($value_y_pos + EMISSIONS_TEXT_Y_OFFSET),
		    EMISSIONS_TEXT);
        } else {
            $texts->annotation($dpe_width * EMISSIONS_TEXT_X,
		    $dpe_height * ($value_y_pos + EMISSIONS_TEXT_CLASS_A_Y_OFFSET),
		    EMISSIONS_TEXT);
        }
        // unités valeur
        $texts->annotation($dpe_width * ENERG_KWH_TEXT_X,
		$dpe_height * ($value_y_pos + ENERG_KWH_TEXT_Y_OFFSET),
		ENERG_KWH_TEXT);
        $texts->annotation($dpe_width * ENERG_CO2_TEXT_X,
		$dpe_height * ($value_y_pos + ENERG_CO2_TEXT_Y_OFFSET),
		ENERG_CO2_TEXT);
        // "énergie primaire"
        $texts->setFillColor($color_gray);
        if ($dpe_class != 'A') {
            $texts->annotation($dpe_width * ENERGIE_PRIMAIRE_TEXT_X,
		    $dpe_height * ($value_y_pos + ENERGIE_PRIMAIRE_TEXT_Y_OFFSET),
		    ENERGIE_PRIMAIRE_TEXT);
        } else {
            $texts->annotation($dpe_width * ENERGIE_PRIMAIRE_TEXT_X,
		    $dpe_height * ($value_y_pos + ENERGIE_PRIMAIRE_TEXT_CLASS_A_Y_OFFSET),
		    ENERGIE_PRIMAIRE_TEXT);
        }
        // "passoire énergétique"
        if ($dpe_class != 'E' && $dpe_class != 'F' && $dpe_class != 'G') {
            $texts->setFont("fonts/IBMPlexSans-Medium.otf");
            $texts->annotation($dpe_width * PASSOIRE_TEXT_X,
                $dpe_height * PASSOIRE_TEXT_Y, PASSOIRE_TEXT);
            $texts->annotation($dpe_width * ENERGETIQUE_TEXT_X,
                $dpe_height * ENERGETIQUE_TEXT_Y, ENERGETIQUE_TEXT);
        }
        // valeur consommation
        $texts->setFillColor($color_black);
        $texts->setFont("fonts/IBMPlexSansCondensed-Bold.otf");
        $texts->setFontSize(ENERG_VALUES_FONT_SIZE * $dpe_height);
        $text_width = $image_dpe->queryFontMetrics($texts, $conso)['textWidth'];
        $texts->annotation($dpe_width * ENERG_CONSO_TEXT_X - $text_width / 2,
            $dpe_height * $value_y_pos, $conso);
        // valeur émissions
        $text_width = $image_dpe->queryFontMetrics($texts, $emiss)['textWidth'];
        $texts->annotation($dpe_width * ENERG_EMISS_TEXT_X - $text_width / 2,
            $dpe_height * $value_y_pos, $emiss);
        $texts->setFontSize(ENERG_EMISS_ASTERISK_FONT_SIZE * $dpe_height);
        $texts->annotation($dpe_width * ENERG_EMISS_ASTERISK_TEXT_X + $text_width / 2,
            $dpe_height * ($value_y_pos + ENERG_EMISS_ASTERISK_TEXT_Y_OFFSET), "*");
    } else {
        $value_x_pos = dpe_ges_class_to_x_pos($dpe_class);
        $value_y_pos = dpe_ges_class_to_y_pos($dpe_class);
        $texts->setFont("fonts/IBMPlexSans-Bold.otf");
        $texts->setFontSize(DONT_EMISSIONS_FONT_SIZE * $dpe_height);
        // "dont émissions de GES"
        $texts->setFillColor($color_black);
        $texts->annotation($dpe_width * DONT_EMISSIONS_TEXT_X,
            $dpe_height * DONT_EMISSIONS_TEXT_Y, DONT_EMISSIONS_TEXT);
        // "peu d'émissions"
        $texts->setFont("fonts/IBMPlexSans-Medium.otf");
        $texts->setFontSize(NORMAL_FONT_SIZE * $dpe_height);
        $texts->setFillColor($color_blue);
        $texts->annotation($dpe_width * PEU_EMISSIONS_TEXT_X,
            $dpe_height * PEU_EMISSIONS_TEXT_Y, PEU_EMISSIONS_TEXT);
        // "émissions importantes"
        $texts->setFillColor($color_purple);
        $texts->annotation($dpe_width * EMISSIONS_IMPORTANTES_TEXT_X,
		$dpe_height * EMISSIONS_IMPORTANTES_TEXT_Y,
		EMISSIONS_IMPORTANTES_TEXT);
        // unité valeur
        $text_width = $image_dpe->queryFontMetrics($texts, $emiss)['textWidth'];
        $texts->setFontSize(GES_UNIT_FONT_SIZE * $dpe_height);
        $texts->setFillColor($color_black);
        $texts->annotation($dpe_width * ($value_x_pos + GES_CO2_TEXT_X_OFFSET) + $text_width,
            $dpe_height * ($value_y_pos + GES_CO2_TEXT_Y_OFFSET), GES_CO2_TEXT);
        // valeur émissions
        $texts->setFillColor($color_black);
        $texts->setFont("fonts/IBMPlexSansCondensed-Bold.otf");
        $texts->setFontSize(GES_VALUE_FONT_SIZE * $dpe_height);
        $texts->annotation($dpe_width * $value_x_pos - $text_width / 2,
            $dpe_height * $value_y_pos, $emiss);
    }

    // placement des textes dans l'image du DPE
    $image_dpe->drawImage($texts);

    // clean
    $image_template->destroy();
    $texts->destroy();
    $color_none->destroy();
    $color_white->destroy();
    $color_black->destroy();
    $color_green->destroy();
    $color_red->destroy();
    $color_gray->destroy();
    $color_blue->destroy();
    $color_purple->destroy();

    // return image
    return $image_dpe;
}

/*
 * Générer un diagramme de performance énergétique.
 * @param[in] consommation, en kW/m²/an
 * @param[in] émissions, en kg de CO2 par m²/an
 * @param[in] taille d'un côté du diagramme, en pixels
 * @param[in] zone climatique spéciale? (booléen)
 * @return Imagick, représentant le diagramme
 */
function get_dpe_energ($conso, $emiss, $dpe_height, $special_zone)
{
    return gen_dpe($dpe_height, $special_zone, $emiss, $conso);
}

/*
 * Générer un diagramme de performance climatique.
 * @param[in] émissions, en kg de CO2 par m²/an
 * @param[in] taille d'un côté du diagramme, en pixels
 * @param[in] zone climatique spéciale? (booléen)
 * @return Imagick, représentant le diagramme
 */
function get_dpe_ges($emiss, $dpe_height, $special_zone)
{
    return gen_dpe($dpe_height, $special_zone, $emiss);
}

/*
 * Enregistrer l'image d'un diagramme de performance énergétique au format PNG.
 * @param[in] consommation, en kW/m²/an
 * @param[in] émissions, en kg de CO2 par m²/an
 * @param[in] taille d'un côté du diagramme, en pixels
 * @param[in] zone climatique spéciale? (booléen)
 * @param[in] chemin du fichier de destination de l'image PNG
 * @return false en cas d'échec
 */
function save_dpe_energ($conso, $emiss, $dpe_height, $special_zone,
	$image_filename)
{
    $image = get_dpe_energ($conso, $emiss, $dpe_height, $special_zone);
    if($image == null)
        return false;

    $image->setImageFormat('png');
    try {
        $image->writeImage($image_filename);
    } catch (Exception $e) {
        return false;
    }

    $image->destroy();
    return true;
}

/*
 * Enregistrer l'image d'un diagramme de performance climatique au format PNG.
 * @param[in] émissions, en kg de CO2 par m²/an
 * @param[in] taille d'un côté du diagramme, en pixels
 * @param[in] zone climatique spéciale? (booléen)
 * @param[in] chemin du fichier de destination de l'image PNG
 * @return false en cas d'échec
 */
function save_dpe_ges($emiss, $dpe_height, $special_zone, $image_filename)
{
    $image = get_dpe_ges($emiss, $dpe_height, $special_zone);
    if($image == null)
        return false;

    $image->setImageFormat('png');
    try {
        $image->writeImage($image_filename);
    } catch (Exception $e) {
        return false;
    }

    $image->destroy();
    return true;
}

?>
