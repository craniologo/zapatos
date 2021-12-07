<?php
$u = UserData::getById($_SESSION["user_id"]);
if($u->kind!=1){ Core::redir("./?view=sell"); }
$sett = SettingData::getByAdmin($u->admin_id);

  $dateB = new DateTime(date('Y-m-d')); 
  $dateA = $dateB->sub(DateInterval::createFromDateString('30 days'));
  $sd= strtotime(date_format($dateA,"Y-m-d"));
  $ed = strtotime(date("Y-m-d"));
  $ntot = 0;
  $nsells = 0;
for($i=$sd;$i<=$ed;$i+=(60*60*24)){
  if($u->id==1){
    $operations = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),2);
    $res = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),1);
    $spends = SpendData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i));
  }else{
    $operations = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),2,$u->admin_id);
    $res = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),1,$u->admin_id);
    $spends = SpendData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),$u->admin_id);

  }
  //  echo $operations[0]->t;
  $sr = $res[0]->tot!=null?$res[0]->tot:0;
  $sl = $operations[0]->t!=null?$operations[0]->t:0;
  $sp = $spends[0]->t!=null?$spends[0]->t:0;
  $ntot+=($sl-($sp+$sr));
  $nsells += $operations[0]->c;
} ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;">SISTEMA DE VENTA DE CALZADO</h1>
        <?php if($u->id==1){ ?>
        <h4>Administradores: <?php echo count(UserData::getAllAdmins()); ?></h4>
        <?php } ?>
        <h3>Empresa: <?php echo $sett->company; ?></h3>
        <h4><i class="fa fa-building"></i> Sucursal Principal: <?php echo StockData::getPrincipalByAdmin($u->admin_id)->name;  ?></h4>
        <a href="./?view=product_new" class="btn btn-default">Nuevo Producto</a>
        <a href="./?view=inventary&stock=<?php echo StockData::getPrincipal()->id; ?>" class="btn btn-default">Inventario Principal</a>
        <a href="./?view=spends" class="btn btn-default">Gastos Adicionales</a>
        <a href="./?view=messages&opt=all" class="btn btn-default">Mensajes</a>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-glass"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Productos</span>
          <span class="info-box-number"><?php if($u->id==1) {
            echo count(ProductData::getAll());
          }else{
            echo count(ProductData::getAllByAdmin($u->admin_id));
          } ?>
            </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-male"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Clientes</span>
          <span class="info-box-number"><?php if($u->id==1) {
            echo count(PersonData::getClients());
          }else{
            echo count(PersonData::getClientsByAdmin($u->admin_id));
          } ?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Ventas del mes</span>
          <span class="info-box-number"><?php echo $nsells;?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-area-chart"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Ingresos del Mes</span>
          <span class="info-box-number"><?php echo $sett->coin." ".number_format($ntot,2,".",",");?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <p class="text-center">
                <strong>Balance de los ultimos 30 dias</strong>
              </p>
              <?php 
                $dateB = new DateTime(date('Y-m-d')); 
                $dateA = $dateB->sub(DateInterval::createFromDateString('30 days'));
                $sd= strtotime(date_format($dateA,"Y-m-d"));
                $ed = strtotime(date("Y-m-d"));

              ?>
              <div id="graph" class="animate" data-animate="fadeInUp" ></div>
              <script>

              <?php 
              echo "var c=0;";
              echo "var dates=Array();";
              echo "var data=Array();";
              echo "var total=Array();";
              for($i=$sd;$i<=$ed;$i+=(60*60*24)){
                if($u->id==1){
                  $operations = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),2);
                  $res = SellData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i),1);
                  $spends = SpendData::getGroupByDateOp(date("Y-m-d",$i),date("Y-m-d",$i));
                }else{
                  $operations = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),2,$u->admin_id);
                  $res = SellData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),1,$u->admin_id);
                  $spends = SpendData::getGroupByDateOpByAdmin(date("Y-m-d",$i),date("Y-m-d",$i),$u->admin_id);

                }
              //  echo $operations[0]->t;
                $sr = $res[0]->tot!=null?$res[0]->tot:0;
                $sl = $operations[0]->t!=null?$operations[0]->t:0;
                $sp = $spends[0]->t!=null?$spends[0]->t:0;
                echo "dates[c]=\"".date("Y-m-d",$i)."\";";
                echo "data[c]=".($sl-($sp+$sr)).";";
                echo "total[c]={x: dates[c],y: data[c]};";
                echo "c++;";
              }
              ?>
              // Use Morris.Area instead of Morris.Line
              Morris.Area({
                element: 'graph',
                data: total,
                xkey: 'x',
                ykeys: ['y',],
                labels: ['<?php echo $sett->coin; ?>']
              }).on('click', function(i, row){
                console.log(i, row);
              });
              </script><!-- /.chart-responsive -->
            </div>
          </div><!-- /.row -->
        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>