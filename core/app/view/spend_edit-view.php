<section class="content">
  <?php $spend = SpendData::getById($_GET["id"]);?>
  <div class="row">
    <div class="col-md-12">
     <h2><i class="fa fa-coffee"></i> Editar Gasto</h2>
     <a href="index.php?view=spends" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
     <br><br>
      <form class="form-horizontal" method="post" id="addproduct" action="index.php?action=spend_update" role="form">
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Concepto*</label>
          <div class="col-md-3">
            <textarea type="text" name="name" value="" class="form-control" id="name" placeholder="Concepto"><?php echo $spend->name;?></textarea>
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Costo*</label>
          <div class="col-md-2">
            <input type="text" name="price" value="<?php echo number_format($spend->price,2,".",".");?>" class="form-control" id="name" placeholder="Costo">
          </div>
          <label for="inputEmail1" class="col-lg-1 control-label">Fecha</label>
          <div class="col-md-2">
            <input type="date" name="created_at" value="<?php echo substr($spend->created_at, 0,10);?>" class="form-control" placeholder="Fecha">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
          <input type="hidden" name="spend_id" value="<?php echo $spend->id;?>">
            <button type="submit" class="btn btn-primary">Actualizar Gasto</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>