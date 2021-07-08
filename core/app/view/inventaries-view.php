<section class="content">
  <?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]); ?>
  <div class="row">
  	<div class="col-md-12"><!-- Single button -->
  		<h2><i class="glyphicon glyphicon-stats"></i> Inventario Global</h2>
        <ol class="breadcrumb">
          <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><i class="fa fa-cube"></i> Stock</li>
          <li class="active"><i class="fa fa-cubes"></i> Inventario Global</li>
        </ol>
      <?php if($u->id==1){
        $products = ProductData::getAll();
        $sucursales = StockData::getAll();
      }else{
        $products = ProductData::getAllByAdmin($u->admin_id);
        $sucursales = StockData::getAllByAdmin($u->admin_id);
      }
      if(count($products)>0){ ?>
      <div class="box">
        <div class="box-body no-padding">
          <div class="box-body">
            <div class="box-body table-responsive">
              <table class="table table-bordered datatable table-hover">
              	<thead>
                  <th style="text-align: center; width: 30px;">N°</th>
              		<th style="text-align: center; width: 100px;">Codigo</th>
              		<th style="text-align: center;">Producto</th>
                  <th style="text-align: center;">Talla</th>
                  <th style="text-align: center;">Total</th>
                  <th style="text-align: center;">Ubicación</th>
                  <?php foreach($sucursales as $suc):?>
              		<th style="text-align: center;"><?php echo $suc->name; ?></th>
                  <?php endforeach; ?>
              	</thead>
              	<?php for($number=0; $number<1; $number++); //variable incremental
                foreach($products as $product):
                $stk_true=OperationData::getQYesF($product->id); ?>
              	<tr>
                  <td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
              		<td style="text-align: right;"><?php echo $product->barcode; ?></td>
              		<td><?php echo $product->modelo; ?></td>
                  <td><?php $size = Serie_sizeData::getById($product->size_id); echo "Talla ".$size->size; ?></td>
                  <td style="text-align: right;"><?php echo $stk_true; ?></td>
                  <td><?php echo $product->ubication; ?></td>
                  <?php foreach($sucursales as $suc):?>
              		<td><?php $q=OperationData::getQByStock($product->id,$suc->id);
                    if($q<0){
                      echo "Se vendió ".$q*(-1)." prod. de Sucursal Principal";
                    }else{
                      echo "Queda ".$q." prod.";
                    }; ?></td>
                  <?php endforeach; ?>
              	</tr>
              	<?php endforeach;?>
              </table>
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    	<?php }else{ ?>
    	<div class="jumbotron">
    		<h2>No hay productos</h2>
    		<p>No se han agregado productos, ve a Catálogos/Productos y luego <b>"Nuevo Producto"</b>.</p>
    	</div>
    	<?php } ?>
      <br>
  	</div>
  </div>
  <?php endif; ?>
</section>