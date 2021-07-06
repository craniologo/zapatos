<section class="content">
  <?php if ($_GET["kind"]==1) {
    $user = "Administrador";
  }else{
    $user = "Ejecutivo";
  } ?>
  <div class="row">
  	<div class="col-md-12">
  	<h2><i class="fa fa-user"></i> Agregar <?php echo $user; ?></h2>
  	  <a href="index.php?view=users" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
        <br><br>
  		<form class="form-horizontal" enctype="multipart/form-data"  method="post" id="addproduct" action="index.php?action=user_add" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Imagen (160x160)</label>
          <div class="col-md-6">
            <input type="file" name="image" id="image" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
          <div class="col-md-3">
            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Apellidos*</label>
          <div class="col-md-3">
            <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellidos">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Usuario*</label>
          <div class="col-md-3">
            <input type="text" name="username" class="form-control" required id="username" placeholder="Nombre de usuario">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Email*</label>
          <div class="col-md-3">
            <input type="text" name="email" class="form-control" id="email" placeholder="Correo Electrónico">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
          <div class="col-md-3">
            <input type="password" name="password" class="form-control" required id="inputEmail1" placeholder="Contrase&ntilde;a">
          </div>
          <?php if(isset($_GET["kind"]) &&$_GET["kind"]=="2" || $_GET["kind"]=="3"){ ?>
          <label for="inputEmail1" class="col-lg-1 control-label">Sucursal</label>
          <div class="col-md-3">
            <select name="stock_id" class="form-control" required>
              <option value="">-- NINGUNO --</option>
              <?php foreach(StockData::getAll() as $stock):?>
              <option value="<?php echo $stock->id;?>"><?php echo $stock->name;?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
        <?php }else{ echo '</div>'; } ?>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-7">
            <p class="alert alert-info">* Campos obligatorios</p>
          </div>
        </div>        
        <input type="hidden" name="kind" value="<?php echo $_GET["kind"];?>">
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-7">
            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
          </div>
        </div>
      </form>
  	</div>
  </div>
</section>