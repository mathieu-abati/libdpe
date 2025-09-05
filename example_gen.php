<?php
/**
* Génération de fichiers d'images PNG de DPE.
*
* @copyright Copyright (c) 2010-2025 Mathieu ABATI (mathieu.abati@gmail.com)
* @author Mathieu ABATI
*/

include("libdpe.php");

save_dpe_energ(3, 6, 800, false, "example_energ_B.png");
save_dpe_ges(6, 800, false, "example_ges_B.png");

save_dpe_energ(50, 50, 800, false, "example_energ_E.png");
save_dpe_ges(50, 800, false, "example_ges_E.png");

save_dpe_energ(84, 76, 800, false, "example_energ_F.png");
save_dpe_ges(76, 800, false, "example_ges_F.png");
?>
