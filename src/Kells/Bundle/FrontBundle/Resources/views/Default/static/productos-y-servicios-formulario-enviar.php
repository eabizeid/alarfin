<?php 
	
	if( $_POST["action"] == "send" ):
	
		$nombre			= addslashes($_REQUEST["nombre"]);
		$email			= addslashes($_REQUEST["email"]);
		$telefono		= addslashes($_REQUEST["telefono"]);
		$producto		= addslashes($_REQUEST["producto"]);
		$consulta		= addslashes($_REQUEST["consulta"]);						

		switch ($producto) {
			case "corporativos":
				$producto = "Créditos Prendarios Corporativos";
				break;
			case "individuos":
				$producto = "Créditos Prendarios Individuos";
				break;
			case "facturas":
				$producto = "Compra de Facturas";
				break;
			case "cheques":
				$producto = "Compra de Cheques";
				break;
		}
		
		$mensaje = '
					<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					<html>
					<head>
					<title>Untitled Document</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					</head>
					<body>
						<table width="560" border="0" style="font-family:Arial, Tahoma, Verdana, Helvetica, sans-serif;font-size:12px;color:#000;">
						  <tr>
							<td width="210">Nombre y Apellido:</td>
							<td width="350"><strong>'.$nombre.'</strong></td>
						  </tr>
						  <tr>
							<td>E-mail:</td>
							<td><strong>'.$email.'</strong></td>
						  </tr>
						  <tr>
							<td>Teléfono:</td>
							<td><strong>'.$telefono.'</strong></td>
						  </tr>
						  <tr>
							<td>Producto:</td>
							<td><strong>'.$producto.'</strong></td>
						  </tr>
						  <tr>
							<td>Consulta o comentario:</td>
							<td><strong>'.$consulta.'</strong></td>
						  </tr>
						</table>
					</body>
					</html>			
					';

		$headers = "Content-type: text/html;\n Content-Type: image/jpg;\n Content-Transfer-Encoding: base64;\n charset=iso-8859-1\n";
		$headers .= "From: Alarfin <info@alarfin.com.ar>\n\r";

		$subject = "Consulta por producto desde la web";

		mail("alarfinsa@gmail.com", $subject, $mensaje, $headers);

		header("Location: productos-y-servicios-gracias.php");
	endif;
?>