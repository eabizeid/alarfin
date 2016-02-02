<?php $seccion = "individuos"; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="iso-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cr&eacute;ditos Prendarios Individuos - Productos y Servicios | Alarfin - Servicios Financieros</title>
        <meta name="robots" content="index, follow" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="Kells - www.kells.com.ar" />
        <link rel="shortcut icon" href="img/favicon.ico" />
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    	<?php include('inc/inc-menu.php'); ?>
		<?php include('inc/inc-header.php'); ?>         
        <div class="container">
            <div class="row">
                <div class="col-xs-12 titulo">
                	<h2>Productos y Servicios</h2>
                    <h1>Cr&eacute;ditos Prendarios Individuos</h1>
                </div>
            </div>          
        </div>
        <div class="productos-titulo-imagen">
        	<img src="img/imagen-creditos-prendarios-individuos.jpg" class="img-responsive" alt="Cr&eacute;ditos Prensarios Individuos" title="Cr&eacute;ditos Prensarios Individuos">
            <div class="productos-titulo">
            	<h3 class="nomar text-normal"><strong>Alarfin</strong> te acerca  al  plan de financiaci&oacute;n m&aacute;s conveniente del mercado para la compra de veh&iacute;culos para uso particular.</h3>
	        	<h4 class="text-normal">Ahora podes comprar un Auto O Km. o usado, de la manera m&aacute;s simple, con m&iacute;nimos requisitos y con aprobaci&oacute;n inmediata.</h4>
            </div>
        </div>
        <div class="container">                 
                  	<div class="row topmar productos-caracteristicas">
                    	<div class="col-xs-12 text-center botmar20">
	                    	<h3 class="text-uppercase nomar text-bordo">Caracter&iacute;sticas</h3>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6 col-md-5 col-md-offset-1">
                            <ul>
                            	<li>Moneda del pr&eacute;stamo: Pesos.</li>
                            	<li>Tipo de Tasa: Fija.</li>
                            	<li>Porcentajes de Financiaci&oacute;n:<br>
                           	    <h6 class="glyphicon glyphicon-chevron-right text-bordo"></h6> Veh&iacute;culos 0 Km.: 60%<br>
                           	    <h6 class="glyphicon glyphicon-chevron-right text-bordo"></h6> Veh&iacute;culos usados: 50% </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-5">
                            <ul>
                            	<li>Sin gastos de otorgamiento.</li>
                            	<li>Sin gastos administrativos mensuales.</li>
                            	<li>Seguro del Automotor: cobertura m&iacute;nima terceros completos con posibilidad de ampliaci&oacute;n por parte del cliente.</li>
                            </ul>
                        </div>                        
                    </div>                  
                    <div class="row topmar20 botpad linea-punteada-gris-abajo">
                   	  <div class="col-md-10 col-md-offset-1">
                        	<div class="well productos-caracteristicas nomar">
                            <div class="row">
                              <div class="col-xs-12 text-center botmar20">
                        	  		<h3 class="nomar text-uppercase">Requisitos</h3>
                              </div>
                              </div>
                              <div class="row">
                              <div class="col-sm-6">
                                  <ul>
                                    <li>Mayor de 18 a&ntilde;os</li>
                                    <li>Comprobante de ingresos</li>
                                  </ul>
                              </div>
                              <div class="col-sm-6">
                                  <ul>
                                    <li>DNI</li>
                                    <li>Copia de un servicio (luz, gas, tel&eacute;fono, cable)</li>
                                  </ul>
                              </div>
                              </div>
               	          </div>
                      </div>
                    </div>  
                    <div class="row topmar botpad linea-punteada-gris-abajo">
                    	<?php include('inc/inc-productos-y-servicios-formulario.php'); ?>
                    </div>                    
                    <div class="row topmar">
                    	<div class="col-xs-12 text-center">
	                    	<h3 class="text-uppercase nomar">Otros Productos y Servicios</h3>
    	                	<?php include('inc/inc-productos-y-servicios.php'); ?>
                        </div>
                    </div>
    </div>
            </div>
        </div>
        <?php include('inc/inc-footer.php'); ?>  
    </body>
</html>