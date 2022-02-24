<section class="content">
  	<?php $u=null;
  	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  	$u = UserData::getById($_SESSION["user_id"]); ?>
	<?php if(!isset($_SESSION["stock_id"])){ Core::redir("./?view=selectstock"); }
	$origin = StockData::getById($_SESSION["stock_id"]);
	$sett = SettingData::getByAdmin($u->admin_id); ?>
	<div class="row">
		<div class="col-md-12">
      		<h2><i class="fa fa-exchange"></i> Traspasar Productos</h2>
			<a href="index.php?view=trasps" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
			<br>
			<h3>Origen: <?php echo $origin->name; ?></h3>
			<p><b>Buscar producto por nombre o por codigo:</b></p>
			<form>
			<div class="row">
				<div class="col-md-4">
					<input type="hidden" name="view" value="traspase">
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
			<h2>Resultados de la Busqueda</h2>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
		  				<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th style="text-align: center;">Codigo</th>
									<th style="text-align: center;">Nombre</th>
									<th style="text-align: center;">Talla</th>
									<th style="text-align: center;">Precio&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center;">En inventario</th>
									<th style="text-align: center;">Cantidad</th>
									<th style="text-align: center; width:100px;">Acción</th>
								</thead>
								<?php $products_in_cero=0;
								 foreach($products as $product):
								//$q= OperationData::getQ($product->id);
								$q= OperationData::getQByStock($product->id,$_SESSION["stock_id"]); ?>
								<form method="post" action="index.php?view=addtotraspase">
								<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
									<td style="width:80px;"><?php echo $product->barcode; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td style="text-align: center;"><?php $size = Serie_sizeData::getById($product->size_id); echo $size->size; ?></td>
									<td style="text-align: right;"><b><?php echo $sett->coin." ".number_format($product->price_in,2,".",","); ?></b></td>
									<td style="text-align: center;"><?php echo $q; ?></td>
									<td>
										<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
										<input type="" class="form-control" required name="q" placeholder="Cantidad de producto ..."></td>
										<td style="width:100px;">
										<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Agregar</button></td>
								</tr>
								</form>
								<?php endforeach;?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<br><hr>
			<hr><br>
			<?php else: ?>
			<?php endif; ?>
		</div>
		<div class="col-md-12">
			<!--- Carrito de compras :) -->
			<?php if(isset($_SESSION["traspase"])):
			$total = 0; ?>

			<h2>Lista de Reabastecimiento</h2>
			<div class="box">
	  			<div class="box-body no-padding">
	  				<div class="box-body">
		  				<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center; width: 60px;">Codigo</th>
									<th style="text-align: center; ">Nombre</th>
									<th style="text-align: center; width: 30px;">Talla</th>
									<th style="text-align: center; width: 30px;">Cant</th>
									<th style="text-align: center; width: 40px;">Precio&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center; width: 40px;">Total&nbsp;<?php echo $sett->coin; ?></th>
									<th style="text-align: center; width: 60px;">Acción</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($_SESSION["traspase"] as $p):
								$product = ProductData::getById($p["product_id"]);
								?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td><?php echo $product->barcode; ?></td>
									<td><?php echo $product->modelo; ?></td>
									<td style="text-align: center;"><?php $size = Serie_sizeData::getById($product->size_id); echo $size->size; ?></td>
									<td style="text-align: center;"><?php echo $p["q"]; ?></td>
									<td><b><?php echo $sett->coin." ".number_format($product->price_in,2,".",","); ?></b></td>
									<td><b><?php  $pt = $product->price_in*$p["q"]; $total +=$pt; echo $sett->coin." ".number_format($pt,2,".",","); ?></b></td>
									<td style=""><a href="index.php?view=cleartraspase&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>

								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<form method="post" class="form-horizontal" id="traspase_process" action="index.php?action=traspase_process">
				<h2>Resumen</h2>
				<div class="form-group">
					<?php $asset = SellData::getAllByLastTraspase();
			        $num = 1;
			        foreach ($asset as $asse) {
			          $num = $asse->ref_id + 1; }; ?>
					<label for="inputEmail1" class="col-lg-2 control-label">Número:</label>
					<div class="col-lg-1">
				      <input type="text" name="ref_id" readonly class="form-control" id="ref_id" value="<?php echo $num; ?>" placeholder="Número de documento">
				    </div>
				    <label for="inputEmail1" class="col-lg-1 control-label">Destino</label>
				    <div class="col-lg-2">
				    	<?php $clients = StockData::getAllByAdmin($u->admin_id); ?>
					    <select name="stock_id" class="form-control" required>
						    <option value="">-- NINGUNO --</option>
						    <?php foreach($clients as $client):?>
						    	<?php if($client->id!=$_SESSION["stock_id"]):?>
						    	<option value="<?php echo $client->id;?>"><?php echo $client->name;?></option>
						    	<?php endif; ?>
					    	<?php endforeach;?>
				    	</select>
				    </div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-7">
						<div class="box box-primary">
							<table class="table table-bordered">
								<tr>
									<td><p>Subtotal</p></td>
									<td><p><b><?php echo $sett->coin." ".number_format($total,2,'.',','); ?></b></p></td>
								</tr>
								<tr>
									<td><p>Total</p></td>
									<td><p><b><?php echo $sett->coin." ".number_format($total,2,'.',','); ?></b></p></td>
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
						<input type="hidden" name="size_id" value="<?php echo $product->size_id; ?>">
						<input type="hidden" name="total" value="<?php echo $total; ?>">
						<div class="form-group">
						    <div class="col-lg-offset-4 col-lg-12">
						      <div class="checkbox">
						        <label>
								<a href="index.php?view=cleartraspase" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
						        <button class="btn btn-primary"><i class="fa fa-exchange"></i> Procesar Taspaso</button>
						        </label>
						      </div>
						    </div>
					  	</div>
					</div>
				</div>
			</form>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</section>