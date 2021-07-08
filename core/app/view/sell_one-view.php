<section class="content">
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-usd"></i> Resumen de Venta</h2>
			<a href="index.php?view=sells" class="btn btn-default"><i class="fa fa-arrow-left"></i> Ventas</a>
			<br><br>
			<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
			<?php $sell = SellData::getById($_GET["id"]);
			$operations = OperationData::getAllProductsBySellId($_GET["id"]);
			$sett = SettingData::getByAdmin($sell->admin_id);
			$total = 0; ?>

			<?php if(isset($_COOKIE["selled"])){
				foreach ($operations as $operation) {
			//		print_r($operation);
					$qx = OperationData::getQYesF($operation->product_id);
					// print "qx=$qx";
						$p = $operation->getProduct();
						$size = Serie_sizeData::getById($p->size_id);
					if($qx==0){
						echo "<p class='alert alert-danger'>El modelo <b style='text-transform:uppercase;'> $p->modelo</b> talla <b>$size->size</b> no tiene existencias en inventario.</p>";			
					}else if($qx<=$p->stock_min/2){
						echo "<p class='alert alert-danger'>El modelo <b style='text-transform:uppercase;'> $p->modelo</b> talla <b>$size->size</b> tiene muy pocas existencias en inventario.</p>";
					}else if($qx<=$p->stock_min){
						echo "<p class='alert alert-warning'>El modelo <b style='text-transform:uppercase;'> $p->modelo</b> talla <b>$size->size</b> tiene pocas existencias en inventario.</p>";
					}
				}
				setcookie("selled","",time()-18600);
			} ?>
			<div class="col-md-3">
				<div class="box">
		  			<div class="box-body no-padding">
		  				<div class="box-body">
							<div class="box-body table-responsive">
								<table class="table table-bordered">
								<?php if($sell->person_id!=""):
								$client = $sell->getPerson(); ?>
								<tr>
									<td style="width:100px";>Operación N°</td>
									<td><?php echo $sell->ref_id; ?></td>
								</tr>
								<tr>
									<td style="width:100px;">Cliente:</td>
									<td><?php echo $client->name."&nbsp;".$client->lastname;?></td>
								</tr>
								<tr>
									<td style="width:100px;">RUC/DNI:</td>
									<td><?php echo $client->ruc;?></td>
								</tr>
								<?php endif; ?>
								<?php if($sell->user_id!=""):
								$user = $sell->getUser();
								?>
								<tr>
									<td>Cajero:</td>
									<td><?php echo $user->name." ".$user->lastname;?></td>
								</tr>
								<?php endif; ?>
								<tr>
									<td style="width:100px;">Fecha: </td>
									<td><?php echo $sell->created_at;?></td>
								</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box">
		  			<div class="box-body no-padding">
		  				<div class="box-body">
							<div class="box-body table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<th style="text-align: center;">N°</th>
										<th style="text-align: center;">Código</th>
										<th style="text-align: center;">Producto</th>
										<th style="text-align: center;">Talla</th>
										<th style="text-align: center;">Cant</th>
										<th style="text-align: center;">P. Unit</th>
										<th style="text-align: center;">Total</th>
									</thead>
									<?php for($number=0; $number<1; $number++); //variable incremental
									foreach($operations as $operation){
										$product  = $operation->getProduct();?>
									<tr>
										<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
										<td style="text-align: right;"><?php echo $product->barcode ;?></td>
										<td><?php echo $product->modelo." ".$product->sex." ".ColorData::getById($product->color_id)->name; ?></td>
										<td style="text-align: right;"><?php $size = Serie_sizeData::getById($operation->size_id); echo $size->size; ?></td>
										<td style="text-align: right;"><?php echo $operation->q ;?></td>
										<td style="text-align: right;"><?php echo $sett->coin." ".number_format($product->price_out, 2, '.', '') ;?></td>
										<td style="text-align: right;"><?php echo $sett->coin." ".number_format($operation->q*$product->price_out, 2, '.', '');$total+=$operation->q*$product->price_out;?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $acumulado = $total+$sell->discount;
				$disc = $sell->discount;
				$total = $sell->total;
				$subtotal = $total/(1+$sett->tax/100);
				$igv = $subtotal*($sett->tax/100); ?>
			<div class="col-md-3">
				<div class="box">
		  			<div class="box-body no-padding">
		  				<div class="box-body">
							<div class="box-body table-responsive">
								<table class="table table-bordered">
									<tr>
										<td>Descuento <?php echo $sett->coin; ?>:</td>
										<td style="text-align: right;"><?php echo number_format($disc, 2, '.', ''); ?></td>
									</tr>
									<tr>
										<td>Subtotal <?php echo $sett->coin; ?>:</td>
										<td style="text-align: right;"><?php echo number_format($subtotal, 2, '.', ''); ?></td>
									</tr>
									<tr>
										<td>IGV(18%) <?php echo $sett->coin; ?>:</td>
										<td style="text-align: right;"><?php echo number_format($igv, 2, '.', ''); ?></td>
									</tr>
									<tr>
										<td>Total a Pagar <?php echo $sett->coin; ?>:</td>
										<td style="text-align: right;"><?php echo number_format($total, 2, '.', ''); ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
			    <div class="col-lg-offset-0 col-lg-10">
				    <div class="1checkbox">
				        <label>
							<div>
								<a name="nueva" id="nueva" href="index.php?view=sell"><input type="button" name="nueva" id="nueva" value="Nueva"></a>
								<a target="_blank" href="ticket.php?id=<?php echo $sell->id; ?>"><input type="button" name="nueva" id="nueva" value="Tck Usb"></a>
								<a target="_blank" href="fact.php?id=<?php echo $sell->id; ?>"><input type="button" name="nueva" id="nueva" value="A4 Usb"></a>
								<input type="button" name="ticket" id="ticket" value="Tck Bth" onClick="sendToQuickPrinterChrome();">
							</div>
				        </label>
				    </div>
			    </div>
		  	</div>
			<?php else:?>
				501 Internal Error
			<?php endif; ?>
			<?php $sett = SettingData::getByAdmin($sell->admin_id);
			$title = $sett->company;
			$address = $sett->address;
			$phone = $sett->phone;
			$image = $sett->image;
			$note = $sett->note;
			$imp = $sett->tax; ?>
			<script>
			function sendToQuickPrinterChrome(){
			    var text = "<big><?php echo $title; ?><br><?php echo $address; ?><br>Cel: <?php echo $phone; ?><br>Cliente: <?php echo $client->name." ".$client->lastname;?><br>RUC/DNI: <?php echo $client->ruc;?><br>Dir: <?php echo $client->address1;?><br>Fecha: <?php echo $sell->created_at;?><br>Cajero: <?php echo $user->name." ".$user->lastname;?><br><DLINE>Can Productos PUni(S/) PTot(S/)<br><?php foreach($operations as $operation){ $product  = $operation->getProduct();?><?php echo $operation->q ;?> <?php echo substr($product->modelo, 0,4)." ".substr($product->sex, 0,4)." ".substr(ColorData::getById($product->color_id)->name, 0,4);?>   <?php echo number_format($product->price_out,2,".",",") ;?>   <?php echo number_format($operation->q*$product->price_out,2,".",",");$total+=$operation->q*$product->price_out;?><br><?php }?><DLINE>Descuento: S/ <?php echo number_format($sell->discount,2,'.',','); ?><br>Subtotal : S/ <?php echo number_format($subt,2,".",","); ?><br>IGV(18%) : S/ <?php echo number_format($igv,2,".",","); ?><br>Total    : S/ <?php echo $total1; ?><br><big>Vuelva Pronto!<br>";

			    var textEncoded = encodeURI(text);
			    window.location.href="intent://"+textEncoded+"#Intent;scheme=quickprinter;package=pe.diegoveloper.printerserverapp;end;";
			    var text = "<br><br><br>";
			    
			}
			</script>
		</div>
	</div>
</section>