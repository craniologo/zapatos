<section class="content">
  <?php $stock = StockData::getById($_GET["id"]); ?>
  <div class="row">
    <div class="col-md-12">
      <h2><i class="fa fa-building"></i> Editar Sucursal</h2>
      <a href="index.php?view=stocks" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
      <br><br>
      <div class="box box-primary">
        <table class="table">
          <tr><td>
          <form class="form-horizontal" method="post" id="addcategory" action="index.php?action=stock_update" role="form">
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
              <div class="col-md-3">
                <input type="text" name="name" required class="form-control" value="<?php echo $stock->name; ?>" id="name" placeholder="Nombre">
                <input type="hidden" name="id" value="<?php echo $stock->id; ?>">
              </div>
              <label for="inputEmail1" class="col-lg-1 control-label">Direccion*</label>
              <div class="col-md-3">
                <input type="text" name="address"  class="form-control" value="<?php echo $stock->address; ?>" id="name" placeholder="Direccion">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
              <div class="col-md-3">
                <input type="text" name="phone"  class="form-control" value="<?php echo $stock->phone; ?>" id="name" placeholder="Telefono">
              </div>
              <label for="inputEmail1" class="col-lg-1 control-label">Email*</label>
              <div class="col-md-3">
                <input type="text" name="email"  class="form-control" value="<?php echo $stock->email; ?>" id="name" placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-success">Actualizar Sucursal</button>
              </div>
            </div>
          </form>
          </td></tr>
        </table>
      </div>
    </div>
  </div>
</section>