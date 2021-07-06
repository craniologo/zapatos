<section class="content">
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-adjust"></i> Resumen de Reajuste</h2>
			<a href="index.php?view=readjustments" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
			<br><br>
			<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
			<?php $sell = SellData::getById($_GET["id"]);
			$operations = OperationData::getAllProductsBySellId($_GET["id"]);
			$total = 0; ?>
			<?php
			if(isset($_COOKIE["selled"])){
				foreach ($operations as $operation) {
			//		print_r($operation);
					$qx = OperationData::getQYesF($operation->product_id);
					// print "qx=$qx";
						$p = $operation->getProduct();
					if($qx==0){
						echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->barcode</b> no tiene existencias en inventario.</p>";			
					}else if($qx<=$p->stock_min/2){
						echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->barcode</b> tiene muy pocas existencias en inventario.</p>";
					}else if($qx<=$p->stock_min){
						echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->barcode</b> tiene pocas existencias en inventario.</p>";
					}
				}
				setcookie("selled","",time()-18600);
			} ?>
			<div class="box" style="width: 300px;">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive" >
							<table class="table table-bordered">
								<?php if($sell->person_id!=""):
								$client = $sell->getPerson(); ?>
								<tr>
									<td style="width:150px";>Documento N°</td>
									<td style="width: 200px;"><?php echo $sell->ref_id; ?></td>
								</tr>
								<?php endif; ?>
								<?php if($sell->user_id!=""):
								$user = $sell->getUser(); ?>
								<tr>
									<td>Atendido por</td>
									<td><?php echo $user->name." ".$user->lastname;?></td>
								</tr>
								<?php endif; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Cantidad</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Marca</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center;">Costo</th>
									<th style="text-align: center;">Total</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($operations as $operation){
								$product  = $operation->getProduct(); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td style="text-align: right;"><?php echo $operation->q ;?></td>
									<td><?php echo $product->modelo; ?></td>
									<td><?php $brands = BrandData::getById($product->brand_id); echo $brands->name; ?></td>
									<td><?php $color = ColorData::getById($product->color_id); echo $color->name; ?></td>
									<td style="text-align: right;"><?php $size = Serie_sizeData::getById($operation->size_id); echo $size->size; ?></td>
									<td style="text-align: right;">S/. <?php echo number_format($product->price_in,2,".",",") ;?></td>
									<td style="text-align: right;"><b>S/. <?php echo number_format($operation->q*$product->price_in,2,".",",");$total+=$operation->q*$product->price_in;?></b></td>
								</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<h2>Total: S/. <?php echo number_format($total,2,'.',','); ?></h2>
			<?php ?>	
			<?php else:?>
			501 Internal Error
			<?php endif; ?><br><br><br><br><br>
		</div>
	</div>
</section>