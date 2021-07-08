<section class="content">
	<div class="row">
		<div class="col-md-12">
			<h2><i class='fa fa-adjust'></i> Lista de Reajustes</h2>
	        <ol class="breadcrumb">
	          <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	          <li><i class="fa fa-cube"></i> Stock</li>
	          <li class="active"><i class="fa fa-adjust"></i> Reajustes</li>
	        </ol>
			<a href="index.php?view=readjustment" class="btn btn-default"><i class='fa fa-adjust'></i> Reajuste</a>
			<br><br>
			<?php $products = SellData::getReadjs();
			if(count($products)>0){ ?>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
	  					<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover	">
								<thead>
									<th style="text-align: center; width:30px;">N°</th>
									<th style="text-align: center; width:30px;">Guía</th>
									<th style="text-align: center;">Cant</th>
									<th style="text-align: center;">Total S/</th>
									<th style="text-align: center;">Fecha</th>
									<th style="text-align: center; width:30px;">Acción</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);
								foreach($products as $sell):?>
								<tr>
									<td style="text-align: center; width:30px;"><?php echo $number; ?></td><?php $number++;?>
									<td style="text-align: right;"><a href="index.php?view=readjustment_one&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-default"><?php echo $sell->ref_id; ?></a></td>
									<td style="text-align: right;"><?php $operations = OperationData::getAllProductsBySellId($sell->id);
										echo count($operations); ?></td>
									<td style="text-align: right;"><?php $total=0;
										foreach($operations as $operation){
										$product  = $operation->getProduct();
										$total += $operation->q*$product->price_in; }; 
										echo number_format($total,2,".",",")."</b>"; ?></td>
									<td style="text-align: right;"><?php echo $sell->created_at; ?></td>
									<td style="text-align: center;"><a href="index.php?action=readjustment_del&id=<?php echo $sell->id; ?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td>
								</tr>
							<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php }else{ ?>
			<div class="jumbotron">
				<h2>No hay datos</h2>
				<p>No se ha realizado ninguna operacion.</p>
			</div>
			<?php } ?>

		</div>
	</div>
</section>