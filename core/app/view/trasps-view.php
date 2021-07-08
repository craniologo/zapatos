<section class="content"> 
	<div class="row">
		<div class="col-md-12">
			<h2><i class='fa fa-exchange'></i> Lista de Traspasos</h2>
	        <ol class="breadcrumb">
	          <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
	          <li><i class="fa fa-cube"></i> Stock</li>
	          <li class="active"><i class="fa fa-exchange"></i> Traspasos</li>
	        </ol>
			<a href="index.php?view=traspase" class="btn btn-default"><i class='fa fa fa-exchange'></i> Nuevo Traspaso</a>
			<br><br>
			<?php $products = null;
			if(isset($_SESSION["user_id"])){
				$users = UserData::getById($_SESSION["user_id"]);
			if($users->kind==2){
			$products = SellData::getAllBySQL(" where user_id=$users->id and operation_type_id=6 and is_draft=0 order by created_at desc");
			}else{
			$products = SellData::getAllBySQL(" where operation_type_id=6");
			}
			}else if(isset($_SESSION["client_id"])){
			$products = SellData::getAllBySQL(" where person_id=$_SESSION[client_id] and operation_type_id=6 and is_draft=0 order by created_at desc");	
			}
			if(count($products)>0){ ?>
			<div class="box">
				<div class="box-body no-padding">
					<div class="box-body">
						<div class="box-body table-responsive">
							<table class="table table-bordered table-hover table-responsive datatable	">
								<thead>
									<th style="text-align: center; width:30px;">N°</th>
									<th style="text-align: center; width: 30px;">Operación</th>	
									<th style="text-align: center;">Total</th>
									<th style="text-align: center;">Usuario</th>
									<th style="text-align: center;">Origen </th>
									<th style="text-align: center;">Destino </th>
									<th style="text-align: center;">Fecha</th>
									<th style="text-align: center; width:130px;">Acción</th>
								</thead>
								<?php for($number=0; $number<1; $number++); //variable incremental
								foreach($products as $sell):
								$operations = OperationData::getAllProductsBySellId($sell->id); ?>
								<tr>
									<td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
									<td style="text-align: right;"><a href="index.php?view=onetraspase&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-default"><?php echo $sell->ref_id; ?></a></td>
									<td style="text-align: right;"><?php $total= $sell->total-$sell->discount; echo "<b>S/ ".number_format($total,2,".",",")."</b>"; ?></td>
									<td> <?php if($sell->user_id!=null){$c= $sell->getUser();echo $c->name." ".$c->lastname;} ?> </td>
									<td><?php echo $sell->getStockFrom()->name; ?></td>
									<td><?php echo $sell->getStockTo()->name; ?></td>
									<td style="text-align: center;"><?php echo $sell->created_at; ?></td>
									<td style="text-align: center;"><?php if(isset($_SESSION["user_id"])):?>
									<a href="index.php?action=traspase_del&id=<?php echo $sell->id; ?>" onclick="return confirm('¿Está seguro de eliminar?')"  class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a><?php endif;?></td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php }else{ ?>
			<div class="jumbotron">
				<h2>No hay Traspasos</h2>
				<p>No se ha realizado ninguna devolucion.</p>
			</div>
			<?php } ?>
		</div>
	</div>
</section>