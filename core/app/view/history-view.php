<section class="content">
	<a href="index.php?view=inventary" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
		<br><br>
	<div class="row">
		<?php if(isset($_GET["product_id"])):
			$product = ProductData::getById($_GET["product_id"]);
			$operations = OperationData::getAllByProductId($product->id); ?>
	</div>
	<div class="row">
		<div class="col-md-4"><?php $itotal = OperationData::GetInputQYesF($product->id); ?>
			<div class="jumbotron"><center><h2>Entradas</h2><h1><?php echo $itotal; ?></h1></center></div>
			<br>
			<?php ?>
		</div>
		<div class="col-md-4"><?php $ototal = -1*OperationData::GetOutputQYesF($product->id); ?>
			<div class="jumbotron"><center><h2>Salidas</h2><h1><?php echo $ototal; ?></h1></center></div>
			<div class="clearfix"></div>
			<br>
			<?php ?>
		</div>
		<div class="col-md-4"><?php $total = OperationData::GetQYesF($product->id); ?>
			<div class="jumbotron"><center><h2>Disponibles</h2><h1><?php echo $total; ?></h1></center></div>
			<div class="clearfix"></div>
			<br>
			<?php ?>
		</div>
	</div>
	<?php if(count($operations)>0):?>
	<div class="box">
	  	<div class="box-body no-padding">
	  		<div class="box-body">
				<div class="box-body table-responsive">
					<table class="table table-bordered datatable table-hover">
						<thead>
							<th style="text-align: center; width: 30px;">N°</th>
							<th style="text-align: center;">Cantidad</th>
							<th style="text-align: center;">Tipo</th>
							<th style="text-align: center;">Fecha</th>
							<th style="text-align: center;"></th>
						</thead>
						<?php for($number=0; $number<1; $number++); //variable incremental
						foreach($operations as $operation):?>
						<tr>
							<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
							<td style="text-align: center;"><?php echo $operation->q; ?></td>
							<td style="text-align: center;"><?php echo $operation->getOperationType()->name; ?></td>
							<td style="text-align: center;"><?php echo $operation->created_at; ?></td>
							<td style="width:40px;"><a href="#" id="oper-<?php echo $operation->id; ?>" onclick="return confirm('¿Está seguro de eliminar?')" class="btn tip btn-xs btn-danger" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a> </td>
							<script>
							$("#oper-"+<?php echo $operation->id; ?>).click(function(){
								x = confirm("Estas seguro que quieres eliminar esto ??");
								if(x==true){
									window.location = "index.php?view=deleteoperation&ref=history&pid=<?php echo $operation->product_id;?>&opid=<?php echo $operation->id;?>";
								}
							});
							</script>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>