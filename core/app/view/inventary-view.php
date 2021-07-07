<section class="content">
	<?php $u=null;
    if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
    $u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="glyphicon glyphicon-stats"></i> Inventario de Productos la Sucursal <?php echo StockData::getById($_GET["stock"])->name; ?></h2>
			<?php if($u->kind==1):?><a href="index.php?view=stocks" class="btn btn-default"><i class="fa fa-arrow-left"></i> Sucursales</a>
			<br><br><?php endif; ?>
			<?php $curr_products = ProductData::getAllByAdmin($u->admin_id); ?>
		</div>
	</div>
	<?php if(count($curr_products)>0){ ;?>
	<div class="box">
		<div class="box-body no-padding">
			<div class="box-body">
				<div class="box-body table-responsive">
					<table class="table table-bordered datatable table-hover">
						<thead>
							<th style="text-align: center; width: 30px;">N°</th>
							<th style="text-align: center;">Codigo</th>
							<th style="text-align: center;">Nombre</th>
							<th style="text-align: center;">Marca</th>
							<th style="text-align: center;">Género</th>
							<th style="text-align: center;">Color</th>
							<th style="text-align: center;">Talla</th>
							<th style="text-align: center;">Stock</th>
						</thead>
						<?php for($number=0; $number<1; $number++); //variable incremental
						foreach($curr_products as $product):
						$q=OperationData::getQYesFByStock($product->id,$_GET["stock"]);?>

						<tr class="<?php if($q<=$product->inventary_min/2){ echo "danger";}else if($q<=$product->inventary_min){ echo "warning";}?>">
							<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->

							<td style="text-align: right;"><?php echo $product->barcode; ?></td>
							<td><?php echo $product->modelo; ?></td>
							<td><?php $bran = BrandData::getById($product->brand_id); echo $bran->name; ?></td>
							<td><?php echo $product->sex; ?></td>
							<td><?php $col = ColorData::getById($product->color_id); echo $col->name; ?></td>
							<td><?php $size = Serie_sizeData::getById($product->size_id); echo "Talla ".$size->size; ?></td>
							<td style="text-align: right;"><?php echo $q; ?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	}else{
		echo "<p class='alert alert-danger'>Aún no hay productos, ¡agrégalos ya!</p>";
	} ?>
	<?php endif; ?>
</section>