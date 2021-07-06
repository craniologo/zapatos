<section class="content">
  <?php $product = Payment_planData::getById($_GET["fact_id"]); ?>
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align: center;">Validación de Seguridad</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="index.php?action=del_confirm">
        <div class="form-group">
          <div class="col-md-12">
            <h1 class="modal-title" style="text-align: center;">Monto a Cobrar: S/<?php echo number_format($product->total,2,".",","); ?></h1>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <input type="password" name="password" required class="form-control" id="password" placeholder="Ingrese la clave de seguridad" required="yes">
          </div>
        </div>
        <input type="view" name="prod_id" class="form-control" id="prod_id" value="<?php echo $_GET["fact_id"]; ?>">
        <input type="view" name="client_id" class="form-control" id="client_id" value="<?php echo $product->client_plan_id; ?>">
        <input type="view" name="user_id" class="form-control" id="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10" style="text-align: center;">
            <button type="submit" class="btn btn-primary">Confirmar Pago</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</section>