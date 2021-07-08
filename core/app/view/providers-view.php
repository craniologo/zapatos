<section class="content">
	<?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-truck"></i> Lista de proveedores</h2>
	    <ol class="breadcrumb">
	      <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><i class="fa fa-list-ul"></i> Catálogos</li>
	      <li class="active"><i class="fa fa-truck"></i> Lista de Proveedores</li>
	    </ol>
			<a href='#provider_new' data-toggle='modal' class='btn btn-primary'><i class='fa fa-truck'></i> Nuevo Proveedor</a>
			<br><br>
			<?php if($u->id==1){
				$providers = PersonData::getProviders();
			}else{
				$providers = Persondata::getProvidersByAdmin($u->admin_id);
			}
			if(count($providers)>0){ ?> <!-- si hay usuarios -->
			<div class="box">
				<div class="box-header">
					<div class="box-body no-padding">
						<div class="box-body">
							<div class="box-body table-responsive">
								<table class="table table-bordered datatable table-hover">
									<thead>
										<th style="text-align: center; width: 30px;">N°</th>
										<th style="text-align: center;">Nombre&nbsp;Completo</th>
										<th style="text-align: center;">Correo&nbsp;Electrónico</th>
										<th style="text-align: center;">Teléfono</th>
										<?php if($u->id==$u->admin_id): ?><th style="text-align: center;">Usuario</th><?php endif; ?>
										<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
										<th style="text-align: center; width:150px;">Acción</th>
									</thead>
									<?php for($number=0; $number<1; $number++); //variable incremental
									foreach($providers as $provider){
										$user = $provider->getUser();
										$admin = $provider->getAdmin(); ?>
									<tr>
										<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
										<td><?php echo $provider->name." ".$provider->lastname; ?></td>
										<td><?php echo $provider->email; ?></td>
										<td style="text-align: right;"><?php echo $provider->phone; ?></td>
										<?php if($u->id==$u->admin_id): ?><td><?php echo $user->name." ".$user->lastname; ?></td><?php endif; ?>
										<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
										<td style="text-align: center;">
											<a href="index.php?view=provider_edit&id=<?php echo $provider->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>											
											<?php if($u->id==$provider->user_id): ?>
											<a href="index.php?action=provider_del&id=<?php echo $provider->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar</a>
											<?php endif; ?>
										</td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }else{
				echo "<p class='alert alert-danger'>No hay proveedores</p>";
			} ?>
		</div>
	</div>
	<?php endif; ?>
</section>

<div class="modal fade" id="provider_new"><!--Inicio de ventana modal 2-->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align: center;">Ingrese el Nuevo Proveedor</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr><td>
            <form class="form-horizontal" method="post" id="provider_add" action="index.php?action=provider_add" role="form">
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Nombres*</label>
                <div class="col-md-9">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nombres del proveedor" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Apellidos*</label>
                <div class="col-md-9">
                  <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellidos del proveedor" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">RUC/DNI*</label>
                <div class="col-md-9">
                  <input type="text" name="ruc" class="form-control" id="ruc" placeholder="RUC o DNI del proveedor" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Dirección*</label>
                <div class="col-md-9">
                  <input type="text" name="address" class="form-control" id="address" placeholder="Dirección del proveedor" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Correo Electrónico*</label>
                <div class="col-md-9">
                  <input type="text" name="email" class="form-control" id="email" placeholder="Correo electrónico del proveedor" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Teléfono*</label>
                <div class="col-md-9">
                  <input type="text" name="phone" class="form-control" id="phone" placeholder="Número de teléfono" >
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-primary">Registrar Proveedor</button>
                </div>
              </div>
            </form>
          </td></tr>
        </table>
      </div>
    </div>
  </div>
</div><!--Fin de ventana modal 2-->