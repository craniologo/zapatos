<section class="content">
  <div class="row">
    <?php $product = MaterialData::getById($_GET["id"]);
    if($product!=null): ?>
    <div class="col-md-8">
      <h2>Editar Material <?php echo $product->name; ?></h2>
      <?php if(isset($_COOKIE["prdupd"])):?>
        <p class="alert alert-info">La informacion del producto se ha actualizado exitosamente.</p>
      <?php setcookie("prdupd","",time()-18600); endif; ?>
      <a href="index.php?view=details" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
      <br><br>
      <form class="form-horizontal" method="post" id="" action="index.php?action=material_update" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-3 control-label">Modelo*</label>
          <div class="col-md-8">
            <input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Material">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-3 col-lg-8">
          <input type="hidden" name="id" value="<?php echo $product->id; ?>">
            <button type="submit" class="btn btn-success">Actualizar Material</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>
</section>