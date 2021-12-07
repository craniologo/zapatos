<section class="content">
	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]);
  	$sett = SettingData::getByAdmin($u->admin_id); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class='fa fa-clock-o'></i> Historial de Cortes de Caja</h2>
		    <ol class="breadcrumb">
		      <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
		      <li><i class="fa fa-money"></i> Finanzas</li>
		      <li class="active"><i class="fa fa-clock-o"></i> Historial de Cierres de caja</li>
		    </ol>
			<div class="clearfix"></div>
			<?php if($u->id==1){
				$boxes = BoxData::getAll();
			}else{
				$boxes = BoxData::getAllByAdmin($u->admin_id);
			}
			$products = SellData::getSellsUnBoxed();
			if(count($boxes)>0){
			$total_total = 0; ?>
			<br>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover	">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 30px;">Detalle</th>
									<th style="text-align: center;">Total&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center;">Fecha</th>
									<?php if($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($boxes as $box):
								$sells = SellData::getByBoxId($box->id);
									$admin = $box->getAdmin(); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td style="text-align: center;"><a href="./index.php?view=b&id=<?php echo $box->id; ?>" class="btn btn-default btn-xs">#<?php echo $box->ref_id; ?></a></td>
									<td style="text-align: right;"><b><?php $total=0;
										foreach($sells as $sell){
										$operations = OperationData::getAllProductsBySellId($sell->id);
											foreach($operations as $operation){
												$product  = $operation->getProduct();
												$total += $operation->q*$product->price_out;
											}
										}
									$total_total += $total;
									echo $sett->coin." ".number_format($total,2,".",","); ?></b></td>
									<td style="text-align: center;"><?php echo $box->created_at; ?></td>
									<?php if($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
								</tr>
							<?php endforeach; ?>
							</table>
							<h3>Total: <?php echo $sett->coin." ".number_format($total_total,2,".",","); ?></h3>
						</div>
					</div>
				</div>
			</div>
			<?php }else { ?>
			<div class="jumbotron">
				<h3>No hay ventas</h3>
				<p>No se ha realizado ninguna venta.</p>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php endif; ?>
</section>