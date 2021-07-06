<section class="content">
  <h2><i class="fa fa-exchange"></i> Resumen de Traspaso</h2>
  <a href="index.php?view=trasps" class="btn btn-default"><i class="fa fa-arrow-left"></i> Traspasos</a>
  <br><br>
  <?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
  <?php $sell = SellData::getById($_GET["id"]);
  $operations = OperationData::getAllProductsBySellId($_GET["id"]);
  $total = 0; ?>
  <?php if(isset($_COOKIE["selled"])){
  	foreach ($operations as $operation) {
      //print_r($operation);
      if($operation->operation_type_id==2){
    		$qx = OperationData::getQByStock($operation->product_id,StockData::getPrincipal()->id);
    		// print "qx=$qx";
    			$p = $operation->getProduct();
    		if($qx==0){
    			echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->modelo</b> no tiene existencias en inventario.</p>";			
    		}else if($qx<=$p->stock_min/2){
    			echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->modelo</b> tiene muy pocas existencias en inventario.</p>";
    		}else if($qx<=$p->stock_min){
    			echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->modelo</b> tiene pocas existencias en inventario.</p>";
    		}
      }
  	}
  	setcookie("selled","",time()-18600);
  } ?>
  <div class="box" style="width: 300px;">
    <div class="box-body no-padding">
      <div class="box-body">
        <div class="box-body table-responsive" >
          <table class="table table-bordered">
            <?php if($sell->user_id!=""):
            $user = $sell->getUser(); ?>
            <tr>
              <td style="width:150px";>Documento N°: </td>
              <td style="width: 200px;"><?php echo $sell->ref_id; ?></td>
            </tr>
            <tr>
              <td>Origen: </td>
              <td><?php echo StockData::getById($sell->stock_from_id)->name; ?></td>
            </tr>
            <tr>
              <td>Destino: </td>
              <td><?php echo StockData::getById($sell->stock_to_id)->name; ?></td>
            </tr>
            <tr>
            	<td>Atendido por: </td>
            	<td><?php echo $user->name." ".$user->lastname;?></td>
            </tr>
            <?php endif; ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="box">
    <div class="box-header">
      <div class="box-body no-padding">
        <div class="box-body">
          <div class="box-body table-responsive">
            <table class="table table-bordered table-hover">
            	<thead>
                <th style="text-align: center; width: 30px;">N°</th>
            		<th style="text-align: center;">Código</th>
            		<th style="text-align: center;">Nombre del Producto</th>
                <th style="text-align: center;">Talla</th>
                <th style="text-align: center;">Cant</th>
            		<th style="text-align: center;">Precio Unitario</th>
            		<th style="text-align: center;">Total</th>
            	</thead>
              <?php for($number=0; $number<1; $number++); //variable incremental
              foreach($operations as $operation){
            	$product  = $operation->getProduct(); ?>
              <tr>
                <?php if($operation->operation_type_id==2):?>
                <td style="text-align: center;"><?php echo $number; ?></td> <?php $number--; ?><!--var decremental-->
              	<td style="text-align: right;"><?php echo $product->barcode;?></td>
              	<td><?php echo $product->modelo;?></td>
                <td style="text-align: center;"><?php $size = Serie_sizeData::getById($product->size_id); echo $size->size; ?></td>
                <td style="text-align: center;"><?php echo $operation->q ;?></td>
              	<td style="text-align: right;">S/ <?php echo number_format($operation->price_out,2,".",",") ;?></td>
              	<td style="text-align: right;"><b>S/ <?php echo number_format($operation->q*$operation->price_out,2,".",",");$total+=$operation->q*$operation->price_out;?></b></td>
                <?php endif; ?>
              </tr>
              <?php } ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br><br>
  <div class="row">
    <div class="col-md-4">
      <div class="box box-primary">
        <table class="table table-bordered">
        	<tr>
        		<td><h4>Total:</h4></td>
        		<td><h4>S/ <?php echo number_format($total,2,'.',','); ?></h4></td>
        	</tr>
        </table>
      </div>
    </div>
  </div>
  <?php else:?>
	501 Internal Error
  <?php endif; ?>
</section>