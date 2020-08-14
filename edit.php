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

	<!-- Bootstrap 
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
-->
		<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
		
	<!--JQUERY-->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
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

		#heading { color: #FFFFFF; }
	</style>
</head>
<body>
	<div class="container">
		<div class="content">
			<h2 id="heading"><b>Datos del producto &raquo; Editar datos</b></h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$consul = "select nombre, marca, modelo, anio, ROUND(precio,1), codigo1, codigo2, descripcion from producto WHERE id='$nik'";

			$sql = mysqli_query($con,$consul);

			if(mysqli_num_rows($sql) == 0){
				header("Location: user-form.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			
			if(isset($_POST['save'])){
				$codigo1 = $_POST["codigo1"];
				$codigo2 = $_POST["codigo2"];
				$nombre = $_POST["nombre"];
				$marca = $_POST["marca"];
				$modelo = $_POST["modelo"];
				$anio = $_POST["anio"]; 
				$precio = $_POST["precio"];
				$descripcion = $_POST["descripcion"];

				/*
				$url = 'http://testing.autopartesrostran.es/api/producto/'.$nik;
				$body = 'codigo1='.$codigo1.'&codigo2='.$codigo2.'&nombre='.$nombre.'&marca='.$marca.'&modelo='.$modelo.'&anio='.$anio.'&precio='.$precio.'&descripcion='.$descripcion;
				$options = array('method' => 'POST', 'content' => $body);
				$context = stream_context_create(array('http' => $options));
				$page = file_get_contents($url, false, $context);
				
				var_dump($page);
				
				*/

				$data = array(
					'codigo1' => $codigo1,
					'codigo2' => $codigo2,
					'nombre' => $nombre,
					'marca' => $marca,
					'modelo' => $modelo,
					'anio' => $anio,
					'precio' => $precio,
					'descripcion' => $descripcion
				);
				 
				//$url = 'http://testing.autopartesrostran.es/api/producto/'.$nik.'?codigo1='.$codigo1.'&codigo2='.$codigo2.'&nombre='.$nombre.'&marca='.$marca.'&modelo='.$modelo.'&anio='.$anio.'&precio='.$precio.'&descripcion='.$descripcion;

				$url = 'http://testing.autopartesrostran.es/api/producto/'.$nik;
				$opts = array('http' =>
						array(
						'method' => 'POST',
						'header' => 'Content-type: application/x-www-form-urlencoded',
						'content' => http_build_query($data)
					)
				);

				$context = stream_context_create($opts);
				$result = file_get_contents($url, false, $context);	
				
				if($result){
					header("Location: edit.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
				
				
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
				header("Location: user-form.php");
			}
			?>

			<div class="card-body">
						<div class="table-responsive">
			<form class="form-horizontal" action="" method="POST" >
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Código 1</label>
					<div class="col-sm-2">
						<input type="text" name="codigo1" value="<?php echo $row['codigo1']; ?>" class="form-control" placeholder="Codigo 1" required >
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Codigo 2</label>
					<div class="col-sm-4">
						<input type="text" name="codigo2" value="<?php echo $row ['codigo2']; ?>" class="form-control" placeholder="Codigo 2" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Producto</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Marca del Producto</label>
					<div class="col-sm-4">
						<input type="text" name="marca" value="<?php echo $row ['marca']; ?>" class="form-control" placeholder="Marca" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Modelo del Vehiculo</label>
					<div class="col-sm-4">
						<input type="text" name="modelo" value="<?php echo $row ['modelo']; ?>" class="form-control" placeholder="Modelo" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Descripcion</label>
					<div class="col-sm-3">
						<textarea name="descripcion" class="form-control" placeholder="Dirección"> <?php echo $row ['descripcion']; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Año del Vehiculo</label>
					<div class="col-sm-3">
						<input type="text" name="anio" value="<?php echo $row ['anio']; ?>" class="form-control" placeholder="Año" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Precio</label>
					<div class="col-sm-3">
						
						<input type="text" name="precio" value="<?php echo $row ['ROUND(precio,1)']; ?>" class="form-control" placeholder="precio" required>
					</div>
                    
				</div>
				<!--
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option value="">- Selecciona estado -</option>
                            <option value="1" <?php if ($row ['estado']==1){echo "selected";} ?>>Fijo</option>
							<option value="2" <?php if ($row ['estado']==2){echo "selected";} ?>>Contrado</option>
							<option value="3" <?php if ($row ['estado']==3){echo "selected";} ?>>Outsourcing</option>
						</select> 
					</div>
                   
                </div>
            -->			
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="user-form.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>
</body>
</html>