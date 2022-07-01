<!DOCTYPE html>
<html lang="es">
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
  <title>Listado</title>
</head>

<body>
  <?php
  include 'comp/menu.php';
  if (isset($_SESSION['exito']) && $_SESSION['exito'] != '') {
    echo $_SESSION['exito'];
    unset($_SESSION['exito']);
  }
  if (isset($_SESSION['error']) && $_SESSION['error'] != '') {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
  }
  ?>

  <a class="verificar btn btn-outline-dark btn-sm" href="verificacion.php"><i class="fa-solid fa-check"></i> Verificar</a>
  <a class="nuevo btn btn-dark btn-sm me-md-2" href="registro.php"><i style="color: white" class="fa-solid fa-plus"></i> Nuevo</a>
  <h1>CRUD</h1>
  <input type="text" name="buscar" id="buscar">
  <?php
  include "config.php";
  $stmt = $conex->prepare('SELECT * FROM perros ORDER BY identificador DESC');
  $stmt->execute();
  $result = $stmt->get_result();
  ?>
  <table id="datos-tabla">
    <thead>
      <tr>
        <th>#</th>
        <th>Foto</th>
        <th>Nombre</th>
        <th>Código</th>
        <th>Sexo</th>
        <th>Raza</th>
        <th>Edad</th>
        <th>Peso</th>
        <th>Ración diaria</th>
        <th>Turnos diarios</th>
        <th>Tiempo de espera</th>
        <th>Veces que ya comió</th>
        <th>Última comida</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include 'db.php';
      $pdo = Base::connect();
      $sql = 'SELECT * FROM perros ORDER BY identificador DESC';
      foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        echo '<td><b>' . $row['identificador'] . '</b></td>';
        echo '<td><img src="img/' . $row['foto'] . '" alt="" height="100px"></td>';
        echo '<td><b>' . $row['nombre'] . '</b></td>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['sexo'] . '</td>';
        echo '<td>' . $row['raza'] . '</td>';
        echo '<td>' . $row['edad'] . '</td>';
        echo '<td>' . $row['peso'] . 'kg</td>';
        echo '<td>' . $row['racion'] . 'g</td>';
        echo '<td>' . $row['turnos'] . '</td>';
        echo '<td>' . $row['cooldown'] . 'h</td>';
        echo '<td>' . $row['veces'] . '</td>';
        echo '<td>' . $row['ultimaSalida'] . '</td>';
        echo '<td><a href="editar.php?id=' . $row['id'] . '"><i style="font-size:16px;margin-right:20px;" class="fa-solid fa-pen">Editar</i></a>';
        echo ' ';
        echo '<a href="db_borrar.php?id=' . $row['id'] . '"><i style="font-size:16px;" class="fa-solid fa-trash-can">Borrar</i></a>';
        echo '</td>';
        echo '</tr>';
      }
      Base::disconnect();
      ?>
    </tbody>
  </table>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#buscar").keyup(function() {
        var consulta = $(this).val();
        $.ajax({
          url: 'buscar.php',
          method: 'POST',
          data: {
            query: consulta
          },
          success: function(respuesta) {
            $("#datos-tabla").html(respuesta);
          }
        });
      });
    });
  </script>
</body>

</html>