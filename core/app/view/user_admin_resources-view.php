<section class="content">
	<?php $u=null;
    if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
    $u = UserData::getById($_SESSION["user_id"]);
    $admin = UserData::getById($_GET["id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2>Recursos del Administrador <?php echo $admin->name." ".$admin->lastname; ?></h2>
			<!--Lista de usuarios-->
			<h3><i class="fa fa-cog"></i> Configuración de la Empresa</h3>
			<?php if($u->kind==1):?><a href="index.php?view=user_admins" class="btn btn-default"><i class='fa fa-reply'></i> Regresar</a><?php endif; ?>		
			<br><br>
			<?php $setts = SettingData::getAllByAdmin($admin->id);
			if(count($setts)>0){ ?>
			<div class="box box-primary">
				<div class="box-body no-padding">
			  		<div class="box-body">
			  			<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
				                  <th style="text-align: center; width: 30px;">N°</th>
				                  <th style="text-align: center; width: 100px;">Logo</th>
				                  <th style="text-align: center;">Nombre</th>
				                  <th style="text-align: center;">RUC</th>
				                  <th style="text-align: center;">Dirección</th>
				                  <th style="text-align: center;">Teléfono</th>
				                  <th style="text-align: center;">Impuesto</th>
				                  <th style="text-align: center;">Moneda</th>
				                  <th style="text-align: center;">Nota</th>
				                  <th style="text-align: center; width:150px;">Acción</th>
				                </thead>
				                <?php for($number=0; $number<1; $number++); //variable incremental
				                foreach($setts as $sett): ?>
				                <tr>
				                  <td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
				                  <td style="text-align: center;">
				              		<?php if($sett->image!=""):?>
				                	<img src="storage/settings/<?php echo $sett->image;?>" style="width:150px; height: 50px; ">
				              		<?php endif;?></td>
				                  <td><?php echo $sett->company; ?></td>
				                  <td style="text-align: right;"><?php echo $sett->ruc; ?></td>
				                  <td><?php echo $sett->address; ?></td>
				                  <td style="text-align: right;"><?php echo $sett->phone; ?></td>
				                  <td style="text-align: right;"><?php echo $sett->tax." %"; ?></td>
				                  <td style="text-align: right;"><?php echo $sett->coin; ?></td>
				                  <td><?php echo $sett->note; ?></td>
				                  <td style="text-align: center;">
				                  	<a href="index.php?view=setting_edit&id=<?php echo $sett->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
									<a href="index.php?action=setting_admin_del&id=<?php echo $sett->id;?>&admin=<?php echo $_GET['id']; ?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>
				                  </td>
				                </tr>
			                	<?php endforeach; ?>
			                </table>
			            </div>
			        </div>
			    </div>
			</div>
			<?php }else{ 
				echo "<p class='alert alert-danger'>No tienes creada tu empresa</p>"; ?>
            <a href="index.php?view=setting_new&id=<?php echo $admin->id; ?>" class="btn btn-default"><i class='fa fa-th-list'></i> Crear Empresa</a>
            <?php }; ?>

			<!--Lista de usuarios-->
			<h3><i class="fa fa-users"></i> Lista de Usuarios</h3>
			<a href="index.php?view=user_employe_new&user_id=<?php echo $_GET['id']; ?>&kind=2" class="btn btn-default"><i class='glyphicon glyphicon-user'></i> Nuevo Mesero</a>
			<a href="index.php?view=user_employe_new&user_id=<?php echo $_GET['id']; ?>&kind=3" class="btn btn-default"><i class='glyphicon glyphicon-user'></i> Nuevo Cajero</a>	
			<br><br>
			<?php $users = UserData::getAllByAdmin($_GET['id']);
			if(count($users)>0){ ?>
			<div class="box box-primary">
				<div class="box-body no-padding">
			  		<div class="box-body">
			  			<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 50px;">Foto</th>
									<th style="text-align: center;">Nombre completo</th>
									<th style="text-align: center;">Usuario</th>
									<th style="text-align: center;">Correo&nbsp;Electrónico</th>
									<th style="text-align: center;">Estado</th>
									<th style="text-align: center;">Tipo</th>
									<th style="text-align: center;">Accesos</th>
									<th style="text-align: center;">Registro</th>
									<th style="text-align: center; width:150px;">Acción</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($users as $user){ ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td><?php $number++;?>
									<td style="text-align: center;">
					                    <?php if($user->image!=""){ ?>
					                      <img src="storage/profiles/<?php echo $user->image;?>" style="width:50px; height: 50px; ">
					                    <?php }else{ ?>
					                    	<img src="storage/profiles/default.jpg" style="width:50px; height: 50px; ">
					                    <?php } ?></td>
									<td><?php echo $user->name." ".$user->lastname; ?></td>
									<td><?php echo $user->username; ?></td>
									<td><?php echo $user->email; ?></td>
									<td style="text-align: center;"><?php if($user->status==1):?>
											<i class="glyphicon glyphicon-ok"></i>
										<?php endif; ?></td>
									<td><?php switch ($user->kind) {
										case '1': echo "Administrador"; break;
										case '2': echo "Mesero"; break;
										case '3': echo "Cajero"; break;
										default:
											# code...
											break;
										} ?></td>
									<td style="text-align: right;"><?php echo $user->counter; ?></td>
									<td style="text-align: right;"><?php echo $user->created_at; ?></td>
									<td style="text-align: center;">
										<a href="index.php?view=user_edit&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>										
										<?php if(count($users)>1&&$user->kind!=1): ?>
										<a href="index.php?action=user_del&id=<?php echo $user->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php }	 echo "</table></div>";
							}else{ } ?>
					</div>
				</div>
			</div>

			<!--Lista de usuarios-->
			<h3><i class="fa fa-building"></i> Lista de Sucursales</h3>
			<a href="index.php?view=stock_new&user_id=<?php echo $_GET['id']; ?>&kind=2" class="btn btn-default"><i class='fa fa-building'></i> Nueva Sucursal</a>	
			<br><br>
			<?php $stocks = StockData::getAllByAdmin($_GET['id']);
			if(count($stocks)>0){ ?>
			<div class="box box-primary">
				<div class="box-body no-padding">
			  		<div class="box-body">
			  			<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Direccion</th>
									<th style="text-align: center;">Telefono</th>
									<th style="text-align: center;">Email</th>
									<th style="text-align: center; width:120px;">Principal</th>
									<?php if ($u->id==1): ?><th style="text-align: center;">Usuario</th><?php endif; ?>
									<th style="text-align: center; width:150px;">Acción</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($stocks as $stock){
									$admin = $stock->getAdmin(); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td><?php $number++;?>
									<td><?php echo $stock->name; ?></td>
									<td><?php echo $stock->address; ?></td>
									<td style="text-align: center;"><?php echo $stock->phone; ?></td>
									<td><?php echo $stock->email; ?></td>
									<td style="text-align: center;">
									<center>
									<?php if($stock->is_principal):?>
										<i class="fa fa-check"></i>
									<?php else:?>
										<a href="index.php?action=makestockprincipal&id=<?php echo $stock->id;?>" class="btn btn-default btn-xs" onclick="return confirm('¿Está seguro de hacer principal?')">Hacer Principal</a>
									<?php endif;?>
									</center>
									</td>
									<?php if ($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
									<td style="text-align: center;">
										<a href="index.php?view=stock_edit&id=<?php echo $stock->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
										<?php if($stock->is_principal!=1): ?><a href="index.php?action=stock_del&id=<?php echo $stock->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a><?php endif; ?>
									</td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
			    </div><!-- /.box-body -->
			</div><!-- /.box -->
			<?php }else{
			echo "<p class='alert alert-danger'>No hay sucursales</p>";
			} ?>
	</div>
	<?php endif;?>
</section>