<?php
	include("conexion.php");
	
	session_start();
	if (empty($_SESSION["usuario"])) {
		# Lo redireccionamos al formulario de inicio de sesión
		header("Location: index.php");
		# Y salimos del script
		exit();
	}

	$quieneres= $_SESSION['usuario'];

	$NameUsers = mysqli_query($con,"SELECT name FROM users WHERE email = '$quieneres' ");
	$Usuari = mysqli_fetch_assoc($NameUsers);
	$valor = $Usuari['name'];

?>
<!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">
<head>
	<title>Productos</title>
	
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

<script type="text/javascript">
	    $(document).ready(function() {
	        //Asegurate que el id que le diste a la tabla sea igual al texto despues del simbolo #
	        $('#UsuarioLista').DataTable({
	        	"language": idiomaEspaniol
	        });
	    } );

	    var idiomaEspaniol = {
    "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad"
                }
}

	</script>
</head>
<body>
	<div class="col-30 col-sm-30 col-md-30 col-lg-50">
	<div class="mx-auto col-sm-8 main-section" id="myTab" role="tablist" style="max-width: max-content;">
		<ul class="nav nav-tabs justify-content-end">
			<li class="nav-item">
			<a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false">Lista</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="true">Formulario</a>				   	
			</li>
			<li class="nav-item">
			<a class="nav-link" id="form-tab" data-toggle="tab" href="#tools" role="tab" aria-controls="form" aria-selected="true">Herramientas</a>				   	
			</li>
			<li>
			<a href="exit.php" class="btn btn-primary"><i class="btn btn-primary"></i>Salir</a>				   	
			</li>
		</ul>
		<div class="tab-content" id="myTabContent" style="width: 1090px;">
			<div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
				<div class="card">
					<div class="card-header" style="text-align: center;">
						<h4>Bienvenido <?php echo $valor; ?> a</h4>
						<center><h4><b>AUTOPARTES ROSTRAN</b></h4></center>

			<?php
				if(isset($_POST['anadir'])){
					$codigo1 = $_POST["codigo1"];
					$codigo2 = $_POST["codigo2"];
					$nombre = $_POST["nombre"];
					$marca = $_POST["marca"];
					$modelo = $_POST["modelo"];
					$anio = $_POST["anio"]; 
					$precio = $_POST["precio"];
					$descripcion = mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"],ENT_QUOTES))); 	

					$cek = mysqli_query($con, "SELECT * FROM producto WHERE codigo1 ='$codigo1'");

					if(mysqli_num_rows($cek) == 0){

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

						if($result){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
						 
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. PRODUCTO EXISTE!</div>';
					}
				}
			?>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="UsuarioLista" class="table table-bordered table-hover table-striped" styles>
								<thead class="thead-light">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Op.</th>
									<th scope="col">Codigo 1</th>
									<th scope="col">Codigo 2</th>
									<th scope="col">Producto</th>
									<th scope="col">Marca Producto </th>
									<th scope="col">Modelo Vehiculo </th>
									<th scope="col">Año del Vehiculo </th>
									<th scope="col">Precio Actual </th>
									<th scope="col">Descripcion </th>
								</tr>
								</thead>
								<tbody>
								<?php
								
									$consulta = "select id, codigo1, codigo2, nombre, marca, modelo, anio, ROUND(precio,1),descripcion
									from producto as p where p.esVisible = 1 order by id DESC";
									$sql = mysqli_query($con,$consulta);
								
									if(mysqli_num_rows($sql) == 0){
										echo '<tr><td colspan="8">No hay datos.</td></tr>';
									}else{
										$no = 1;
										while($row = mysqli_fetch_assoc($sql)){
											echo '
												<tr>
													<th scope="row">'.$no.'</th>
														<td>
														<a href="profile.php?nik='.$row['id'].'" "><i class="fas fa-user-times"></i></a>
														</td>
														<td>'.$row['codigo1'].'</td>
														<td>'.$row['codigo2'].'</td>
														<td> '.$row['nombre'].'</td>
														<td> '.$row['marca'].'</td>
														<td> '.$row['modelo'].'</td>
														<td> '.$row['anio'].' </td>
														<td>'.$row['ROUND(precio,1)'].'</td>
														<td>'.$row['descripcion'].'</td>
												</tr>
											';
											$no++;
										}
									}
								?>	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
				<div class="card">
					<div class="card-header">
						<h4>Ingrese la Informacion</h4>
					</div>
					<div class="card-body">
						<form class="form" role="form" autocomplete="off" method="POST">	
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Codigo 1</label>
								<div class="col-lg-9">
									<input class="form-control" name="codigo1" type="textarea" required >
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Codigo 2</label>
								<div class="col-lg-9">
									<input class="form-control" name = "codigo2" type="textarea" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Producto</label>
								<div class="col-lg-9">
									<input class="form-control" name="nombre" type="textarea" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Marca del producto</label>
								<div class="col-lg-9">
									<input class="form-control" name="marca" type="textarea" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Modelo del Vehiculo</label>
								<div class="col-lg-9">
									<input class="form-control" name="modelo" type="textarea" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Año del Vehiculo</label>
								<div class="col-lg-9">
									<input class="form-control" name="anio" type="textarea" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Precio</label>
								<div class="col-lg-9">
									<input class="form-control" name="precio" type= "number" required>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Descripcion</label>
								<div class="col-lg-9">
									<input class="form-control" name="descripcion" type="text" required >
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-12 text-center">
									<input type="reset" class="btn btn-secondary" value="Cancelar" >
									<input type="submit" name= "anadir" class="btn btn-primary" 
										value="Guardar">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<?php
				if(isset($_POST['export'])){
					
					if(mysqli_num_rows($cek) == 0){

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

						if($result){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
						 
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. PRODUCTO EXISTE!</div>';
					}
				}
			?>

			<!-- Seccion de herramientas -->
			<div class="tab-pane fade" id="tools" role="tabpanel" aria-labelledby="form-tab">
			<h2 id="heading"><b>Importar Excel de Llenado de Informacion</b></h2>
						<div class="table-responsive">
							<table id="tools" class="table table-bordered table-hover table-striped">
                            	<form class="formulariocompleto" method="POST">

								<tr>
                                    <th><input type="file" name="Archivo" class="form-control"/></th>
                                    <td><input type="submit" name= "#" value="SUBIR ARCHIVO" class="form-control"/></td>
								</tr>

								<tr>
									<th><b style="color:#ffffff">Para poder insertar el excel de informacion debera exportar el excel formato CSV(delimitado por comas)</b></th>
									<th><b style="color:#ff0000">¡IMPORTANTE!</b> </th>
								</tr>
                            	</form>
							</table>
						</div>

						<?php
								if(isset($_POST['tolos'])){
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
												//$resultado = insertdatefec($datos[0], $datos[1]);
											$row ++;
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

												var_dump($data);
												
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
			<!-- Final de Herramientas -->
			<!-- paquete de estilos de Tools -->
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
			<!-- finla de estilos de Tools -->
		</div>
	</div>
</div>
</body>
</html>