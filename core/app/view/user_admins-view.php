<section class="content">
	<?php $u=null;
	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-users"></i> Lista de Administradores</h2>
			<div class="clearfix"></div>
			<br>
			<?php if($u->id==1){ 
				$users = UserData::getAllAdmins();
			if(count($users)>0){ ?>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 50px;">Foto</th>
									<th style="text-align: center;">Nombre&nbsp;Completo</th>
									<th style="text-align: center;">Usuario</th>
									<th style="text-align: center;">Correo&nbsp;Electrónico</th>
									<th style="text-align: center;">Us</th>
									<th style="text-align: center;">Vent</th>
									<th style="text-align: center;">Cli</th>
									<th style="text-align: center;">Art</th>
									<th style="text-align: center;">Activo</th>
									<th style="text-align: center;">Accesos</th>
									<th style="text-align: center;">Us&nbsp;Máx</th>
									<th style="text-align: center;">Serv&nbsp;Máx</th>
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
									<td><a href="index.php?view=user_admin_resources&id=<?php echo $user->id; ?>"><?php echo $user->name." ".$user->lastname; ?></a></td>
									<td><?php echo $user->username; ?></td>
									<td><?php echo $user->email; ?></td>
									<td style="text-align: right;"><?php $num = UserData::getAllByAdmin($user->id); echo count($num); ?>
									<td style="text-align: right;"><?php $ser = SellData::getSellsByAdmin($user->id); echo count($ser); ?>
									<td style="text-align: right;"><?php $cli = PersonData::getClientsByAdmin($user->id); echo count($cli); ?>
									<td style="text-align: right;"><?php $pro = ProductData::getAllByAdmin($user->id); echo count($pro); ?>
									<td style="text-align: center;"><?php if($user->status):?>
											<i class="glyphicon glyphicon-ok"></i>
										<?php endif; ?></td>
									<td style="text-align: right;"><?php echo $user->counter; ?></td>
									<td style="text-align: right;"><?php echo $user->limit_users; ?></td>
									<td style="text-align: right;"><?php echo $user->limit_services; ?></td>
									<td style="text-align: right;"><?php echo $user->created_at; ?></td>
									<td style="text-align: center;">
										<a href="index.php?view=user_edit&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
										<a href="index.php?action=user_admin_del&id=<?php echo $user->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
									</td>
								</tr>
							<?php }
					 	echo "</table></div></div></div></div>"; 
					}else{
				}
			} ?>
		</div>
	</div>
	<?php endif; ?>
</section>