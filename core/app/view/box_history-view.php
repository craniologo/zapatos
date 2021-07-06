<section class="content">
	<div class="row">
		<div class="col-md-12"><!-- Single button -->
			<h2><i class='fa fa-archive'></i> Historial de Caja</h2>
			<div class="clearfix"></div>
			<?php $boxes = BoxData::getAll();
			$products = SellData::getSellsUnBoxed();
			if(count($boxes)>0){
			$total_total = 0; ?>
			<br>
			<div class="box box-primary">
				<div class="box-body no-padding">
			  		<div class="box-body">
			  			<div class="box-body table-responsive">
							<table class="table table-bordered table-hover	">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Ver</th>
									<th style="text-align: center;">Total&nbsp;S/</th>
									<th style="text-align: center;">Almacen</th>
									<th style="text-align: center;">Fecha</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($boxes as $box):
								$sells = SellData::getByBoxId($box->id); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td><?php $number++;?>
									<td style="width:30px;">
										<a href="./index.php?view=b&id=<?php echo $box->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a></td>
									<td style="text-align: right;"><?php $total=0;
										foreach($sells as $sell){
										$operations = OperationData::getAllProductsBySellId($sell->id);
												$total += $sell->total-$sell->discount;
										}
										$total_total += $total;
										echo "<b>".number_format($total,2,".",",")."</b>"; ?></td>
									<td><?php echo $box->getStock()->name; ?></td>
									<td style="text-align: right;"><?php echo $box->created_at; ?></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<h3>Total: <?php echo "S/ ".number_format($total_total,2,".",","); ?></h3>
				<?php
			}else { ?>
			<div class="jumbotron">
				<h2>No hay ventas</h2>
				<p>No se ha realizado ninguna venta.</p>
			</div>
			<?php } ?>
			<br>
		</div>
	</div>
</section>