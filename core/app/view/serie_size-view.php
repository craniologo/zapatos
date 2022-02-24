<section class="content"> <!-- Main content -->
	<?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]); ?>
	<h2><i class="fa fa-list-ol"></i> Lista de Series</h2>
  <ol class="breadcrumb">
    <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><i class="fa fa-list-ul"></i> Catálogos</li>
    <li class="active"><i class="fa fa-list-ol"></i> Lista de Series</li>
  </ol>
	<p>Las Series son grupos de tallas para facilitar la carga de productos (calzados) al sistema, por ejemplo la Serie 1 podría contener las tallas 16, 17, 18, 19 y 20.p>
	<div class="row">
		<div class="col-md-6">
			<div class="clearfix"></div>
        <div class="form-group">
        	<form class="form-horizontal" method="post" name="size_add" id="size_add" action="index.php?action=size_add" role="form">
            <div class="col-md-4">
              <select name="serie_id" id="serie_id" class="form-control" required >
                <option value="">-- SELECCIONAR --</option>
                <?php foreach(Serie_sizeData::getAllSerie() as $ser):?>
                <option value="<?php echo $ser->serie_id;?>"><?php echo "Serie ".$ser->serie_id;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="col-md-4">
	            <input type="text" name="size" class="form-control"  placeholder="Escriba la talla" required="" >
	        	</div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-default"><i class="btn-default"></i> Agregar Talla</button>
            </div>
	        </form>
	    </div>
			<br><br>
			<div class="box">
  			<div class="box-body no-padding">
  				<div class="box-body">
	  				<div class="box-body table-responsive">
							<table class="table table-bordered table-hover">
								<?php $series = Serie_sizeData::getAllSerie(); foreach ($series as $serie) {; ?>
								<tr>
									<th><?php echo "Serie ".$serie->serie_id; ?></th>
									<?php $sizes = Serie_sizeData::getAllSerieAndAdmin($serie->serie_id,$u->admin_id); foreach ($sizes as $size) {; ?>
									<td style="text-align: center;"><?php echo $size->size; ?><a class="btn btn-default btn-xs" onclick="return confirm('¿Está seguro de eliminar?')" href="index.php?action=size_del&id=<?php echo $size->id; ?>">x</a> </td>
									<?php }; ?>
								</tr>
								<?php }; ?>
							</table>
						</div>
					</div>
  			</div><!-- /.box-body -->
			</div><!-- /.box -->
			<p class="alert alert-info">* Antes de eliminar las tallas revisa que no existan productos relacionados</p>
		</div>
	</div>
	<?php endif;?>
</section><!-- /.content -->