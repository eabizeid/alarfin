<?php $seccion = "productos"; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="iso-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gracias por contactarnos - Productos y Servicios | Alarfin - Servicios Financieros</title>
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
                    <h1>Productos y Servicios
                </h1></div>
            </div>
            <div class="row botpad">
				<div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="row topmar botpad text-center linea-punteada-gris-abajo">
                    	<div class="col-xs-12">
	                    	<h3 class="nomar text-normal">Gracias por contactarnos, pronto nos comunicaremos con usted.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row topmar">
                <div class="col-xs-12 text-center">
                    <h3 class="text-uppercase nomar">otros Productos y Servicios</h3>
                    <?php include('inc/inc-productos-y-servicios.php'); ?>
                </div>
            </div>
        </div>
        <?php include('inc/inc-footer.php'); ?>  
    </body>
</html>