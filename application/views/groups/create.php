

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gestión
        <b><small>Roles</small></b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Roles</li>
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
              <h3 class="box-title">Agregar rol</h3>
            </div>
            <form role="form" action="<?php base_url('groups/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="group_name">Nombre del rol</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Ingresa nombre del rol" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="permission">Permisos</label>

                  <table class="table table-responsive table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Crear</th>
                        <th>Actualizar</th>
                        <th>Ver</th>
                        <th>Borrar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Empleados</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createUser"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUser"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser"></td>
                      </tr>
                      <tr>
                        <td>Roles</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createGroup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup"></td>
                      </tr>
                      <tr>
                        <td>Sucursales</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createStore"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateStore"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewStore"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteStore"></td>
                      </tr>
                      <tr>
                        <td>Mesas</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createTable"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateTable"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewTable"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteTable"></td>
                      </tr>
                      <tr>
                        <td>Categorías</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createCategory"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCategory"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewCategory"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteCategory"></td>
                      </tr>
                      <tr>
                        <td>Productos</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createProduct"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateProduct"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewProduct"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteProduct"></td>
                      </tr>
                      <tr>
                        <td>Pedidos</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createOrder"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateOrder"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrder"></td>
                      </tr>
                      <tr>
                        <td>Reportes</td>
                        <td> - </td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewReport"></td>
                        <td> - </td>
                      </tr>
                      <tr>
                        <td>Información</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCompany"></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                      <tr>
                        <td>Perfil</td>
                        <td> - </td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewProfile"></td>
                        <td> - </td>
                      </tr>
                      <tr>
                        <td>Configuración</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSetting"></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Guardar cambios</button>
                <a href="<?php echo base_url('groups/') ?>" class="btn btn-danger">Regresar</a>
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
      $('#groupMainNav').addClass('active');
      $('#createGroupSubMenu').addClass('active');
    });
  </script>

