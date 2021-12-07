<section class="content">
	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
  	<?php $sett = SettingData::getByAdmin($u->admin_id); ?>
	<div class="row">
		<div class="col-md-12"><!-- Single button -->
			<h2><i class='fa fa-archive'></i> Corte de Caja #<?php echo BoxData::getById($_GET["id"])->ref_id; ?></h2>
			<a href="./index.php?view=box_history" class="btn btn-default"><i class="fa fa-clock-o"></i> Historial</a>
			<div class="clearfix"></div>
			<?php $products = SellData::getByBoxId($_GET["id"]);
			if(count($products)>0){
			$total_total = 0; ?>
			<br>
			<div class="box box-primary">
				<div class="box-body no-padding">
			  		<div class="box-body">
			  			<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover	">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 50px;">Ver</th>
									<th style="text-align: center;">Subtotal <?php echo $sett->coin; ?></th>
									<th style="text-align: center;">Descuento <?php echo $sett->coin; ?></th>
									<th style="text-align: center;">Total <?php echo $sett->coin; ?></th>
									<th style="text-align: center;">Fecha</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($products as $sell):?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td><?php $number++;?>
									<td style="text-align: center;">
										<a href="./index.php?view=sell_one&id=<?php echo $sell->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>
										<?php $operations = OperationData::getAllProductsBySellId($sell->id); ?></td>
									<td style="text-align: right;"><b><?php echo $sett->coin." ".number_format($sell->total+$sell->discount,2,".",","); ?></b></td>
									<td style="text-align: right;"><b><?php echo $sett->coin." ".number_format($sell->discount,2,".",","); ?></b></td>
									<td style="text-align: right;"><b><?php $total_total += $sell->total;
										echo $sett->coin." ".number_format($sell->total,2,".",","); ?></b></td>
									<td style="text-align: right;"><?php echo $sell->created_at; ?></td>
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
				<h2>No hay ventas</h2>
				<p>No se ha realizado ninguna venta.</p>
			</div>
			<?php } ?>
			<br>
		</div>
	</div>
	<?php endif; ?>
</section>