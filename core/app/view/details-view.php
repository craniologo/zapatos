<section class="content"> <!-- Main content -->
	<?php $u=null;
 	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
		<h2><i class="fa fa-star-half-o"></i> Marcas y Colores</h2>
		<p>Aquí están registrados todos los detalles relacionados a los productos.</p>
	    <ol class="breadcrumb">
	      <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><i class="fa fa-list-ul"></i> Catálogos</li>
	      <li class="active"><i class="fa fa-star-half-o"></i> Marcas y Colores</li>
	    </ol>
			<div class="col-md-6">
				<a href="#color_new" class="btn btn-default" data-toggle="modal"><i class='fa fa-tint'></i> Nuevo Color</a><br><br>
				<?php if($u->id==1){
					$colors = ColorData::getAll();
				}else{
					$colors = ColorData::getAllByAdmin($u->admin_id);
				}
				if(count($colors)>0){  // si hay usuarios ?>
				<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
		  				<div class="box-body table-responsive">
								<table class="table table-bordered datatable table-hover">
									<thead>
										<th style="text-align: center; width: 30px;">N°</th>
										<th style="text-align: center;">Color</th>
										<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
										<th style="text-align: center;  width:150px;">Acción</th>
									</thead>
									<?php for ($number=0; $number<1; $number++);?>
									<?php foreach($colors as $color){
										$admin = $color->getAdmin(); ?>
									<tr>
										<td style="text-align: center; width:30px;"><?php echo $number; ?></td><?php $number++;?>
										<td><?php echo $color->name; ?></td>
										<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
										<td style="text-align: center;">
											<a href="index.php?view=color_edit&id=<?php echo $color->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
											<a href="index.php?action=color_del&id=<?php echo $color->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar</a>
										</td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
		  		</div><!-- /.box-body -->
				</div><!-- /.box -->					
				<?php }else{
					echo "<p class='alert alert-danger'>Aún no hay colores agregados, agrega uno ya!.</p>";
				} ?>
				<div class="modal fade" id="color_new"><!--Inicio de ventana modal 2-->
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				          <h4 style="text-align: center;" class="modal-title">Ingrese el Nuevo Color</h4>
				        </div>
				        <div class="modal-body">
				          	<form class="form-horizontal" method="post" id="" action="index.php?action=color_add" role="form">
				              <div class="form-group">
				                <label for="inputEmail1" class="col-lg-2 control-label">Color*</label>
				                <div class="col-md-6">
				                  <input type="text" name="name" class="form-control" id="name" placeholder="Ingrese el color" required="">
				                </div>
				              </div>
				              <div class="form-group">
				                <div class="col-lg-offset-2 col-lg-10">
				                  <button type="submit" class="btn btn-primary">Agregar Color</button>
				                </div>
				              </div>
				            </form>
				        </div>
				      </div>
				    </div>
				</div><!--Fin de ventana modal 2-->
			</div>
			<div class="col-md-6">
				<a href="#brand_new" class="btn btn-default" data-toggle="modal"><i class='fa fa-tag'></i> Nueva Marca</a><br><br>
					<?php if($u->id==1){
						$brands = BrandData::getAll();
					}else{
						$brands = BrandData::getAllByAdmin($u->admin_id);
					}
					if(count($brands)>0){  // si hay usuarios
					?>
					<div class="box">
		  			<div class="box-body no-padding">
		  				<div class="box-body">
			  				<div class="box-body table-responsive">
									<table class="table table-bordered datatable table-hover">
										<thead>
											<th style="text-align: center; width: 30px;">N°</th>
											<th style="text-align: center;">Marca</th>
											<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
											<th style="text-align: center;  width:150px;">Acción</th>
										</thead>
										<?php for ($number=0; $number<1; $number++);?>
										<?php foreach($brands as $brand){
											$admin = $brand->getAdmin(); ?>
										<tr>
											<td style="text-align: center; width:30px;"><?php echo $number; ?></td><?php $number++;?>
											<td><?php echo $brand->name; ?></td>
											<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
											<td style="text-align: center;">
												<a href="index.php?view=brand_edit&id=<?php echo $brand->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
												<a href="index.php?action=brand_del&id=<?php echo $brand->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar</a>
											</td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
			  		</div><!-- /.box-body -->
					</div><!-- /.box -->
					<?php }else{
						echo "<p class='alert alert-danger'>Aún no hay marcas agregadas, agrega una ya!.</p>";
					} ?>
					<div class="modal fade" id="brand_new"><!--Inicio de ventana modal 2-->
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				          <h4 style="text-align: center;" class="modal-title">Ingrese el Nueva Marca</h4>
				        </div>
				        <div class="modal-body">
			          	<form class="form-horizontal" method="post" id="" action="index.php?action=brand_add" role="form">
			              <div class="form-group">
			                <label for="inputEmail1" class="col-lg-2 control-label">Marca*</label>
			                <div class="col-md-6">
			                  <input type="text" name="name" class="form-control" id="name" placeholder="Ingrese la marca" required="">
			                </div>
			              </div>
			              <div class="form-group">
			                <div class="col-lg-offset-2 col-lg-10">
			                  <button type="submit" class="btn btn-primary">Agregar Marca</button>
			                </div>
			              </div>
			            </form>
				        </div>
				      </div>
				    </div>
					</div><!--Fin de ventana modal 2-->
				</div>
		</div>
	</div>
	<?php endif; ?>
</section><!-- /.content -->