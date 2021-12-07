<section class="content">
	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]);
  	$sett = SettingData::getByAdmin($u->admin_id); ?>
	<?php if(isset($_GET["product"]) && $_GET["product"]!=""):?>
	<?php $products = ProductData::getLikeByAdmin($_GET["product"],$u->admin_id);
	if(count($products)>0){ ?>
	<div class="row">
		<div class="col-md-12">
			<h3>Resultados de la Busqueda</h3>
			<div class="box">
				<div class="box-body no-padding">
					<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center;">Código</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Marca</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center; width: 63px;">Talla</th>
									<th style="text-align: center;">Stock</th>
									<th style="text-align: center;">Venta&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center; width:100px;">Acción</th>
								</thead>
								<?php $products_in_cero=0;
								foreach($products as $product):
								$q= OperationData::getQYesF($product->id); ?>
								<?php 
								if($q>0):?>
								<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
									<td style="text-align: right;"><?php echo $product->barcode; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td><?php $brand = BrandData::getById($product->brand_id); echo $brand->name; ?></td>
									<td><?php $color=ColorData::getById($product->color_id); echo $color->name; ?></td>
									<td style="text-align: center; width: 63px;"><?php $size = Serie_sizeData::getById($product->size_id); echo $size->size; ?></td>
									<td style="text-align: right;"><?php echo $q; ?></td>
									<td style="text-align: right;"><?php echo $sett->coin." ".number_format($product->price_out,2); ?></td>
									<td style="text-align: center;">
										<form method="post" action="index.php?view=addtocart">
											<input type="hidden" name="size_id" value="<?php echo $product->size_id; ?>">
											<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
											<div class="input-group" style="width: 90px;">
											  	<input type="" class="form-control" required name="q" placeholder="Cant..." size="4">
										      	<span class="input-group-btn">
													<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i></button>
										      	</span>
										    </div>
										</form></td>
								</tr>
								<?php else:$products_in_cero++; ?>
								<?php  endif; ?>
								<?php endforeach;?>
							</table>
						</div>
					</div>
						<?php if($products_in_cero>0){ echo "<p class='alert alert-warning'>Se omitieron <b>$products_in_cero productos</b> que no tienen existencias en el inventario. <a href='index.php?view=inventary'>Ir al Inventario</a></p>"; }?>
						<?php
						}else{
							
							echo "<p class='alert alert-danger'>No se encontro el producto</p>";
						}
						?>
						<hr><br>
						<?php else: ?>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>