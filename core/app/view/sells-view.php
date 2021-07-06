<section class="content">
	<?php $u=null;
 	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class='fa fa-usd'></i> Lista de Ventas</h2>
		    <?php if ($u->id==1){
		    		$sells = SellData::getSells();
		      	}else if($u->id==$u->admin_id){
		      		$sells = SellData::getSellsByAdmin($u->admin_id);
		      	}else{
		         	$sells = SellData::getSellsByUser($u->id);
		      	} ?>
			<?php if(count($sells)>0){ ?>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover	">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 30px;">Boleta</th>
									<th style="text-align: center;">Cantidad</th>
									<th style="text-align: center;">Cliente</th>
									<th style="text-align: center;">Total&nbsp;S/</th>
									<th style="text-align: center;">Fecha</th>
									<th style="text-align: center;">Sucursal</th>
									<?php if($u->id==$u->admin_id): ?><th style="text-align: center;">Usuario</th><?php endif; ?>
									<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
									<th style="text-align: center; width: 80px;">Acción</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($sells as $sell): 
									$user = $sell->getUser();
									$admin = $sell->getAdmin(); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var decremental-->
									<td style="text-align: right;"><a href="index.php?view=sell_one&id=<?php echo $sell->id; ?>" ><?php echo "# ".$sell->ref_id; ?></a></td>
									<td style="text-align: center;"><?php $operations = OperationData::getAllProductsBySellId($sell->id);
										echo count($operations)." Par(es)"; ?></td>
									<td><?php if($sell->person_id!=""):
										$client = $sell->getPerson(); ?>
										<?php endif; ?>
										<?php if($sell->user_id!=""):
										$user = $sell->getUser(); ?>
										<?php endif; ?><?php echo $client->name." ".$client->lastname;?></td>
									<td style="text-align: right;"><?php $total= $sell->total;
										echo number_format($total,2,".",","); ?></td>
									<td style="text-align: center;"><?php echo $sell->created_at; ?></td>
									<td><?php $suc = StockData::getById($sell->stock_id); echo $suc->name; ?></td>
										<?php if($u->id==$u->admin_id): ?><td><?php echo $user->name." ".$user->lastname; ?></td><?php endif; ?>
										<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
									<td style="text-align: center;">
										<a href="index.php?action=sell_del&id=<?php echo $sell->id; ?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Eliminar</a></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			<div class="clearfix"></div>
			<?php }else{ ?>
			<div class="jumbotron">
			<h3>No hay ventas</h3>
			<p>No se ha realizado ninguna venta.</p>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php endif;?>
</section>