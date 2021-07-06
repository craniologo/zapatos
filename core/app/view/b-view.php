<section class="content">
	<div class="row">
		<div class="col-md-12"><!-- Single button -->
			<h2><i class='fa fa-archive'></i> Corte de Caja #<?php echo $_GET["id"]; ?></h2>
			<div class="btn-group pull-right">
				<a href="./index.php?view=box_history" class="btn btn-default"><i class="fa fa-clock-o"></i> Historial</a>
			</div>
			<div class="clearfix"></div>
			<?php $products = SellData::getByBoxId($_GET["id"]);
			if(count($products)>0){
			$total_total = 0; ?>
			<br>
			<div class="box box-primary">
				<div class="box-body no-padding">
			  		<div class="box-body">
			  			<div class="box-body table-responsive">
							<table class="table table-bordered table-hover	">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 50px;">Ver</th>
									<th style="text-align: center;">Total&nbsp;S/</th>
									<th style="text-align: center;">Fecha</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($products as $sell):?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td><?php $number++;?>
									<td style="text-align: center;">
										<a href="./index.php?view=sell_one&id=<?php echo $sell->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>
										<?php $operations = OperationData::getAllProductsBySellId($sell->id); ?></td>
									<td style="text-align: right;"><?php $total_total += $sell->total-$sell->discount;
										echo "<b>".number_format($sell->total-$sell->discount,2,".",",")."</b>"; ?></td>
									<td style="text-align: right;"><?php echo $sell->created_at; ?></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<h3>Total: <?php echo "S/ ".number_format($total_total,2,".",","); ?></h3>
			<?php }else { ?>
			<div class="jumbotron">
				<h2>No hay ventas</h2>
				<p>No se ha realizado ninguna venta.</p>
			</div>
			<?php } ?>
			<br>
		</div>
	</div>
</section></section>