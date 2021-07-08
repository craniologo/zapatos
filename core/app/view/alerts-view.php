<section class="content">
  	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-bell-o"></i> Alertas de Stock</h2>
			<p>Aquí se visulizan las alertas cuando los productos alcanzan el mínimo de stock.</p>
			<div class="clearfix"></div>
			<?php $found=false;
			$products = ProductData::getAll();
			foreach($products as $product){
			$q=OperationData::getQYesF($product->id);	
				if($q<$product->stock_min){
					$found=true;
					break;
					} } ?>
			<?php if($found):?>
			<?php endif;?>
			<?php if($u->id==1){
				$curr_products = ProductData::getAll();
			}else{
				$curr_products = ProductData::getAllByAdmin($u->admin_id);
			}
			if(count($curr_products)>0){ ;?>
			<div class="box">
				<div class="box-body no-padding">
					<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center; width: 40px;">N°</th>
									<th style="text-align: center;">Código</th>
									<th style="text-align: center;">Modelo</th>
									<th style="text-align: center;">Género</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center;">Stock</th>
									<th style="text-align: center;">Alerta</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($curr_products as $product):
								$q=OperationData::getQYesF($product->id); ?>
								<?php if($q<=$product->stock_min):?>
								<tr class="<?php if($q==0){ echo "danger"; }else if($q<=$product->inventary_min/2){ echo "danger"; } else if($q<=$product->inventary_min){ echo "warning"; } ?>">
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td style="text-align: right;"><?php $model=ProductData::getById($product->id); echo $model->barcode; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td><?php echo $product->sex; ?></td>
									<td><?php $color=ColorData::getById($product->color_id); echo $color->name; ?></td>
									<td style="text-align: center;"><?php $size=Serie_sizeData::getById($product->size_id); echo "Talla ".$size->size; ?></td>
									<td style="text-align: right;"><?php echo $q; ?></td>
									<td><?php if($q==0){ echo "<span class='label label-danger'>No hay existencias.</span>";}else if($q<=$product->stock_min/2){ echo "<span class='label label-danger'>Quedan muy pocas existencias.</span>";} else if($q<=$product->stock_min){ echo "<span class='label label-warning'>Quedan pocas existencias.</span>";} ?>
									</td>
								</tr>
								<?php endif;?>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
					<div class="btn-group pull-right">
						<?php }else{ ?>
						<div class="jumbotron">
							<h2>No hay alertas</h2>
							<p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha alcanzado el nivel minimo.</p>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>