<section class="content">
	<?php $u=null;
	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
	$u = UserData::getById($_SESSION["user_id"]); ?>
	<div class="row">
		<div class="col-md-12">
		<h2><i class="fa fa-refresh"></i> Reabastecer Inventario</h2>
		<a href="index.php?view=res" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
		<br><br>
		<p><b><i class="fa fa-search"></i> Buscar producto por modelo o codigo:</b></p>
			<form>
			<div class="row">
				<div class="col-md-4">
					<input type="hidden" name="view" value="re">
					<input type="text" name="product" class="form-control">
				</div>
				<div class="col-md-1">
				<button type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-search"></i> Buscar</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-12">
		<?php if(isset($_GET["product"])):?>
		<?php $products = ProductData::getLikeByAdmin($_GET["product"],$u->admin_id);
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
									<th style="text-align: center;">Género</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Precio&nbsp;S/</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center;">Stock</th>
									<th style="text-align: center;">Cantidad</th>
									<th style="text-align: center; width:80px;">Acción</th>
								</thead>
								<?php $products_in_cero=0;
								foreach($products as $product):
								$q= OperationData::getQYesF($product->id); ?>
								<form method="post" action="index.php?view=re_add_to">
								<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
									<td style="text-align: right;"><?php echo $product->barcode; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td><?php $bran = BrandData::getById($product->brand_id); echo $bran->name; ?></td>
									<td><?php echo $product->sex; ?></td>
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
				<th style="text-align: center;">Codigo</th>
				<th style="text-align: center;">Producto</th>
				<th style="text-align: center;">Mensaje</th>
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
		<?php if(isset($_SESSION["reabastecer"])):
		$total = 0; ?>
		<div class="col-md-12">
			<h2>Lista de Reabastecimiento</h2>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover" style="border: 1px solid;">
								<thead>
									<th style="text-align: center; width:30px;">N°</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Marca</th>
									<th style="text-align: center;">Género</th>
									<th style="text-align: center;">Color</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center; width:30px;">Cant</th>
									<th style="text-align: center; ">P. Unit</th>
									<th style="text-align: center; width:30px;">Total</th>
									<th style="text-align: center; width:30px;">Acción</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($_SESSION["reabastecer"] as $p):
								$product = ProductData::getById($p["product_id"]);
								?>
								<tr >
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td><?php echo $product->modelo; ?></td>
									<td style="text-align: center;"><?php $brand = BrandData::getById($product->brand_id); echo $brand->name; ?></td>
									<td style="text-align: center;"><?php echo $product->sex; ?></td>
									<td style="text-align: center;"><?php $color=ColorData::getById($product->color_id); echo $color->name; ?></td>
									<td style="text-align: center;"><?php $size = Serie_sizeData::getById($p["size_id"]); echo $size->size; ?></td>
									<td style="text-align: center;" ><?php echo $p["q"]; ?></td>
									<td style="text-align: right;"><?php echo "S/ ".number_format($product->price_in,2,".",","); ?></td>
									<td style="text-align: right;"><b>S/.&nbsp;<?php  $pt = $product->price_in*$p["q"]; $total +=$pt; echo number_format($pt,2,".",","); ?></b></td>
									<td style="text-align: center;"><a href="index.php?view=clearre&product_id=<?php echo $product->id; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<form method="post" class="form-horizontal" id="re_process" action="index.php?action=re_process">
				<h2>Resumen:</h2>
				<div class="form-group">
					<?php $asset = SellData::getLastReByAdmin($u->admin_id);
			        $num = 1;
			        foreach ($asset as $asse) {
			          $num = $asse->ref_id + 1; }; ?>
					<label for="inputEmail1" class="col-lg-2 control-label">Número:</label>
				    <div class="col-lg-2">
				      <input type="text" name="ref_id" required class="form-control" id="ref_id" value="<?php echo $num; ?>" placeholder="Número de documento">
				    </div>
				    <label for="inputEmail1" class="col-lg-1 control-label">Proveedor:</label>
				    <div class="col-lg-2">
					    <select name="client_id" class="form-control" required>
						    <option value="">-- SELECCIONAR --</option>
						    <?php foreach(PersonData::getProvidersByAdmin($u->admin_id) as $provider):?>
						    	<option value="<?php echo $provider->id;?>"><?php echo $provider->name." ".$provider->lastname;?></option>
						    <?php endforeach;?>
				    	</select>
				    </div>
				    <div>
					    <div class="col-lg-1">
					      <a href="#provider_new" class="btn btn-default" data-toggle="modal"><i class='fa fa-truck'></i> Agregar</a>
					    </div>
					</div>
					<label for="inputEmail1" class="col-lg-1 control-label">Efectivo:</label>
				    <div class="col-lg-2">
				      <input type="text" name="money" required class="form-control" id="money" placeholder="Efectivo">
				    </div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-7">
						<div class="box box-primary">
							<table class="table table-bordered table-hover">
								<tr>
									<td><p>Subtotal</p></td>
									<td><p><b>S/. <?php echo number_format($total*.82,2,".",","); ?></b></p></td>
								</tr>
								<tr>
									<td><p>IGV</p></td>
									<td><p><b>S/. <?php echo number_format($total*.18,2,".",","); ?></b></p></td>
								</tr>
								<tr>
									<td><p>Total</p></td>
									<td><p><b>S/. <?php echo number_format($total,1,".",","); ?></b></p></td>
								</tr>
							</table>
						</div>
						<div class="form-group">
						    <div class="col-lg-offset-2 col-lg-10">
						      <div class="checkbox">
						        <label>
						          <input name="is_oficial" type="hidden" value="1">
						        </label>
						      </div>
						    </div>
						</div>
						<div class="form-group">
						    <div class="col-lg-offset-3 col-lg-10">
						      <div class="checkbox">
						        <label>
						        <input type="hidden" name="money1" value="<?php echo $total;?>">

						        <button class="btn btn-lg btn-primary"><i class="fa fa-refresh"></i> Procesar Reabastecimiento</button>
						        <a href="index.php?view=clearre" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
						        </label>
						      </div>
						    </div>
						</div>
					</div>
				</div>
			</form>
			<script>
				$("#processsell").submit(function(e){
					money = $("#money").val();
					if(money<<?php echo $total;?>){
						alert("No se puede efectuar la operacion");
						e.preventDefault();
					}else{
						go = confirm("Cambio: S/ "+(money-<?php echo $total;?>));
						if(go){}
							else{e.preventDefault();}
					}
				});
			</script>
		</div>
		<br><br><br><br><br>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</section>

<div class="modal fade" id="provider_new"><!--Inicio de ventana modal 2-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Ingrese el Nuevo Proveedor</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="addproduct" action="index.php?action=provider_add_re" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">Nombre*</label>
          <div class="col-md-6">
            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">Apellido*</label>
          <div class="col-md-6">
            <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellido">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">RUC/DNI*</label>
          <div class="col-md-6">
            <input type="text" name="ruc" class="form-control" required id="ruc" placeholder="RUC/DNI">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">Direccion*</label>
          <div class="col-md-6">
            <input type="text" name="address1" class="form-control" required id="address1" placeholder="Direccion">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">Email*</label>
          <div class="col-md-6">
            <input type="text" name="email1" class="form-control" id="email1" placeholder="Email">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">Telefono*</label>
          <div class="col-md-6">
            <input type="text" name="phone1" class="form-control" id="phone1" placeholder="Telefono">
          </div>
        </div>
        <p class="alert alert-info">* Campos obligatorios</p>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
          </div>
        </div>
      </form>
        </div>
      </div>
    </div>
</div><!--Fin de ventana modal 2-->