<section class="content">
	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-building"></i> Lista de Sucursales</h2>
	        <ol class="breadcrumb">
	          <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	          <li><i class="fa fa-cube"></i> Stock</li>
	          <li class="active"><i class="fa fa-building"></i> Sucursales</li>
	        </ol>
			<a href='#stock_new' data-toggle='modal' class='btn btn-primary'><i class='fa fa-building'></i> Nueva Sucursal</a>
			<br><br>
			<?php if($u->id==1){
				$stocks = StockData::getAll();
			}else{
				$stocks = StockData::getAllByAdmin($u->admin_id);
			}
			if(count($stocks)>0){ // si hay usuarios ?>
			<div class="box box-primary">
				<div class="box-body no-padding">
					<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Dirección</th>
									<th style="text-align: center;">Telefono</th>
									<th style="text-align: center;">Email</th>
									<th style="text-align: center;">Principal</th>
									<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
									<th style="text-align: center; width:150px;">Acción</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($stocks as $stock){
									$admin = $stock->getAdmin(); ?>
									<tr>
										<td style="text-align: center;"><?php echo $number; ?></td><?php $number++;?>
										<td><a href="index.php?view=inventary&stock=<?php echo $stock->id;?>" ><?php echo $stock->name; ?></a></td>
										<td><?php echo $stock->address; ?></td>
										<td style="text-align: center;"><?php echo $stock->phone; ?></td>
										<td><?php echo $stock->email; ?></td>
										<td style="text-align: center;">
											<center>
												<?php if($stock->is_principal):?>
													<i class="fa fa-check"></i>
													<?php else:?>
														<a href="index.php?action=makestockprincipal&id=<?php echo $stock->id;?>" class="btn btn-default btn-xs">Hacer Principal</a>
													<?php endif;?>
												</center>
											</td>
										<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
										<td style="text-align: center;">
											<a href="index.php?view=stock_edit&id=<?php echo $stock->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
											<?php if($stock->is_principal!=1): ?>
											<a href="index.php?action=stock_del&id=<?php echo $stock->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>
											<?php endif; ?>
											</td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			<?php }else{
				echo "<p class='alert alert-danger'>No hay Sucursales</p>";
			} ?>
		</div>
	</div>
	<?php endif; ?>
</section>

<div class="modal fade" id="stock_new"><!--Inicio de ventana modal 2-->
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="text-align: center;">Ingrese la Nueva Sucursal</h4>
			</div>
			<div class="modal-body">
				<table class="table">
					<tr><td>
						<form class="form-horizontal" method="post" enctype="multipart/form-data" id="stock_add" action="index.php?action=stock_add" role="form">
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
								<div class="col-md-9">
									<input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Direccion*</label>
								<div class="col-md-9">
									<input type="text" name="address"  class="form-control" id="name" placeholder="Direccion">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
								<div class="col-md-9">
									<input type="text" name="phone"  class="form-control" id="name" placeholder="Telefono">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
								<div class="col-md-9">
									<input type="text" name="email"  class="form-control" id="name" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary">Agregar Sucursal</button>
								</div>
							</div>
						</form>
					</td></tr>
				</table>
			</div>
		</div>
	</div>
</div><!--Fin de ventana modal 2-->