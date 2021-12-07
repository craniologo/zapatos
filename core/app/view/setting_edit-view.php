<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h2><i class="fa fa-cog"></i> Editar Configuración</h2>
      <a href="index.php?view=settings" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
      <br><br>
      <?php $config = SettingData::getById($_GET["id"]); ?>
      <form class="form-horizontal" method="post" id="setting_update" action="index.php?action=setting_update" role="form" enctype="multipart/form-data">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Logo JPG(300x150px)</label>
          <div class="col-md-6">
              <input type="file" name="image" id="image" placeholder="">
              <br>
              <?php if($config->image!=""){ ?>
              <img src="storage/settings/<?php echo $config->image;?>" class="img-responsive" style="width: 200px; height: 50px; ">
              <?php }else{ ?>
              <img src="storage/settings/default.jpg" class="img-responsive" style="width: 200px; height: 50px; ">
            <?php } ?>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Empresa*</label>
          <div class="col-md-3">
            <input type="text" name="company" class="form-control" id="company" value="<?php echo $config->company; ?>" placeholder="Codigo del Producto">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">RUC*</label>
          <div class="col-md-3">
            <input type="text" name="ruc" class="form-control" id="ruc" value="<?php echo $config->ruc; ?>" placeholder="Nombre del Producto" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Dirección*</label>
          <div class="col-md-3">
            <input type="text" name="address" class="form-control" id="address" value="<?php echo $config->address; ?>" placeholder="Dirección" required>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Telefono*</label>
          <div class="col-md-3">
            <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $config->phone; ?>" placeholder="Teléfono" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Impuesto (%)*</label>
          <div class="col-md-3">
            <input type="text" name="tax" class="form-control" id="tax" value="<?php echo $config->tax; ?>" placeholder="Porcentaje de impuesto" required>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Moneda*</label>
          <div class="col-md-3">
            <input type="text" name="coin" class="form-control" id="coin" value="<?php echo $config->coin; ?>" placeholder="Deominación de moneda" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Nota del Documento</label>
          <div class="col-md-7">
            <textarea type="text" name="note" class="form-control" id="note" value="" placeholder="Descripción de la nota" required><?php echo $config->note; ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-7">
            <p class="alert alert-info">* Campos obligatorios</p>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-9">
          <input type="hidden" name="config_id" value="<?php echo $config->id; ?>">
            <button type="submit" class="btn  btn-success">Actualizar Configuración</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>