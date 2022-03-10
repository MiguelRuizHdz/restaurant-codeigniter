

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gestión
        <small>Empleados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Empleados</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Agregar empleado</h3>
            </div>
            <form role="form" action="<?php base_url('users/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="groups">Rol</label>
                  <select class="form-control" id="groups" name="groups">
                    <option value="">Seleccionar rol</option>
                    <?php foreach ($group_data as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="groups">Restaurante</label>
                  <select class="form-control" id="store" name="store">
                    <option value="">Seleccionar restaurante</option>
                    <?php foreach ($store_data as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="username">Nombre de usuario</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="email">Correo</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Correo" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="cpassword">Confirmar contraseña</label>
                  <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirmar contraseña" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="fname">Nombre</label>
                  <input type="text" class="form-control" id="fname" name="fname" placeholder="Nombre" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="lname">Apellido</label>
                  <input type="text" class="form-control" id="lname" name="lname" placeholder="Apellido" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="phone">Teléfono</label>
                  <input type="number" class="form-control" id="phone" name="phone" placeholder="Teléfono" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="gender">Género</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="gender" id="male" value="1">
                      Masculino
                    </label>
                    <label>
                      <input type="radio" name="gender" id="female" value="2">
                      Femenino
                    </label>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Guardar cambios</button>
                <a href="<?php echo base_url('users/') ?>" class="btn btn-danger">Regresar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#userMainNav").addClass('active');
    $("#createUserSubNav").addClass('active');
    
  });
</script>
