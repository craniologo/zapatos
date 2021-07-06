<section class="content">
  <?php $product = ProductData::getById($_GET["id"]);
  $brand = BrandData::getById($product->brand_id);
  if($product->sex=="Masculino"){ $sex = '01'; }else{
    $sex = '02';
  }
  $color = ColorData::getById($product->color_id);
  $s_size = Serie_sizeData::getById($product->size_id);
  $barco = $product->id."".$brand->id."".$sex."".$color->id."".$s_size->id; ?>
  <div class="row">
    <div class="col-md-12">
      <h2><i class="fa fa-apple"></i> Editar Producto</h2>
      <a href="index.php?view=products" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
      <br><br>
      <form class="form-horizontal" method="post" enctype="multipart/form-data" name="product_update_barcode" id="product_update_barcode" action="index.php?action=product_update" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Imagen (ancho 200px)</label>
          <div class="col-md-3">
            <input type="file" name="image" id="name" onchange="ValidarImagen(this);" placeholder="">
            <?php if($product->image!=""):?>
            <br>
              <img src="storage/products/<?php echo $product->image;?>" class="img-responsive" style="width: 200px; height: 200px; border-radius: 100px;">
            <?php endif;?>
          </div>
          <label for="inputEmail1" class="col-lg-2 control-label">Código de Barras</label>
          <div class="col-md-3">
            <br>
              <img src="storage/codigos/<?php echo $barco.".png";?>" class="img-responsive" style="width: 200px; height: 200px;">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Código*</label>
          <div class="col-md-3">
            <input type="text" name="barcode" id="barcode" class="form-control" id="barcode" value="<?php echo $product->barcode; ?>" placeholder="Código de Barras" >
          </div>
        </div>
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
         <label for="inputEmail1" class="col-lg-2 control-label">Serie*</label>
          <div class="col-md-3">
            <input type="text" name="" id="" class="form-control" id="" value="<?php $series = Serie_sizeData::getById($product->size_id); echo $series->serie_id; ?>" placeholder="Serie" readonly>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Talla*</label>
          <div class="col-md-1">
            <input type="text" name="size_id" id="size_id" class="form-control" id="size_id" value="<?php $series = Serie_sizeData::getById($product->size_id); echo $series->size; ?>" placeholder="Talla" readonly>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Cantidad*</label>
          <div class="col-md-1">
            <input type="text" name="qty" id="qty" class="form-control" id="qty" value="<?php echo $product->qty; ?>" placeholder="Cantidad" >
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
        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

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