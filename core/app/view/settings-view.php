<section class="content">
  <?php $u=null;
  if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
  $u = UserData::getById($_SESSION["user_id"]); ?>
  <div class="row">
    <div class="col-md-12">
    <h2><i class="fa fa-cogs"></i> Configuración</h2>
      <p>Configure aquí la información de la empresa, esta será visualizada en la parte superior del ticket.</p>
      <ol class="breadcrumb">
        <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><i class="fa fa-cog"></i> Administración</li>
        <li class="active"><i class="fa fa-cogs"></i> Configuración</li>
      </ol>
      <?php if($u->id==1){
        $settings = SettingData::getAll();
      }else{
          $settings = SettingData::getAllByAdmin($u->admin_id);
        }
      if(count($settings)>0){ // si hay usuarios ?>
      <div class="box">
          <div class="box-body no-padding">
            <div class="box-body">
            <div class="box-body table-responsive">
              <table class="table table-bordered <?php if($u->id==1){ echo 'datatable'; } ?> table-hover">
                <thead>
                  <th style="text-align: center; width: 30px;">N°</th>
                  <th style="text-align: center; width: 100px;">Logo</th>
                  <th style="text-align: center;">Nombre</th>
                  <th style="text-align: center;">RUC/Cédula</th>
                  <th style="text-align: center;">Dirección</th>
                  <th style="text-align: center;">Teléfono</th>
                  <th style="text-align: center;">Impuesto</th>
                  <th style="text-align: center;">Moneda</th>
                  <th style="text-align: center;">Nota</th>
                  <?php if ($u->id==1): ?><th style="text-align: center;">Administrador</th><?php endif; ?>
                  <th style="text-align: center; width:80px;">Acción</th>
                </thead>
                <?php for($number=0; $number<1; $number++); //variable incremental
                foreach($settings as $sett){
                  $admin = $sett->getAdmin(); ?>
                <tr>
                  <td style="text-align: center;"><?php echo $number; ?></td> <?php $number++; ?><!--var incremen-->
                  <td style="text-align: center;">
                  <?php if($sett->image!=""){ ?>
                    <img src="storage/settings/<?php echo $sett->image;?>" style="width:150px; height: 50px;" >
                    <?php }else{ ?>
                    <img src="storage/settings/default.jpg" style="width:150px; height: 50px;" >
                    <?php } ?></td>
                  <td><?php echo $sett->company; ?></td>
                  <td style="text-align: right;"><?php echo $sett->ruc; ?></td>
                  <td><?php echo $sett->address; ?></td>
                  <td style="text-align: right;"><?php echo $sett->phone; ?></td>
                  <td style="text-align: right;"><?php echo $sett->tax." %"; ?></td>
                  <td style="text-align: right;"><?php echo $sett->coin; ?></td>
                  <td><?php echo $sett->note; ?></td>
                  <?php if ($u->id==1): ?><td><?php echo $admin->name." ".$admin->lastname; ?></td><?php endif; ?>
                  <td style="text-align: center;">
                    <a href="index.php?view=setting_edit&id=<?php echo $sett->id;?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php }else{
    echo "<p class='alert alert-danger'>No hay configuraciones</p>";
    } ?>
    </div>
  </div>
  <?php endif; ?>
</section>