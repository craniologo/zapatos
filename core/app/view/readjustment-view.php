<section class="content">
  	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
		<h2><i class="fa fa-adjust"></i> Reajustar Inventario</h2>
		<p>El Reajuste sera aplicado al stock de la sucursal principal.</p>
		<p><b>Buscar producto por codigo:</b></p>
			<form>
			<div class="row">
				<div class="col-md-6">
					<input type="hidden" name="view" value="readjustment">
					<input type="text" name="readjust" class="form-control">
				</div>
				<div class="col-md-3">
				<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-12">
		<?php if(isset($_GET["readjust"])):?>
		<?php $products = ProductData::getLikeByAdmin($_GET["readjust"],$u->admin_id);
		if(count($products)>0){ ?>
			<h3>Resultados de la Busqueda</h3>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
		  				<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th style="text-align: center; width: 80px;">Codigo</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Marca</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Precio&nbsp;S/</th>
									<th style="text-align: center; width: 63px;">Talla</th>
									<th style="text-align: center;">Stock</th>
									<th style="text-align: center;width: 100px; ">Cantidad</th>
									<th style="text-align: center; width:20px;">Acción</th>
								</thead>
								<?php $products_in_cero=0;
								foreach($products as $product):
								$q= OperationData::getQYesF($product->id); ?>
								<form method="post" action="index.php?view=readj_add_to">
								<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
									<td style="text-align: right;"><?php echo $product->barcode; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td><?php $bran = BrandData::getById($product->brand_id); echo $bran->name; ?></td>
									<td><?php $color = ColorData::getById($product->color_id); echo $color->name; ?></td>
									<td style="text-align: right;"><b><?php echo number_format($product->price_in,2,".",","); ?></b></td>
									<td style="text-align: right; width: 63px;"><?php $size = Serie_sizeData::getById($product->size_id); echo $size->size; ?></td>
									<td style="text-align: right;"><?php echo $q; ?></td>
									<td><input type="hidden" name="size_id" value="<?php echo $product->size_id; ?>">
										<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
										<input type="" class="form-control" required name="q" placeholder="Cantidad"></td>
									<td style="width:10px;"><button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i></button></td>
								</tr>
								</form>
								<?php endforeach;?>
							</table>
						</div>
					</div>
				</div>
			</div>
		<?php }else{
			echo '<br><p class="alert alert-danger">No se encontro el artículo</p>';
			} ?>
		</div>
		<br><hr>
		<hr><br>
		<?php else: ?>
		<?php endif; ?>
		<?php if(isset($_SESSION["errors"])):?>
		<h2>Errores</h2>
		<p></p>
		<table class="table table-bordered table-hover">
			<tr class="danger">
				<th>Codigo</th>
				<th>Producto</th>
				<th>Mensaje</th>
			</tr>
			<?php foreach ($_SESSION["errors"]  as $error):
			$product = ProductData::getById($error["product_id"]); ?>
			<tr class="danger">
				<td><?php echo $product->id; ?></td>
				<td><?php echo $product->name; ?></td>
				<td><b><?php echo $error["message"]; ?></b></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php unset($_SESSION["errors"]); endif; ?>

		<!--- Carrito de compras :) -->
		<?php if(isset($_SESSION["readjust"])):
		$total = 0; ?>
		<div class="col-md-12">
			<h2>Lista de Reajuste</h2>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover" style="border: 1px solid;">
								<thead>
									<th style="text-align: center; width:30px;">N°</th>
									<th style="text-align: center; width:30px;">Cantidad</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Marca</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center; width:30px;">Costo</th>
									<th style="text-align: center; width:30px;">Total</th>
									<th style="text-align: center;">Acción</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($_SESSION["readjust"] as $p):
								$product = ProductData::getById($p["product_id"]);
								?>
								<tr >
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td style="text-align: center;" ><?php echo $p["q"]; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td style="text-align: center;"><?php $brand = BrandData::getById($product->brand_id); echo $brand->name; ?></td>
									<td style="text-align: center;"><?php $color=ColorData::getById($product->color_id); echo $color->name; ?></td>
									<td style="text-align: center;"><?php $size = Serie_sizeData::getById($p["size_id"]); echo $size->size; ?></td>
									<td style="text-align: right;"><?php echo number_format($product->price_in,2,".",","); ?></td>
									<td><b>S/.&nbsp;<?php  $pt = $product->price_in*$p["q"]; $total +=$pt; echo number_format($pt,2,".",","); ?></b></td>
									<td style="width:30px;"><a href="index.php?view=clearre&product_id=<?php echo $product->id; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<form method="post" class="form-horizontal" id="readj_process" action="index.php?action=readj_process">
				<div class="form-group">
					<?php $asset = SellData::getLastReadjByAdmin($u->admin_id);
			        $num = 1;
			        foreach ($asset as $asse) {
			          $num = $asse->ref_id + 1; }; ?>
					<label for="inputEmail1" class="col-lg-1 control-label">Número:</label>
				    <div class="col-lg-1">
				      <input type="text" name="ref_id" required class="form-control" id="ref_id" value="<?php echo $num; ?>" readonly>
				    </div>

					<label for="inputEmail1" class="col-lg-1 control-label">Justificación*</label>
					<div class="col-lg-6">
						<textarea class="form-control" type="text" name="justify" placeholder="Justificación del reajuste"></textarea>
					</div>
				</div>
				<div class="form-group">
				    <div class="col-lg-offset-6 col-lg-12">
				      <div class="checkbox">
				        <label>
				        <input type="hidden" name="money1" value="<?php echo $total;?>">
				        <button class="btn btn-lg btn-primary"><i class="fa fa-refresh"></i> Procesar Reajuste</button>
				        <a href="index.php?view=clearre" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
				        </label>
				      </div>
				    </div>
				</div>
			</form>
		</div>
		<br><br><br><br><br>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</section>