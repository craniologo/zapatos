<section class="content">
  <?php $product = ProductData::getById($_GET["id"]);
  $brand = BrandData::getById($product->brand_id);
  if($product->sex=="Masculino"){ $sex = '01'; }else{
    $sex = '02';
  }
  $color = ColorData::getById($product->color_id);
  $barco = $brand->id."".$sex."".$color->id; ?>
  <div class="row">
  	<div class="col-md-12">
    	<h2><i class="fa fa-apple"></i> Nuevo Producto</h2>
      <a href="index.php?view=products" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
    	<br><br>
      <div class="form-horizontal" id="size">
        <label for="inputEmail1" class="col-lg-2 control-label">Series/Tallas*</label>
        <div class="col-md-2">
          <select name="serie_id" id="serie_id" class="form-control" required="">
            <option value="">--SELECCIONAR--</option>
            <?php foreach(Serie_sizeData::getAllSerie() as $ser):?>
            <option value="<?php echo $ser->serie_id;?>" <?php if(isset($_GET["serie_id"]) && $_GET["serie_id"]==$ser->serie_id){ echo "selected"; } ?> >Serie <?php echo $ser->serie_id;?></option>
            <?php endforeach;?>
          </select>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function() {
          $('#size').on('change', '#serie_id', function() {
            var selected = $('#serie_id option:selected');
            var value = selected.val();
            var price = selected.data('name');
            var id = '<?php echo $product->id; ?>';
            if(value) {
              $('#result').html(value + ' ' + price);
              location.href="index.php?view=product_edit&id="+id+"&serie_id=" + value;
            }
          })
        })
      </script>
      <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

      <form class="form-horizontal" method="post" enctype="multipart/form-data" name="product_add" id="product_add" action="index.php?action=product_add" role="form">
      <div class="form-group">
        <?php if(isset($_GET["serie_id"]) &&$_GET["serie_id"]!=""):
        $series = Serie_sizeData::getAllSerieId($_GET['serie_id']); ?>
        <div class="col-lg-offset-1 col-lg-10">
          <div class="box">
              <div class="box-body">
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-hover" >
                    <tr>
                      <th style="width: 30px;">Serie&nbsp;<?php echo $_GET["serie_id"]; ?></th>
                      <?php foreach ($series as $serie) { ;?>
                      <td style="text-align: center;"><?php echo "<b>Talla ".$serie->size."</b>"; ?><br><input type="hidden" name="id[]" value="<?php echo $serie->id; ?>" size="1"><input type="text" style="text-align: center;" name="value[]" value="" size="1"><br><a href="barc.php?id=<?php echo $barco."".$serie->size; ?>" class="btn btn-default btn-xs" target="_blank" title="Etiquetas"><i class="fa fa-tags"></i></a>
                      </td><?php } ?>
                    </tr>
                  </table>
                </div>
              </div>
          </div><!-- /.box -->
        </div><?php endif;?>
      </div>
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Imagen (ancho 200px)</label>
        <div class="col-md-6">
          <input type="file" name="image" id="image" onchange="ValidarImagen(this);" placeholder="">
        </div>
      </div>
      <!--<div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Código*</label>
        <div class="col-md-3">
          <input type="text" name="barcode" id="barcode" class="form-control" id="barcode" placeholder="Código de Barras" required="" onkeypress="return validaNumericos(event)">
        </div>
      </div>-->
      <div class="form-group">
        <label for="inputEmail1" class="col-lg-2 control-label">Modelo*</label>
        <div class="col-md-3">
          <input type="text" name="modelo" value="<?php echo $product->modelo; ?>" id="modelo" class="form-control" id="modelo" placeholder="Descripción del producto" required="">
        </div>
        <label for="inputEmail1" class="col-lg-1 control-label">Marca*</label>
        <div class="col-md-3">
          <select name="brand_id" class="form-control">
            <option> -- SELECCIONAR -- </option>
            <?php $brands = BrandData::getAll();
            foreach($brands as $brand):?>
            <option value="<?php echo $brand->id;?>"<?php if($product->brand_id!=null&& $product->brand_id==$brand->id){ echo "selected";}?>><?php echo $brand->name;?></option>
            <?php endforeach;?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Género*</label>
          <div class="col-md-3">
            <select name="sex" class="form-control" required>
              <option value="0"> -- SELECCIONAR -- </option>
              <option value="Masculino" <?php if($product->sex=="Masculino"){echo "selected"; } ?> >Masculino</option>
              <option value="Femenino" <?php if($product->sex=="Femenino"){echo "selected"; } ?> >Femenino</option>
            </select>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Color*</label>
          <div class="col-md-3">
            <select name="color_id" class="form-control">
              <option> -- SELECCIONAR -- </option>
              <?php $cols = ColorData::getAll();
              foreach($cols as $col):?>
              <option value="<?php echo $col->id;?>"<?php if($product->color_id!=null&& $product->color_id==$col->id){ echo "selected";}?>><?php echo $col->name;?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Compra*</label>
          <div class="col-md-3">
            <input type="text" name="price_in" id="price_in" class="form-control" id="price_in" value="<?php echo $product->price_in; ?>" placeholder="Precio de Compra">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Venta*</label>
          <div class="col-md-3">
            <input type="text" name="price_out" id="price_out" class="form-control" id="price_out" value="<?php echo $product->price_out; ?>" placeholder="Precio de Venta">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Mínimo*</label>
          <div class="col-md-3">
            <input type="text" name="stock_min" id="stock_min" class="form-control" id="stock_min" value="<?php echo $product->stock_min; ?>" placeholder="Stock mínimo del producto" required="">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Ubicación</label>
          <div class="col-md-3">
            <input type="text" name="ubication" id="ubication" class="form-control" id="ubication" value="<?php echo $product->ubication; ?>" placeholder="Ubicación del producto" required="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button type="submit" class="btn btn-primary">Agregar Productos</button>
          </div>
        </div>
      </form>
  	</div>
  </div>
</section>

<script type="text/javascript">
  function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;
}
</script>

<script>
function ValidarImagen(obj){
  var uploadFile = obj.files[0];

  if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
      alert('El archivo cagrado no es una imagen');
      location.reload();
  }else{
          alert('Imagen correcta :)')
      img.src = URL.createObjectURL(uploadFile);
    }
  }
</script>

<div class="modal fade" id="brand_new"><!--Inicio de ventana modal 2-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <center><h4 class="modal-title">Ingrese el Nueva Marca</h4></center>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" method="post" id="" action="index.php?action=brand_add_prod" role="form">
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Marca*</label>
                <div class="col-md-9">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Ingrese la marca" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-primary">Agregar Marca</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div><!--Fin de ventana modal 2-->

<div class="modal fade" id="color_new"><!--Inicio de ventana modal 2-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <center><h4 class="modal-title">Ingrese el Nuevo Color</h4></center>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" method="post" id="" action="index.php?action=color_add_prod" role="form">
              <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Color*</label>
                <div class="col-md-9">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Ingrese el color" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-primary">Agregar Color</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
    </div><!--Fin de ventana modal 2-->