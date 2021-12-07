<section class="content">
	<?php $u=null;
 	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-users"></i> Lista de Usuarios</h2>
	    <ol class="breadcrumb">
	      <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><i class="fa fa-cog"></i> Administración</li>
	      <li class="active"><i class="fa fa-users"></i> Lista de Usuarios</li>
	    </ol>
			<p>Lista de usuarios que tienen acceso al sistema, puedes agregar Ejecutivos de Venta o Cajeros y asignarle la sucursal que le corresponde.</p>
			<?php $users = UserData::getAllByAdmin($u->admin_id);
			$agent = UserData::getById($u->admin_id)->limit_users;
			if(count($users) < $agent || $agent == 0){ ?>
			<a href='#user_new' data-toggle='modal' class='btn btn-primary'><i class='fa fa-user'></i> Nuevo Usuario</a>
			<br><br>
			<?php } ?>
			<?php $users = UserData::getAllByAdmin($u->admin_id);
			if(count($users)>0){ ?>
			<div class="box box-primary">
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
									<th style="text-align: center;">Sucursal</th>
									<th style="text-align: center;">Estado</th>
									<th style="text-align: center;">Tipo</th>
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
									<td><?php if($user->stock_id!=null){ echo $user->getStock()->name; } ?></td>
									<td style="text-align: center;"><?php if($user->status==1):?>
											<i class="glyphicon glyphicon-ok"></i>
										<?php endif; ?></td>
									<td><?php switch ($user->kind) {
										case '1': echo "Administrador"; break;
										case '2': echo "Ejecutivo"; break;
										case '3': echo "Cajero"; break;
										default:
											# code...
											break;
										} ?></td>
									<td style="text-align: right;"><?php echo $user->created_at; ?></td>
									<td style="text-align: center;">
										<a href="index.php?view=user_edit&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
										<?php if($user->kind==2): ?><a href="index.php?action=user_del&id=<?php echo $user->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>
										<?php endif; ?>
									</td>
								</tr>
								<?php }	 echo "</table></div>";
								}else{ } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>

<div class="modal fade" id="user_new"><!--Inicio de ventana modal 2-->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align: center;">Nuevo Usuario</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          	<tr><td>
		      <form class="form-horizontal" enctype="multipart/form-data"  method="post" id="user_add" action="index.php?action=user_add" role="form">
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Foto JPG (400x400px)</label>
		          <div class="col-md-9">
		            <input type="file" name="image" id="image" placeholder="">
		          </div>
		        </div>
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
		          <div class="col-md-9">
		            <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
		          </div>
		        </div>
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Apellidos*</label>
		          <div class="col-md-9">
		            <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellidos">
		          </div>
		        </div>
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Correo Electrónico*</label>
		          <div class="col-md-9">
		            <input type="text" name="email" class="form-control" id="email" placeholder="Correo Electrónico">
		          </div>
		        </div>
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
		          <div class="col-md-9">
		            <input type="password" name="password" class="form-control" required id="inputEmail1" placeholder="Contrase&ntilde;a">
		          </div>
		        </div>
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Tipo*</label>
		          <div class="col-md-9">
			          <select name="kind" class="form-control" required>
			            <option value="">-- SELECCIONAR --</option>
			            <option value="2">Ejecutivo</option>
			            <option value="3">Cajero</option>
		            </select>
		          </div>
		        </div>
		        <div class="form-group">
		          <label for="inputEmail1" class="col-lg-2 control-label">Sucursal*</label>
		          <div class="col-md-9">
			          <select name="stock_id" class="form-control" required>
			            <option value="">-- SELECCIONAR --</option>
			            <?php foreach(StockData::getAllByAdmin($u->admin_id) as $stock):?>
			            <option value="<?php echo $stock->id;?>"><?php echo $stock->name;?></option>
			            <?php endforeach;?>
		            </select>
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-lg-offset-2 col-lg-9">
		            <p class="alert alert-info">* Campos obligatorios</p>
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-lg-offset-2 col-lg-12">
		            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
		          </div>
		        </div>
		      </form>
          	</td></tr>
        </table>
      </div>
    </div>
  </div>
</div><!--Fin de ventana modal 2-->