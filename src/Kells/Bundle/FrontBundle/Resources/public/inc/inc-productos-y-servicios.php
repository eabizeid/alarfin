<div class="row botmar productos">

	<?php if ($seccion != "individuos") { ?>
    <div class="<?php if ($seccion == "productos") { ?>col-sm-3<?php } else { ?>col-sm-4<?php } ?>">
        <div class="well">
            <a href="productos-y-servicios-creditos-prendarios-individuos.php">
                <img src="img/imagen-productos-y-servicios-creditos-prendarios-individuos.png" width="104" height="104" alt="Cr&eacute;ditos Prendarios Individuos" title="Cr&eacute;ditos Prendarios Individuos">
                <h2>Cr&eacute;ditos Prendarios Individuos</h2>
                <img src="img/misc-flecha-abajo.png" width="33" height="20" alt="Cr&eacute;ditos Prendarios Individuos" title="Cr&eacute;ditos Prendarios Individuos">
            </a>
        </div>
    </div>
    <?php } ?>
    
    <?php if ($seccion != "corporativos") { ?>
    <div class="<?php if ($seccion == "productos") { ?>col-sm-3<?php } else { ?>col-sm-4<?php } ?>">
        <div class="well">
            <a href="productos-y-servicios-creditos-prendarios-corporativos.php">
                <img src="img/imagen-productos-y-servicios-creditos-prendarios-corporativos.png" width="104" height="104" alt="Cr&eacute;ditos Prendarios Corporativos" title="Cr&eacute;ditos Prendarios Corporativos">
                <h2>Cr&eacute;ditos Prendarios Corporativos</h2>
                <img src="img/misc-flecha-abajo.png" width="33" height="20" alt="Cr&eacute;ditos Prendarios Corporativos" title="Cr&eacute;ditos Prendarios Corporativos">
            </a>
        </div>
    </div>
    <?php } ?>
    
    <?php if ($seccion != "facturas") { ?>
    <div class="<?php if ($seccion == "productos") { ?>col-sm-3<?php } else { ?>col-sm-4<?php } ?>">
        <div class="well">
            <a href="productos-y-servicios-compra-de-facturas.php">
                <img src="img/imagen-productos-y-servicios-compra-de-facturas.png" width="104" height="104" alt="Compra de Facturas" title="Compra de Facturas">
                <h2>Compra de Facturas</h2>
                <img src="img/misc-flecha-abajo.png" width="33" height="20" alt="Compra de Facturas" title="Compra de Facturas">
            </a>
        </div>
    </div>
    <?php } ?>
    
    <?php if ($seccion != "cheques") { ?>
    <div class="<?php if ($seccion == "productos") { ?>col-sm-3<?php } else { ?>col-sm-4<?php } ?>">
        <div class="well">
            <a href="productos-y-servicios-compra-de-cheques.php">
                <img src="img/imagen-productos-y-servicios-compra-de-cheques.png" width="104" height="104" alt="Compra de Cheques" title="Compra de Cheques">
                <h2>Compra de Cheques</h2>
                <img src="img/misc-flecha-abajo.png" width="33" height="20" alt="Compra de Cheques" title="Compra de Cheques">
            </a>
        </div>
    </div>
    <?php } ?>
    
</div>