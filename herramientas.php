<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de repuesto</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
		
	<!--JQUERY-->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
		<!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
	<link rel="stylesheet"
		href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script 
		src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script 
		src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


	
	<!-- Los iconos tipo Solid de Fontawesome-->
	<link rel="stylesheet"
		href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
	<script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
	
	<!-- Nuestro css-->
	<link rel="stylesheet" type="text/css" href="static/css/user-form.css"
		th:href="@{/css/user-form.css}">
	<!-- DATA TABLE -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">


	<style>
		.content {
			margin-top: 80px;
		}
	</style>

    <style>
		.content {
			margin-top: 80px;
		}

		#heading { color: #FFFFFF; }
	</style>


</head>
<body>
	<div class="container">
		<div class="content">
			<h2 id="heading"><b>Importar Excel de Llenado de Informacion</b></h2>
			<div class="card-body">
						<div class="table-responsive">
							<table id="userList" class="table table-bordered table-hover table-striped">

                                <form class="formulariocompleto" method="POST">
								<tr>
                                    <th><input type="file" name="Archivo" class="form-control"/></th>
                                    <td><input type="submit" name="Enviarpdf" value="SUBIR ARCHIVO" class="form-control"/></td>
								</tr>
                            </form>
					</table>
				</div>
			</div>

			<?php
	if(isset($_POST['Enviarpdf'])){
		$archivo = $_FILES["Archivo"]["name"];
		$archivoCopiado = $_FILES["Archivo"]["tmp_name"];
		$archivoGuardado = "Copia_".$archivo;

		if(copy($archivoCopiado, $archivoGuardado)){
			
		}else{
			echo "No se ha copiado Nada Error";
		}

		if(file_exists($archivoGuardado)){
			
			$abrir = fopen($archivoGuardado, "r");

			$row = 0;
			while (($datos = fgetcsv($abrir,10000, ";")))
			{		
				$row ++;	
					//$resultado = insertdatefec($datos[0], $datos[1]);
				if($row > 1)
				{
					$data = array(
						'codigo1' => $datos[0],
						'codigo2' => $datos[1],
						'nombre' => $datos[2],
						'marca' => $datos[3],
						'modelo' => $datos[4],
						'anio' => $datos[5],
						'precio' => $datos[6],
						'descripcion' => $datos[7]
					);
					$url = 'http://testing.autopartesrostran.es/api/producto';

					$opts = array('http' =>
							array(
								'method' => 'POST',
								'header' => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query($data)
							)
						);

					$context = stream_context_create($opts);
					$result = file_get_contents($url, false, $context);
										
					//$sentencia = "insert into datos values ('$datos[0]', '$datos[1]', '$datos[2]','$datos[3]', '$datos[4]', '$datos[5]', '$datos[6]', '$datos[7]')";
					//$resultado = mysqli_query($con, $sentencia);
					var_dump($result);
					
					if($result){
						
					}else {
						echo " NO se inserto";
					}
				}
			}
		}else{
			echo "No existe el archivo copiado";
		}	
	}
	?>
            </div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>