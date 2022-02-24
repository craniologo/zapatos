<section class="content">
  	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]);
  	$sett = SettingData::getByAdmin($u->admin_id); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class='fa fa-refresh'></i> Lista de Reabastecimientos</h2>
	        <ol class="breadcrumb">
	          <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	          <li><i class="fa fa-cube"></i> Stock</li>
	          <li class="active"><i class="fa fa-refresh"></i> Reabastecimientos</li>
	        </ol>
			<a href="index.php?view=re" class="btn btn-default"><i class='fa fa-refresh'></i> Reabastecer</a>
			<br><br>
			<?php if($u->id==1){
				$products = SellData::getRes();
			}else{
				$products = SellData::getResByAdmin($u->admin_id);
			}
			if(count($products)>0){ ?>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
	  					<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover	">
								<thead>
									<th style="text-align: center; width:30px;">N°</th>
									<th style="text-align: center; width:30px;">Boleta</th>
									<th style="text-align: center;">Cant</th>
									<th style="text-align: center;">Proveedor</th>
									<th style="text-align: center;">Total&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center;">Fecha</th>
									<?php if($u->id==$u->admin_id): ?><th style="text-align: center;">Usuario</th><?php endif; ?>
									<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
									<th style="text-align: center; width:80px;">Acción</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($products as $sell): 
									$user = $sell->getUser();
									$admin = $sell->getAdmin(); ?>
								<tr>
									<td style="text-align: center; width:30px;"><?php echo $number; ?></td><?php $number++;?>
									<td style="text-align: right;"><a href="index.php?view=re_one&id=<?php echo $sell->id; ?>" ><?php echo "# ".$sell->ref_id; ?></a></td>
									<td style="text-align: right;"><?php $operations = OperationData::getAllProductsBySellId($sell->id);
										echo count($operations); ?></td>
									<td><?php $person = PersonData::getById($sell->person_id); echo $person->name." ".$person->lastname; ?></td>
									<td style="text-align: right;"><?php $total=0;
										foreach($operations as $operation){
										$product  = $operation->getProduct();
										$total += $operation->q*$product->price_in; }; 
										echo $sett->coin." ".number_format($total,2,".",",")."</b>"; ?></td>
									<td style="text-align: right;"><?php echo $sell->created_at; ?></td>
									<?php if($u->id==$u->admin_id): ?><td><?php echo $user->name." ".$user->lastname; ?></td><?php endif; ?>
									<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
									<td style="text-align: center;">
										<a href="index.php?action=re_del&id=<?php echo $sell->id; ?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</a></td>
								</tr>
							<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php }else{ ?>
			<div class="jumbotron">
				<h3>No hay datos</h3>
				<p>No se ha realizado ningún reabastecimiento.</p>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php endif; ?>
</section>