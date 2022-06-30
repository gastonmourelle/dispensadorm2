<?php
$escribir = "<?php $" . "UIDresultado=''; " . "echo $" . "UIDresultado;" . " ?>";
file_put_contents('uid.php', $escribir);
?>

<!DOCTYPE html>
<html lang="es">
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" href="css/estilos.css"> -->
	<link rel="stylesheet" href="css/temp.css">
	<script src="js/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#obtenerUID").load("uid.php");
			setInterval(function() {
				$("#obtenerUID").load("uid.php");
			}, 500);
		});
	</script>

	<title>Registro</title>
</head>

<body>

	<ul>
		<li><a href="listado.php">Listado</a></li>
		<li><a href="registro.php">Registro</a></li>
		<li><a href="verificacion.php">Verificación</a></li>
	</ul>

	<div>
		<div>
			<div>
				<h1>Registro</h1>
			</div>
			<form action="db_insertar.php" method="POST" enctype="multipart/form-data">
				<div>
					<input id="identificador" name="identificador" type="hidden" placeholder="">
				</div>
				<div>
					<label>Código</label>
					<div>
						<textarea name="id" id="obtenerUID" placeholder="Pase el collar por el lector para detectar el código" required></textarea>
					</div>
				</div>

				<div>
					<label>Nombre</label>
					<div>
						<input id="div_refresh" name="nombre" type="text" placeholder="" required>
					</div>
				</div>

				<label>Sexo</label>
				<div>
					<select name="sexo">
						<option value="Macho">Macho</option>
						<option value="Hembra">Hembra</option>
					</select>
				</div>
		</div>

		<div>
			<label for="raza">Raza</label>
			<div>
				<input name="raza" type="text" placeholder="" required>
			</div>
		</div>

		<div>
			<label for="edad">Edad (aprox)</label>
			<div>
				<input name="edad" type="number" placeholder="" required>
			</div>
		</div>

		<div>
			<label for="peso">Peso (kg)</label>
			<div>
				<input name="peso" type="number" placeholder="" required>
			</div>
		</div>

		<div>
			<label for="racion">Ración diaria (g)</label>
			<div>
				<input name="racion" type="number" placeholder="" required>
			</div>
		</div>

		<div>
			<label for="turnos">Turnos diarios</label>
			<div>
				<input name="turnos" type="number" placeholder="" required>
			</div>
		</div>

		<div>
			<label for="cooldown">Tiempo de espera (hs)</label>
			<div>
				<input name="cooldown" type="number" placeholder="" required>
			</div>
		</div>

		<div>
			<label for="veces">Veces que ya comió</label>
			<div>
				<input name="veces" type="number" placeholder="" value="<?php echo $datos['veces']; ?>" required>
			</div>
		</div>

		<div>
			<label for="ultimaSalida">Última comida</label>
			<div>
				<input name="ultimaSalida" type="date" placeholder="" value="<?php echo $datos['ultimaSalida']; ?>" required>
			</div>
		</div>

		<div>
			<label for="foto">Foto</label>
			<div>
				<input name="foto" type="file" accept="image/*" value="<?php echo $datos['foto']; ?>" required>
			</div>
		</div>

		<div>
			<button type="submit">Agregar</button>
		</div>
		</form>

	</div>
	</div>
</body>

</html>