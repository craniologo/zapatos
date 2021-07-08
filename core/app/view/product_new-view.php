<section class="content">
  <?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]); ?>
  <div class="row">
  	<div class="col-md-12">
    	<h2><i class="fa fa-apple"></i> Nuevo Producto</h2>
      <a href="index.php?view=products" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
    	<br><br>
      <div class="form-horizontal" id="size">
        <label for="inputEmail1" class="col-lg-2 control-label">Series/Tallas*</label>
        <div class="col-md-2">
          <select name="serie_id" id="serie_id" class="form-control" required>
            <option value="">-- SELECCIONAR --</option>
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
            if(value) {
              $('#result').html(value + ' ' + price);
              location.href="index.php?view=product_new&serie_id=" + value;
            }
          })
        })
      </script>
      <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

      <form class="form-horizontal" method="post" enctype="multipart/form-data" name="product_add" id="product_add" action="index.php?action=product_add" role="form">
        <div class="form-group">
          <?php if(isset($_GET["serie_id"]) &&$_GET["serie_id"]!=""):
          $series = Serie_sizeData::getAllSerieAndAdmin($_GET['serie_id'],$u->admin_id); ?>
          <div class="col-lg-offset-1 col-lg-10">
            <div class="box">
                <div class="box-body">
                  <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover" >
                      <tr>
                        <th style="width: 30px;">Serie&nbsp;<?php echo $_GET["serie_id"]; ?></th>
                        <?php foreach ($series as $serie) { ;?>
                        <td style="text-align: center;"><?php echo "<b>Talla ".$serie->size."</b>"; ?><br><input type="hidden" name="id[]" value="<?php echo $serie->id; ?>" size="1"><input type="text" style="text-align: center;" name="value[]" value="" size="2">
                        </td><?php } ?>
                      </tr>
                    </table>
                  </div>
                </div>
            </div><!-- /.box -->
          </div><?php endif;?>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Foto JPG (400x400px)</label>
          <div class="col-md-6">
            <input type="file" name="image" id="image" onchange="ValidarImagen(this);" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Modelo*</label>
          <div class="col-md-3">
            <input type="text" name="modelo" id="modelo" class="form-control" id="modelo" placeholder="Descripción del producto" required="">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Marca*</label>
          <div class="col-md-3">
            <div class="col-md-8">
              <select name="brand_id" class="form-control" required>
                <option> -- SELECCIONAR -- </option>
                <?php $brands = BrandData::getAllByAdmin($u->admin_id);
                foreach($brands as $brand):?>
                <option value="<?php echo $brand->id;?>"><?php echo $brand->name;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="col-md-1">
              <a href="#brand_new" class="btn btn-default" data-toggle="modal"><i class='fa fa-tag'></i> Nueva Marca</a>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Género*</label>
          <div class="col-md-3">
            <select name="sex" class="form-control" required>
              <option value="0"> -- SELECCIONAR -- </option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
            </select>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Color*</label>
          <div class="col-md-3">
            <div class="col-md-8">
              <select name="color_id" class="form-control" required>
                <option> -- SELECCIONAR -- </option>
                <?php $cols = ColorData::getAllByAdmin($u->admin_id);
                foreach($cols as $col):?>
                <option value="<?php echo $col->id;?>"><?php echo $col->name;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="col-md-1">
              <a href="#color_new" class="btn btn-default" data-toggle="modal"><i class='fa fa-tint'></i> Nuevo Color</a>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Compra*</label>
          <div class="col-md-3">
            <input type="text" name="price_in" id="price_in" class="form-control" id="price_in" placeholder="Precio de compra" required="">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Venta*</label>
          <div class="col-md-3">
            <input type="text" name="price_out" id="price_out" class="form-control" id="price_out" placeholder="Precio de Venta" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Mínimo*</label>
          <div class="col-md-3">
            <input type="text" name="stock_min" id="stock_min" class="form-control" id="stock_min" placeholder="Stock mínimo para alertar" required="" >
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Ubicación</label>
          <div class="col-md-3">
            <input type="text" name="ubication" id="ubication" class="form-control" id="ubication" placeholder="Ubicación física del producto" required="">
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
  <?php endif; ?>
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