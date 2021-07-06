<section class="content">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]); ?>
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
		$total = 0; ?>
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
					<th style="text-align: center; width: 30px;">Precio&nbsp;S/</th>
					<th style="text-align: center; width: 30px;">Total&nbsp;S/</th>
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
					<td style="text-align: right;"><?php echo number_format($product->price_out,2,".",","); ?></td>
					<td style="text-align: right;"><b><?php  $pt = $product->price_out*$p["q"]; $total +=$pt; echo number_format($pt,2,".",","); ?></b></td>
					<td style="width:30px;"><a href="index.php?action=cart_clear&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="col-md-12">
			<form method="post" class="form-horizontal" id="sell_process" action="index.php?action=sell_process" name="sell_process">
				<h3>Resumen: Total S/. <?php echo number_format($total,2,".",","); ?> </h3>
				<div class="form-group">
			        <label for="inputEmail1" class="col-lg-1 control-label">Sucursal:</label>
				    <div class="col-md-2">
				    	<h4 class=""><?php echo StockData::getPrincipal()->name; ?></h4>
				    	<input type="hidden" name="stock_id" value="<?php echo StockData::getPrincipal()->id; ?>">
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
				    <?php $clients = PersonData::getClientsbyAdmin($u->admin_id); ?>
					    <select name="client_id" class="form-control">
						    <!--<option value="">-- NINGUNO --</option>-->
						    <?php foreach($clients as $client):?>
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
				      <input type="text" name="money" required class="form-control" id="money" onkeyup="Restar()" value="0">
				    </div>
				</div>
				<input type="hidden" name="pay" value="<?php echo $total_costo; ?>">
		      	<input type="hidden" name="total" value="<?php echo $total; ?>" class="form-control" placeholder="Total" onkeyup="Restar()">
		    </div>
		  		<div class="row">
					<div class="col-md-3 col-md-offset-8">
						<div class="box box-primary">
							<table class="table table-bordered table-hover">
								<tr>
									<td>C/ Descuento:</td>
									<td>S/. <input type="text" name="stotal" readonly="" style="border: transparent; font-weight: bold;"></td>
								</tr>
								<tr>
									<td>IGV (18%):</td>
									<td>S/. <input type="text" name="igv" readonly="" style="border: transparent; font-weight: bold;"></td>
								</tr>
								<tr>
									<td>Subtotal:</td>
									<td>S/. <input type="text" name="subtotal" readonly="" style="border: transparent; font-weight: bold;"></td>
								</tr>
									<input type="hidden" name="saldo" readonly="" style="border: transparent; font-weight: bold;"></td>
								<tr>
									<td>Saldo:</td>
									<td>S/. <input type="text" name="saldo1" readonly="" style="border: transparent; font-weight: bold;"></td>
								</tr>
									 <input id="credito" type="hidden" name="credit" placeholder="000"/>
							</table>
						</div>
						<div class="form-group">
						    <div class="col-lg-offset-3 col-lg-10">
						      <div class="checkbox">
						        <label>
						          <input name="is_oficial" type="hidden" value="1">
						        </label>
						      </div>
						    </div>
						</div>
						<div class="form-group" >
						    <div class="col-lg-offset-1 col-lg-12">
						      <div class="checkbox">
						        <label>
							        <button class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-usd"></i><i class="glyphicon glyphicon-usd"></i> Confirmar Venta</button>
									<a href="index.php?action=cart_clear" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
						        </label>
						      </div>
						    </div>
						</div>
					</div>
				</div>
			</form>
		<script type="text/javascript">
			$(document).ready(function() {

			 $(document).on('click keyup','.ckbxs',function() {
			   calcular();
			 });

			});

			function calcular() {
			  var tot = $('#credito');
			  tot.val(0);
			  $('.ckbxs').each(function() {
			    if($(this).hasClass('ckbxs')) {
			      tot.val(($(this).is(':checked') ? parseFloat($(this).attr('value')) : 0) + parseFloat(tot.val()));
			    }
			    else {
			      tot.val(parseFloat(tot.val()) + (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
			    }
			  });
			  var totalParts = parseFloat(tot.val()).toFixed(2).split('.');
			  tot.val(+ totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '' +  (totalParts.length > 1 ? totalParts[1] : '0'));
			}
		</script>

		<script type="text/javascript">

			$("#sell_process").submit(function(e){
				discount = $("#discount").val();
				money = $("#money").val();
				credito = $("#credito").val();

			if(credito==100){
				if(discount==""){ discount=0;}
					go = confirm("Monto adicional de deuda: S/ "+(-1*(money-(<?php echo $total;?>-discount ) )) );
					if(go){}
					else{e.preventDefault();}

			}else{
				if(money<(<?php echo $total;?>-discount)){
					alert("Ingrese monto TOTAL DE VENTA o marque PAGO A CRÉDITO");
					e.preventDefault();
				}else{
					if(discount==""){ discount=0;}
					go = confirm("Cambio: S/ "+(money-(<?php echo $total;?>-discount ) ) );
					if(go){}
					else{e.preventDefault();}
				}
			}
			});
		</script>

		<script type="text/javascript">
			function Restar() {
				var d=.18, e=.82;
				a=document.sell_process.total.value;
				b=document.sell_process.discount.value;
				c=parseFloat(a)-parseFloat(b);
				c=Number(c.toFixed(2));
				document.sell_process.stotal.value=c;
				f=parseFloat(c)*parseFloat(d);
				f=Number(f.toFixed(2));
				document.sell_process.igv.value=f;
				g=parseFloat(c)*parseFloat(e);
				g=Number(g.toFixed(2));
				document.sell_process.subtotal.value=g;

				h=document.sell_process.money.value;
				i=parseFloat(c)-parseFloat(h);
				i=Number(i.toFixed(2));
				document.sell_process.saldo.value=i;
				if (i>=0){
					j=i;
				}else if (i<0){
					j=0;
				}
				document.sell_process.saldo1.value=j;
			}
			window.onload = Restar;
		</script>

		<br><br><br><br><br>
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