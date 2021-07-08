<section class="content">
	<?php $u=null;
	if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
	$u = UserData::getById($_SESSION["user_id"]); ?>
	<?php $clients = PersonData::getClients(); ?>
	<div class="row">
		<div class="col-md-12">
			<h2><i class="fa fa-area-chart"></i> Balance (Ventas - Gastos = Ganancia)</h2>
			<p>El Balance es el resultado de las operaciones de ingreso por Ventas menos los egresos por Compras y gastos.</p>
		    <ol class="breadcrumb">
		      <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
		      <li><i class="fa fa-money"></i> Finanzas</li>
		      <li class="active"><i class="fa fa-area-chart"></i> Balance</li>
		    </ol>
			<form>
				<input type="hidden" name="view" value="balance">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-3">
						<input type="date" name="sd" value="<?php if(isset($_GET["sd"])){ echo $_GET["sd"]; }?>" class="form-control">
					</div>
					<div class="col-md-3">
						<input type="date" name="ed" value="<?php if(isset($_GET["ed"])){ echo $_GET["ed"]; }?>" class="form-control">
					</div>
					<div class="col-md-2">
						<input type="submit" class="btn btn-success btn-block" value="Procesar">
					</div>
				</div>
			</form>
		</div>
	</div>
	<br><!--- -->
	<div class="row">	
		<div class="col-md-12">
			<?php if(isset($_GET["sd"]) && isset($_GET["ed"]) ):?>
			<?php if($_GET["sd"]!=""&&$_GET["ed"]!=""):
			$sd = strtotime($_GET["sd"]);
			$ed = strtotime($_GET["ed"]); ?>
			<div class="box box-primary">
				<div id="graph" class="animate" data-animate="fadeInUp" ></div>
			</div>
			<script>

			<?php 
			echo "var c=0;";
			echo "var dates=Array();";
			echo "var data=Array();";
			echo "var total=Array();";
			for($i=$sd;$i<=$ed;$i+=(60*60*24)){
				if($u->id==1){
				  $operations = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),2);
				  $res = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),1);
				  $spends = SpendData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i));
				}else{
					$operations = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),2,$u->admin_id);
				  $res = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),1,$u->admin_id);
				  $spends = SpendData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),$u->admin_id);
				}
			//  echo $operations[0]->t;
			  $sr = $res[0]->tot!=null?$res[0]->tot:0;
			  $sl = $operations[0]->t!=null?$operations[0]->t:0;
			  $sp = $spends[0]->t!=null?$spends[0]->t:0;
			  echo "dates[c]=\"".date("Y-m-d",$i)."\";";
			  echo "data[c]=".($sl-($sp+$sr)).";";
			  echo "total[c]={x: dates[c],y: data[c]};";
			  echo "c++;";
			}
			?>
			// Use Morris.Area instead of Morris.Line
			Morris.Area({
			  element: 'graph',
			  data: total,
			  xkey: 'x',
			  ykeys: ['y',],
			  labels: ['Y']
			}).on('click', function(i, row){
			  console.log(i, row);
			});
			</script>
			<div class="box box-primary">
				<table class="table table-bordered">
					<thead>
						<th style="text-align: center;">Fecha</th>
						<th style="text-align: center;">Ventas</th>
						<th style="text-align: center;">Abastecimientos</th>
						<th style="text-align: center;">Gastos</th>
						<th style="text-align: center;">Ganancia</th>
					</thead>
					<?php $restotal=0;
					$selltotal = 0;
					$spendtotal = 0;
					for($i=$sd;$i<=$ed;$i+=(60*60*24)):
				if($u->id==1){
				  $operations = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),2);
				  $res = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),1);
				  $spends = SpendData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i));
				}else{
					$operations = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),2,$u->admin_id);
				  $res = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),1,$u->admin_id);
				  $spends = SpendData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),$u->admin_id);
				} ?>
					<?php if(count($operations)>0):?>
					<?php // foreach($operations as $operation):?>
					<tr>
						<td><b><?php echo date("Y-m-d",$i); ?></b></td>
						<td style="text-align: right;">S/ <?php echo number_format($operations[0]->t,2,'.',','); ?></td>
						<td style="text-align: right;">S/ <?php echo number_format($res[0]->tot,2,'.',','); ?></td>
						<td style="text-align: right;">S/ <?php echo number_format($spends[0]->t,2,'.',','); ?></td>
						<td style="text-align: right;">S/ <?php echo number_format($operations[0]->t-($spends[0]->t+$res[0]->tot),2,'.',','); ?></td>
					</tr>
					<?php $restotal+= ($res[0]->tot);
					$selltotal+= ($operations[0]->t);
					$spendtotal+= ($spends[0]->t);
					// endforeach; ?>
					<?php else: ?>
					<div class="jumbotron">
						<h2>No hay operaciones</h2>
						<p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
					</div>
					<?php endif; ?>
					<?php endfor;?>
					<tr>
						<td><b>Total</b></td>
						<td style="text-align: right;"><b>S/ <?php echo number_format($selltotal,2,'.',','); ?></b></td>
						<td style="text-align: right;"><b>S/ <?php echo number_format($restotal,2,'.',','); ?></b></td>
						<td style="text-align: right;"><b>S/ <?php echo number_format($spendtotal,2,'.',','); ?></b></td>
						<td style="text-align: right;"><b>S/ <?php echo number_format($selltotal-($spendtotal+$restotal),2,'.',','); ?></b></td>
					</tr>
				</table>
			</div>
			<?php else:?>
			<div class="jumbotron">
				<h3>Fecha Incorrectas</h3>
				<p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
			</div>
			<?php endif;?>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
</section>