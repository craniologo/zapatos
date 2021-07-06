<section class="content">
	<div class="row">
		<?php $clients = UserData::getUsers(); ?>
		<div class="col-md-12">
			<h2>Reportes de Ventas por Usuario</h2>
			<form>
				<input type="hidden" name="view" value="sell_user">
				<div class="row">
					<div class="col-md-3">
						<select name="client_id" class="form-control">
							<option value="">--  TODOS --</option>
							<?php foreach($clients as $p):?>
							<option value="<?php echo $p->id;?>"><?php echo $p->name." ".$p->lastname;?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-3"><input type="date" name="sd" value="<?php if(isset($_GET["sd"])){ echo $_GET["sd"]; }?>" class="form-control"></div>
					<div class="col-md-3"><input type="date" name="ed" value="<?php if(isset($_GET["ed"])){ echo $_GET["ed"]; }?>" class="form-control"></div>
					<div class="col-md-3"><input type="submit" class="btn btn-success btn-block" value="Procesar"></div>
				</div>
			</form>
		</div>
	</div>
	<br><!--- -->
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($_GET["sd"]) && isset($_GET["ed"]) ):?>
			<?php if($_GET["sd"]!=""&&$_GET["ed"]!=""):?>
			<?php 
			$operations = array();
			if($_GET["client_id"]==""){
			$operations = SellData::getAllByDateOp($_GET["sd"],$_GET["ed"],2);
			}
			else{
			$operations = SellData::getAllByDateOpUs($_GET["client_id"],$_GET["sd"],$_GET["ed"],2);
			} ?>
			<?php if(count($operations)>0):?>
			<?php $supertotal = 0; ?>
			<div class="box">
				<div class="box-body no-padding">
					<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered datatable table-hover">
								<thead>
									<th style="text-align: center; width: 30px;">N°</th>
									<th style="text-align: center;">Subtotal</th>
									<th style="text-align: center;">Descuento</th>
									<th style="text-align: center;">Total</th>
									<th style="text-align: center;">Fecha</th>
								</thead>
								<?php for($number = count($operations); $number>count($operations); $number--); //variable decremental
								foreach($operations as $operation):?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number--; ?><!--var decremental-->
									<td style="text-align: right;">S/. <?php echo number_format($operation->total,2,'.',','); ?></td>
									<td style="text-align: right;">S/. <?php echo number_format($operation->discount,2,'.',','); ?></td>
									<td style="text-align: right;">S/. <?php echo number_format($operation->total-$operation->discount,2,'.',','); ?></td>
									<td style="text-align: center;"><?php echo $operation->created_at; ?></td>
								</tr>
								<?php
								$supertotal+= ($operation->total-$operation->discount);
							 	endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<h2>Total de ventas: S/. <?php echo number_format($supertotal,2,'.',','); ?></h2>
			<?php else:
			// si no hay operaciones
			?>
			<script>
				$("#wellcome").hide();
			</script>
			<div class="jumbotron">
				<h2>No hay operaciones</h2>
				<p>El rango de fechas seleccionado no proporciono ningun resultado de operaciones.</p>
			</div>
			<?php endif; ?>
			<?php else:?>
			<script>
				$("#wellcome").hide();
			</script>
			<div class="jumbotron">
				<h2>Fecha Incorrectas</h2>
				<p>Puede ser que no selecciono un rango de fechas, o el rango seleccionado es incorrecto.</p>
			</div>
			<?php endif;?>
			<?php endif; ?>
		</div>
	</div>
</section>