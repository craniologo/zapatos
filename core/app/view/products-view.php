<section class="content"> <!-- Main content -->
	<?php $u=null;
    if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
    $u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-apple"></i> Todos los Productos</h2>
			<p>Aquí están registrados todos los productos de la empresa.</p>
            <a href="index.php?view=product_new" class="col-md-1 btn btn-default"><i class='fa fa-apple'></i> Nuevo Producto</a>
			<br><br>
			<?php if($u->id==1) {
				$prods = ProductData::getAll();
			}else if($u->id==$u->admin_id) {
				$prods = ProductData::getAllByAdmin($u->admin_id);
			}else{
				$prods = ProductData::getAllByUser($u->id);
			}
			if(count($prods)>0){ ?>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
		  				<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Código</th>
									<th style="text-align: center; width: 80px;">Imágen</th>
									<th style="text-align: center;">Modelo</th>
									<th style="text-align: center;">Marca</th>
									<th style="text-align: center;">Género</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Serie</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center; width: 30px;">Stock</th>
									<th style="text-align: center;">Costo</th>
									<th style="text-align: center;">Venta</th>
									<th style="text-align: center;  width:150px;">Acción</th>
								</thead>
								<?php for ($number=0; $number<1; $number++);?>
								<?php foreach($prods as $prd){
								$q=OperationData::getQYesF($prd->id); ?>
								<tr>
									<td style="text-align: center; width:30px;"><?php echo $number; ?></td><?php $number++;?>
									<td style="text-align: right;"><?php echo $prd->barcode; ?></td>
									<td><?php if($prd->image!=""):?><img src="storage/products/<?php echo $prd->image;?>" style="width:64px;"><?php endif;?></td>
									<td><?php echo $prd->modelo; ?></td>
									<td><?php $brand = BrandData::getById($prd->brand_id); echo $brand->name; ?></td>
									<td><?php echo $prd->sex; ?></td>
									<td><?php $color=ColorData::getById($prd->color_id); echo $color->name; ?></td>
									<td><?php $size = Serie_sizeData::getById($prd->size_id); echo "Serie ".$size->serie_id; ?></td>
									<td><?php $size = Serie_sizeData::getById($prd->size_id); echo "Talla ".$size->size; ?></td>
									<td style="text-align: right;"><?php echo $q; ?></td>
									<td style="text-align: right;">S/ <?php echo number_format($prd->price_in,2); ?></td>
									<td style="text-align: right;">S/ <?php echo number_format($prd->price_out,2); ?></td>
									<td style="text-align: center;">
										<a href="barc.php?id=<?php echo $prd->id; ?>" class="btn btn-default btn-xs" target="_blank" title="Etiquetas"><i class="fa fa-barcode"></i></a>
										<a href="index.php?view=product_edit&id=<?php echo $prd->id;?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-edit"></i></a>
										<a href="index.php?action=product_del&id=<?php echo $prd->id;?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn btn-danger btn-xs" title="Eliminar"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
	  			</div><!-- /.box-body -->
			</div><!-- /.box -->
			<?php }else{
				echo "<p class='alert alert-danger'>Aún no hay productos, ¡agrégalos ya!</p>";
			} ?>
		</div>
	</div>
	<?php endif;?>
</section><!-- /.content -->