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
			<h2 id="heading"><b>Datos &raquo; Repuesto </b></h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));

			$link = "select p.id, nombre, marca, modelo, anio, ROUND(p.precio,1), (select ROUND(h.precio,1) from historial_producto as h where producto_id = '$nik' ORDER BY id DESC LIMIT 1 ) as precioanterior, codigo1, codigo2, descripcion from producto as p WHERE p.id='$nik'";
			
			$sql = mysqli_query($con,$link);
			if(mysqli_num_rows($sql) == 0){
				//header("Location: index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			
			if(isset($_GET['aksi']) == 'delete'){
				//$delete = mysqli_query($con, "Update producto set esVisible = 0 WHERE id='$nik'");
				$url = 'http://testing.autopartesrostran.es/api/producto/borrar/'.$nik;

				$opts = array('http' =>
					array(
						'method' => 'POST',
						'header' => 'Content-type: application/x-www-form-urlencoded'
						)
				);
				$context = stream_context_create($opts);
				$result = file_get_contents($url, false, $context);

				if($result == 0){
					echo '<div class="alert alert-danger alert-dismissable">><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Dato eliminado con exito</div>';
					header("Location: user-form.php");
				}else{
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se pudo Eliminar</div>';
				}
			}
			?>
			<div class="card-body">
						<div class="table-responsive">
							<table id="userList" class="table table-bordered table-hover table-striped">
								<tr>
									<th width="20%">Código 1</th>
									<td><?php echo $row['codigo1']; ?></td>
								</tr>
								<tr>
									<th>Codigo 2</th>
									<td><?php echo $row['codigo2']; ?></td>
								</tr>
								<tr>
									<th>Producto</th>
									<td><?php echo $row['nombre']; ?></td>
								</tr>
								<tr>
									<th>Marca del Producto</th>
									<td><?php echo $row['marca']; ?></td>
								</tr>
								<tr>
									<th>Modelo del Vehiculo</th>
									<td><?php echo $row['modelo']; ?></td>
								</tr>
								<tr>
									<th>Año del Vehiculo</th>
									<td><?php echo $row['anio']; ?></td>
								</tr>				
								<tr>
									<th>Precio</th>
									<td><?php echo $row['ROUND(p.precio,1)']; ?></td>
								</tr>
								<tr>
									<th>Precio Anterior</th>
									<td><?php echo $row['precioanterior']; ?></td>
								</tr>
								<tr>
									<th>Descripcion</th>
									<td><?php echo $row['descripcion']; ?></td>
								</tr>
					</table>
				</div>
			</div>
			
			<a href="user-form.php" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Regresar</a>
			<a href="edit.php?nik=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar datos</a>
			<a href="profile.php?aksi=delete&nik=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de borrar los datos <?php echo $row['nombres']; ?>')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</a>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>