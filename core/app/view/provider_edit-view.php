<section class="content">
  <div class="row">
    <?php $user = PersonData::getById($_GET["id"]);?>
  	<div class="col-md-12">
    	<h2><i class="fa fa-truck"></i> Editar Proveedor</h2>
    	<a href="index.php?view=providers" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
      <br><br>
    	<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=provider_update" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
          <div class="col-md-3">
            <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Apellido*</label>
          <div class="col-md-3">
            <input type="text" name="lastname" value="<?php echo $user->lastname;?>" required class="form-control" id="lastname" placeholder="Apellidos">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">RUC/DNI</label>
          <div class="col-md-3">
            <input type="text" name="ruc" value="<?php echo $user->ruc;?>" class="form-control" id="ruc" placeholder="RUC/DNI">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Direccion*</label>
          <div class="col-md-3">
            <input type="text" name="address" value="<?php echo $user->address;?>" class="form-control" required id="username" placeholder="Direccion">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Correo*</label>
          <div class="col-md-3">
            <input type="text" name="email" value="<?php echo $user->email;?>" class="form-control" id="email" placeholder="Correo Electrónico">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Telefono</label>
          <div class="col-md-3">
            <input type="text" name="phone"  value="<?php echo $user->phone;?>"  class="form-control" id="inputEmail1" placeholder="Número de telefono">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-7">
            <p class="alert alert-info">* Campos obligatorios</p>
          </div>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-7">
            <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
          </div>
        </div>
      </form>
  	</div>
  </div>
</section>