<section class="content">
	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group pull-right">
			<a href="./index.php?view=boxhistory" class="btn btn-primary "><i class="fa fa-clock-o"></i> Historial</a>
			<a href="./index.php?action=box_process" class="btn btn-primary ">Procesar Ventas <i class="fa fa-arrow-right"></i></a>
			</div>
			<h2><i class='fa fa-archive'></i> Ventas Pendientes de Corte</h2>
			<div class="form-group">
			<div class="clearfix"></div>
			<?php if($u->id==1){
				$sells = SellData::getSellsUnBoxed();
			}else{
				$sells = SellData::getSellsUnBoxedByAdmin($u->admin_id);
			}
			if(count($sells)>0){
			$total_total = 0;
			?>
			<br>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover	">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Cantidad</th>
									<th style="text-align: center;">Total</th>
									<th style="text-align: center;">Fecha</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($sells as $sell):?>
								<tr>
									<td style="text-align: center; width:30px;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td style="text-align: center;"><?php $operations = OperationData::getAllProductsBySellId($sell->id);
										echo count($operations)." Par(es)"; ?></td>
									<td style="text-align: right;"><?php $total_total += $sell->total;
										echo "S/ ".number_format($sell->total,2,".",",");
										?></td>
									<td style="text-align: right;"><?php echo $sell->created_at; ?></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<h3>Total: <?php echo "S/. ".number_format($total_total,2,".",","); ?></h3>
			<?php
			}else { ?>
			<div class="jumbotron">
				<h3>No hay ventas</h3>
				<p>No se ha realizado ninguna venta.</p>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php endif; ?>
</section>