<section class="content">
	<?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]);
  $sett = SettingData::getByAdmin($u->admin_id); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-coffee"></i> Lista de Gastos</h2>
	    <ol class="breadcrumb">
	      <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><i class="fa fa-money"></i> Finanzas</li>
	      <li class="active"><i class="fa fa-coffee"></i> Lista de Gastos</li>
	    </ol>
			<a href='#material_new' data-toggle='modal' class='btn btn-default'><i class='fa fa-coffee'></i> Nuevo Gasto</a>
			<br><br>
			<?php if($u->id==1){
				$spends = SpendData::getAll();
			}else if($u->id==$u->admin_id){
				$spends = SpendData::getAllByAdmin($u->admin_id);
			}else{
				$spends = SpendData::getAllByUser($u->id);
			}
			$total = 0;
			if(count($spends)>0){ ?>
      <div class="box box-primary">
				<div class="box-body no-padding">
			  	<div class="box-body">
				    <div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Concepto</th>
									<th style="text-align: center;">Monto&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center;">Fecha</th>
									<?php if($u->id==$u->admin_id): ?><th style="text-align: center;">Usuario</th><?php endif; ?>
									<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
									<th style="text-align: center; width: 150px;">Acción</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($spends as $spend){
									$user = $spend->getUser();
									$admin = $spend->getAdmin(); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td><?php echo $spend->name; ?></td>
									<td style="text-align: right;"><b><?php echo $sett->coin." ".number_format($spend->price,2,".",","); ?></b></td>
									<td style="text-align: right;"><?php echo $spend->created_at; ?></td>
									<?php if($u->id==$u->admin_id): ?><td><?php echo $user->name." ".$user->lastname; ?></td><?php endif; ?>
									<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
									<td style=" text-align: center;">
										<a href="index.php?view=spend_edit&id=<?php echo $spend->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
										<a href="index.php?action=spend_del&id=<?php echo $spend->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar</a></td>
									<?php $total+=$spend->price;	} ?>
								</tr>
							</table>
							<h3>Gasto Total : <?php echo $sett->coin." ".number_format($total,2,".",",")?></h3>
						</div>
					</div>
				</div>
			</div>
			<?php }else{
				echo "<div><br><p class='alert alert-danger'>No hay Gastos</p></div>";
			} ?>
		</div>
	</div>
	<?php endif;?>
</section>

<div class="modal fade" id="material_new"><!--Inicio de ventana modal 2-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" style="text-align: center;">Ingrese el Nuevo Gasto</h4>
        </div>
        <div class="modal-body">
            <table class="table">
              <tr><td>
                <form class="form-horizontal" method="post" id="spend_add" action="index.php?action=spend_add" role="form">
                  <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Concepto*</label>
                    <div class="col-md-9">
                      <textarea type="text" name="name" required class="form-control" id="name" placeholder="Concepto del gasto" required="yes"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Monto*</label>
                    <div class="col-md-9">
                      <input type="text" name="price" class="form-control" id="price" placeholder="Monto del gasto" required="">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" class="btn btn-primary">Registrar Gasto</button>
                    </div>
                  </div>
                </form>
              </td></tr>
            </table>
          </div>
      </div>
    </div>
</div><!--Fin de ventana modal 2-->