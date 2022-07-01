<!DOCTYPE html>
<html lang="es">
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>Listado</title>
  <?php include 'comp/head.php';
  include 'comp/estilos.php' ?>
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

  <?php
  include "config.php";
  $stmt = $conex->prepare('SELECT * FROM perros ORDER BY identificador DESC');
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
      <h1 class="h2">Listado</h1>
      <div class="col-4">
        <input class="form-control me-2" name="buscar" id="buscar" type="text" placeholder="Buscar" aria-label="Buscar">
      </div>
      <div class="btn-toolbar mb-2 mb-md-0">
        <a style="margin-right:10px;" class="verificar btn btn-outline-dark btn-sm" href="verificacion.php"><span data-feather="check"></span> Verificar</a>
        <a class="nuevo btn btn-dark btn-sm me-md-2" href="registro.php"><span data-feather="plus"></span> Nuevo</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm table-hover tabla" id="datos-tabla" data-sorting="true">
        <thead>
          <tr>
            <th data-type="number">#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Sexo</th>
            <th>Raza</th>
            <th data-type="number">Edad</th>
            <th data-type="number">Peso</th>
            <th data-type="number">Ración diaria</th>
            <th data-type="number">Turnos diarios</th>
            <th data-type="number">Tiempo de espera</th>
            <th data-type="number">Veces que ya comió</th>
            <th data-type="date">Última comida</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';
          $pdo = Base::connect();
          $sql = 'SELECT * FROM perros ORDER BY identificador DESC';
          foreach ($pdo->query($sql) as $row) {
            echo '<tr style="vertical-align: middle;">';
            echo '<td><b>' . $row['identificador'] . '</b></td>';
            echo '<td><img src="img/' . $row['foto'] . '" alt="" style="object-fit: cover;height:100px;width:100px" class="rounded-circle"></td>';
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
            echo '<td><a href="editar.php?id=' . $row['id'] . '"><span style="margin-right:20px;" data-feather="edit-2"></span></a>';
            echo ' ';
            echo '<a href="db_borrar.php?id=' . $row['id'] . '"><span data-feather="trash-2"></span></a>';
            echo '</td>';
            echo '</tr>';
          }
          Base::disconnect();
          ?>
        </tbody>
    </div>

  </main>


  <?php include 'comp/scripts.php'; ?>
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