<section class="content">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]);
  $sett = SettingData::getByAdmin($u->admin_id); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-shopping-cart"></i> Vender</h2>
			<p><b><i class="fa fa-search"></i> Buscar producto por nombre o codigo de barras:</b></p>
			<form id="searchp">
				<div class="row">
					<div class="col-md-4">
						<input type="hidden" name="view" value="sell">
						<input type="text" id="product_code" name="product" class="form-control" autofocus="">
					</div>
					<div class="col-md-1">
						<button type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-search"></i> Buscar</button>
					</div>
				</div>
			</form>
		</div>
		<div id="show_search_results"></div>
		<script>
		//jQuery.noConflict();

		$(document).ready(function(){
			$("#searchp").on("submit",function(e){
				e.preventDefault();

				$.get("./?action=searchproduct",$("#searchp").serialize(),function(data){
					$("#show_search_results").html(data);
				});
				$("#product_code").val("");

			});
			});

		$(document).ready(function(){
		    $("#product_code").keydown(function(e){
		        if(e.which==17 || e.which==74){
		            e.preventDefault();
		        }else{
		            console.log(e.which);
		        }
		    })
		});
		</script>

		<?php if(isset($_SESSION["errors"])):?>
		<h2>Errores</h2>
		<p></p>
		<div class="box">
  			<div class="box-body no-padding">
  				<div class="box-body">
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover">
							<tr class="danger">
								<th style="text-align: center;">Codigo</th>
								<th style="text-align: center;">Nombre</th>
								<th style="text-align: center;">Talla</th>
								<th style="text-align: center;">Género</th>
								<th style="text-align: center;">Color</th>
								<th style="text-align: center;">Mensaje</th>
							</tr>
							<?php foreach ($_SESSION["errors"]  as $error):
							$product = ProductData::getById($error["product_id"]);
							?>
							<tr class="danger">
								<td style="text-align: center;"><?php echo $product->barcode; ?></td>
								<td><?php echo $product->modelo; ?></td>
								<td style="text-align: center;"><?php $size=Serie_sizeData::getById($product->size_id); echo $size->size; ?></td>
								<td style="text-align: center;"><?php $color=ColorData::getById($product->color_id); echo $color->name; ?></td>
								<td style="text-align: center;"><?php echo $product->sex; ?></td>
								<td><b><?php echo $error["message"]; ?></b></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php unset($_SESSION["errors"]); endif; ?>

		<!--- Carrito de compras :) -->
		<?php if(isset($_SESSION["cart"])):
		$total_costo = 0;
		$subtotal = 0; ?>
		<div class="box-body table-responsive">
		<h3><i class="glyphicon glyphicon-list-alt"></i> Nota de Pedido</h3>
			<table class="table table-bordered table-hover" style="border: 1px solid;">
				<thead>
					<th style="text-align: center; width: 30px;">N°</th>
					<th style="text-align: center;">Modelo</th>
					<th style="text-align: center;">Marca</th>
					<th style="text-align: center;">Género</th>
					<th style="text-align: center;">Color</th>
					<th style="text-align: center;">Serie</th>
					<th style="text-align: center;">Talla</th>
					<th style="text-align: center; width:30px;">Cant.</th>
					<th style="text-align: center;">Precio&nbsp;<?php echo $sett->coin; ?></th>
					<th style="text-align: center;">Total&nbsp;<?php echo $sett->coin; ?></th>
					<th style="text-align: center;">Acción</th>
				</thead>
				<?php for($number=0; $number<1; $number++); //variable incremental
				foreach($_SESSION["cart"] as $p):
				$product = ProductData::getById($p["product_id"]); ?>
				<tr >
					<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
					<td><?php echo $product->modelo; ?><?php  $pc = $product->price_in*$p["q"]; $total_costo +=$pc; ?></td>
					<td><?php $brand = BrandData::getById($product->brand_id); echo $brand->name; ?></td>
					<td><?php echo $product->sex; ?></td>
					<td style="text-align: center;"><?php $color=ColorData::getById($product->color_id); echo $color->name; ?></td>
					<td style="text-align: center;"><?php $size = Serie_sizeData::getById($p["size_id"]); echo $size->serie_id; ?></td>
					<td style="text-align: center;"><?php $size = Serie_sizeData::getById($p["size_id"]); echo $size->size; ?></td>
					<td style="text-align: center;"><?php echo $p["q"]; ?></td>
					<td style="text-align: right;"><b><?php echo $sett->coin." ".number_format($product->price_out,2,".",","); ?></b></td>
					<td style="text-align: right;"><b><?php  $pt = $product->price_out*$p["q"]; $subtotal +=$pt; echo $sett->coin." ".number_format($pt,2,".",","); ?></b></td>
					<td style="width:30px;"><a href="index.php?action=cart_clear&product_id=<?php echo $product->id; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="col-md-12">
			<form method="post" class="form-horizontal" id="sell_process" action="index.php?action=sell_process" name="sell_process">
				<h3>Resumen: Total <?php echo $sett->coin." ".number_format($subtotal,2,".",","); ?> </h3>
				<div class="form-group">
			      <label for="inputEmail1" class="col-lg-1 control-label">Sucursal:</label>
				    <div class="col-md-2">
				    	<h4 class=""><?php echo StockData::getPrincipalByAdmin($u->admin_id)->name; ?></h4>
				    	<input type="hidden" name="stock_id" value="<?php echo StockData::getPrincipalByAdmin($u->admin_id)->id; ?>">
				    </div>
				</div>
				<div class="form-group">
					<?php $asset = SellData::getLastSellByAdmin($u->admin_id);
			        $num = 1;
			        foreach ($asset as $asse) {
			          $num = $asse->ref_id + 1; }; ?>
					<label for="inputEmail1" class="col-lg-1 control-label">Número de guía:</label>
				    <div class="col-lg-1">
				      <input type="text" name="ref_id" readonly="" class="form-control" id="ref_id" value="<?php echo $num; ?>" placeholder="Número de documento">
				    </div>
				    <label for="inputEmail1" class="col-lg-1 control-label">Cliente:</label>
				    <div class="col-md-2">
					    <select name="client_id" class="form-control" required>
						    <option value="">-- SELECCIONAR --</option>
						    <?php foreach(PersonData::getClientsbyAdmin($u->admin_id) as $client):?>
						    <option value="<?php echo $client->id;?>"><?php echo $client->name." ".$client->lastname;?></option>
						    <?php endforeach;?>
				    	</select>
				    </div>
				    <div>
					    <div class="col-lg-1">
					      <a href="#client_new" class="btn btn-default" data-toggle="modal"><i class='fa fa-smile-o'></i> Agregar</a>
					    </div>
					</div>
					<label for="inputEmail1" class="col-lg-1 control-label">Descuento:</label>
				    <div class="col-md-1">
				      <input type="text" name="discount" class="form-control" value="0" id="discount" onkeyup="Restar()">
				    </div>
				    <label for="inputEmail1" class="col-lg-1 control-label">Efectivo:</label>
				    <div class="col-md-1">
				      <input type="text" name="cash" required class="form-control" id="cash" onkeyup="Restar()" value="0">
				    </div>
				</div>
				<input type="hidden" name="pay" value="<?php echo $total_costo; ?>">
		    <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>" onkeyup="Restar()">
		    </div>
		    <div class="col-md-3 col-md-offset-8">
					<div class="box">
						<div class="box-body">
							<table class="table table-bordered table-hover">
								<tr>
									<td>Subtotal&nbsp;(<?php echo $sett->coin; ?>):</td>
									<td><b><input type="text" name="total_igv" readonly="" style="border: transparent; font-weight: bold;"></b></td>
								</tr>
								<tr>
									<td>IGV&nbsp;<?php echo "(".$sett->tax."%) ".$sett->coin; ?>:</td>
									<td><b><input type="text" name="igv" readonly="" style="border: transparent; font-weight: bold;"></b></td>
								</tr>
								<tr>
									<td>Total&nbsp;(<?php echo $sett->coin; ?>):</td>
									<td><b><input type="text" name="total" readonly="" style="border: transparent; font-weight: bold;"></b></td>
								</tr>
							</table>
							<div class="form-group">
							    <div class="col-lg-offset-2 col-lg-10">
							      <div class="checkbox">
							        <label>
									<a href="index.php?action=clear_cart" class="btn btn-lg btn-danger" onclick="return confirm('¿Está seguro de cancelar?')"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
							        <button class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-usd"></i><i class="glyphicon glyphicon-usd"></i> Confirmar</button>
							        </label>
							      </div>
							    </div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<script>
				$("#sell_process").submit(function(e){
					discount = $("#discount").val();
					cash = $("#cash").val();

					if(cash<(<?php echo $subtotal;?>-discount)){
						alert("Ingrese monto TOTAL DE VENTA");
						e.preventDefault();
					}else{
						if(discount==""){ discount=0;}
						go = confirm("Cambio: S/ "+(cash-(<?php echo $subtotal;?>-discount ) ) );
						if(go){}
						else{e.preventDefault();}
					}
				});
			</script>

			<script type="text/javascript">
				// El descuento se aplica al total y a ese monto se resta el IGV que es el subtotal.
				function Restar() {
					var d=1.18, e=.82, f=.18;
					stotal=document.sell_process.subtotal.value;
					disc=document.sell_process.discount.value;
					result=parseFloat(stotal)-parseFloat(disc);
					result=Number(result.toFixed(2));
					document.sell_process.total.value=result;
					tigv=parseFloat(result)/parseFloat(d);
					tigv=Number(tigv.toFixed(2));
					document.sell_process.total_igv.value=tigv;
					igv=parseFloat(tigv)*parseFloat(f);
					igv=Number(igv.toFixed(2));
					document.sell_process.igv.value=igv;
				}
				window.onload = Restar;
			</script>

		<?php endif; ?>
	</div>
	<?php endif; ?>
</section>

<div class="modal fade" id="client_new"><!--Inicio de ventana modal 2-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <center><h4 class="modal-title">Ingrese el Nuevo Cliente</h4></center>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="addproduct" action="index.php?action=client_add_sell" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
          <div class="col-md-9">
            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
          <div class="col-md-9">
            <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellido">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">RUC/DNI*</label>
          <div class="col-md-9">
            <input type="text" name="ruc" class="form-control" required id="ruc" placeholder="RUC/DNI">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Direccion*</label>
          <div class="col-md-9">
            <input type="text" name="address" class="form-control" required id="address" placeholder="Direccion">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Correo*</label>
          <div class="col-md-9">
            <input type="text" name="email" class="form-control" id="email" placeholder="Correo Electrónico">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
          <div class="col-md-9">
            <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefono">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-9">
        	<p class="alert alert-info">* Campos obligatorios</p>
          </div>
       	</div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-9">
            <button type="submit" class="btn btn-primary">Agregar Cliente</button>
          </div>
        </div>
      </form>
        </div>
      </div>
    </div>
</div><!--Fin de ventana modal 2-->