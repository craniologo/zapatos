<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>SAVI | EXITO</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="plugins/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/dist/css/skins/skin-blue-light.min.css" rel="stylesheet" type="text/css" />
    <script src="plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="plugins/morris/raphael-min.js"></script>
    <script src="plugins/morris/morris.js"></script>
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <link rel="stylesheet" href="plugins/morris/example.css">

    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <link href='plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
    <link href='plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='plugins/fullcalendar/moment.min.js'></script>
    <script src='plugins/fullcalendar/fullcalendar.min.js'></script>
    <script src="../res/bootstrap-rating.min.js"></script>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.3&appId=628533080877859&autoLogAppEvents=1"></script>

  </head>

  <body class="<?php if(isset($_SESSION["user_id"])):?>  skin-blue-light sidebar-collapse sidebar-mini <?php else:?>login-page<?php endif; ?>" style="background-image: url('storage/background.jpg'); background-size: cover;" >
    <div class="wrapper"><!-- Main Header -->
      <?php if(isset($_SESSION["user_id"])):?>
      <header class="main-header"><!-- Logo -->
        <a href="./" class="logo"><!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b>E</span><!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SAVI </b>EXITO</span>
        </a><!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation"><!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu"> <!-- Navbar Right Menu -->
            <ul class="nav navbar-nav">

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                  <input type="hidden" name="cmd" value="_s-xclick">
                  <input type="hidden" name="hosted_button_id" value="A9SBAHZY46A48">
                  <input type="image" src="https://www.paypalobjects.com/es_ES/ES/i/btn/btn_subscribe_SM.gif" border="0" name="submit" alt="PayPal, la forma rápida y segura de pagar en Internet.">
                  <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
                </form></a>
              </li>
                  
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-warning"></i>
                  <span class="label label-warning">?</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Guías y Manuales</li>
                  <li class="footer"><a href="https://www.sergestec.com/download/manual_sistema_exito.pdf" target="_blank"><i class="fa fa-book"></i> Manual de usuario</a></a></li>
                  <li class="header">Sugerencias y Mejoras del Sistema</li>
                  <li class="footer"><a href="http://soporte.sergestec.com" target="_blank"><i class="fa fa-ticket"></i> Ir al sistema de tickets</a></li>
                </ul>
              </li>

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class=""><?php if(isset($_SESSION["user_id"])){ $user = UserData::getById($_SESSION["user_id"]); echo $user->name;                    
                    if($user->kind==1){ echo " (Admin)"; }
                    else if($user->kind==2){ echo " (Ejecutivo)"; }
                    else if($user->kind==3){ echo " (Cajero)"; }
                    }else{ } ?></span>
                </a>
                <ul class="dropdown-menu"><!-- The user image in the menu -->
                  <li class="user-header">
                    <?php if(UserData::getById($_SESSION["user_id"])->image!=""){
                      $url = "storage/profiles/".UserData::getById($_SESSION["user_id"])->image;
                      if(file_exists($url)){
                          echo "<img src='$url' class='img-circle'>";
                        }
                      }else{
                          echo "<img src='storage/profiles/default.jpg' class='img-circle'>";
                        }  ?>
                    <p><?php echo UserData::getById($_SESSION["user_id"])->name." ".UserData::getById($_SESSION["user_id"])->lastname;?></p>
                  </li><!-- The user image in the menu -->  
                  <li class="user-footer"><!-- Menu Footer-->
                    <div class="pull-right">
                      <a href="./?view=profile" class="btn btn-default btn-flat">Mi Perfil</a>
                      <a href="./logout.php" class="btn btn-default btn-flat">Salir</a>
                    </div>
                  </li>
                </ul>
              </li><!-- Control Sidebar Toggle Button -->
            </ul>
          </div>
        </nav>
      </header><!-- Left side column. contains the logo and sidebar -->
      <?php $u=null;
      if(isset($_SESSION["user_id"]) &&$_SESSION["user_id"]!=""):
      $u = UserData::getById($_SESSION["user_id"]); ?>
      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu"> <!-- Sidebar Menu -->
            <!-- <li class="header">ADMINISTRACION</li> -->
            <li><a><?php $user = UserData::getById($_SESSION["user_id"]);
              $image = ConfigurationData::getByAdmin($user->admin_id);
                if(isset($image->image)){ ?>
                  <li><a><i class="fa fa-bookmark"></i><span><img src="storage/settings/<?php echo $image->image;?>" style="width:150px; height: 40px;"></span></a></li>
                <?php }else{
                  echo "Agrega tu logo en configuración";
                } ?></li>
              <?php if($user->kind==1): ?>
                <li><a href="index.php?view=dashboard"><i class="fa fa-dashboard"></i><span>Resumen</span></a></li>
                <li><a href="index.php?view=alerts"><i class="fa fa-warning"></i><span>Alertas</span></a></li>
              <?php endif; ?>
                <?php $srvs = SellData::getSellsByAdmin($u->admin_id);
                $lim_serv = UserData::getById($u->admin_id)->limit_services;
                if(count($srvs) < $lim_serv || $lim_serv == 0){ ?>
              <li><a href="./?view=favourite"><i class="fa fa-shopping-cart"></i><span>Vender</span></a></li>
              <?php }else{ echo "<li><a style='color:red;'><i class='fa fa-warning' ></i><span>Suscríbete para vender</span></a></li>"; } ?>
              <?php if($user->kind==1): ?>
              <li class="treeview">
                <a href="#" class="treeview-toggle" data-toggle="treeview"><i class="fa fa-list-alt"></i><span>Catálogos <b class="caret"></b></span></a>
                <ul class="treeview-menu">
                  <li><a href="index.php?view=categories"><i class="fa fa-list-ol"></i><span>Categorias</span></a></li>
                  <li><a href="index.php?view=products"><i class="fa fa-apple"></i><span>Artículos</span></a></li>
                  <li><a href="index.php?view=clients"><i class="fa fa-users"></i><span>Clientes</span></a></li>
                  <li><a href="index.php?view=providers"><i class="fa fa-truck"></i><span>Proveedores</span></a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#" class="treeview-toggle" data-toggle="treeview"><i class="fa fa-money"></i><span>Finanzas <b class="caret"></b></span></a>
                <ul class="treeview-menu">
                  <li><a href="index.php?view=sells"><i class="fa fa-shopping-cart"></i><span>Ventas</span></a></li>
                  <li><a href="index.php?view=box"><i class="fa fa-archive"></i><span>Caja</span></a></li>
              </ul>
              <li class="treeview">
                <a href="#" class="treeview-toggle" data-toggle="treeview"><i class="fa fa-cubes"></i><span>Inventario <b class="caret"></b></span></a>
                <ul class="treeview-menu">
                  <li><a href="index.php?view=inventary"><i class="fa fa-cube"></i><span>Stock</span></a></li>
                  <li><a href="index.php?view=res"><i class="fa fa-refresh"></i> <span>Reabastecimientos</span></a></li>
                </ul>
              </li>
              <?php $sells = SellData::getSellsCountByUserId($_SESSION["user_id"]); foreach ($sells as $sell) {
                if ($sell->cuenta>0){ ?>
                <!-- <li><a href="index.php?view=reports"><i class="fa fa-area-chart"></i><span>Reportes</span></a></li> -->
                <li><a href="./?view=home"><i class="fa fa-home"></i><span>Estadísticas</span></a></li>
              <?php }else{
                echo "";
              } } ?>
              <li class="treeview">
                <a href="#" class="treeview-toggle" data-toggle="treeview"><i class="fa fa-cogs"></i><span>Administración <b class="caret"></b></span></a>
                <ul class="treeview-menu">
                  <?php if($u->id==1):?>
                  <li><a href="index.php?view=user_admins"><i class="fa fa-users"></i><span>Administradores</span></a></li>
                  <li><a href="./?view=campains" ><i class='fa fa-bullhorn'></i><span>Campañas</span></a></li>
                  <li><a href="./?view=stats"><i class='fa fa-area-chart'></i><span>Estadisticas</span></a></li>
                  <?php endif;?>
                  <li><a href="index.php?view=users"><i class="fa fa-users"></i><span>Usuarios</span></a></li>
                  <li><a href="index.php?view=settings"><i class="fa fa-cog"></i><span>Configuración</span></a></li>
                </ul>
              </li>
            <?php endif; ?>
          </ul> <!-- /.sidebar-menu -->
        </section> <!-- /.sidebar -->
      </aside>
      <?php endif;?>
      <?php endif;?>

      <!-- Content Wrapper. Contains page content -->
      <?php if(isset($_SESSION["user_id"])):?>
      <div class="content-wrapper">
        <?php View::load("index");?>
      </div><!-- /.content-wrapper -->
        <footer class="main-footer">
          <b class="pull-left">Copyright &copy; 2021 <a href="https://www.sergestec.com/" target="_blank">SERGESTEC</a></b>
        <div style="position: relative; top:-4px; left: 17px;" class="fb-share-button" data-href="https://www.sergestec.com/sistemas-gratuitos-para-mypes/" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.sergestec.com%2Fsistemas-gratuitos-para-mypes%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>
        <div class="pull-right hidden-xs">
          <b>Version</b> 8.0
        </div>
      </footer>
      <?php elseif(isset($_GET["view"]) && $_GET["view"]=="recovery"):?>
      <div class="login-box">
        <div class="login-logo">
          <br>
        </div><!-- /.login-logo -->
        <div class="modal-content">
          <div class="modal-header">
          <center><h1>SISTEMA DE VENTAS MULTIUSO</h1></center><br>
            <h4 class="modal-title" style="text-align: center;">Ingresa tu nueva contraseña</h4>
          </div>
          <div class="login-box-body">
            <form action="./?action=recovery_passw" method="post">
              <div class="form-group has-feedback" style="text-align: center;">
                <input class="col-lg-12 form-control" type="password" name="password" required placeholder="Escribe tu nueva contraseña" value=""/>
              </div><br>
              <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
              <div class="row">
                <div class="col-xs-12">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                </div><!-- /.col -->
              </div>
            </form>
          </div><!-- /.login-box-body -->
        </div>
      </div><!-- /.login-box -->
      <?php else: ?>
      <?php if(isset($_GET["view"]) && $_GET["view"]=="register"):?>
        <div class="login-box">
          <div class="login-logo">
            <br>
          </div><!-- /.login-logo -->
          <div class="login-box-body">
            <center><h1>REGISTRO</h1></center><br>
            <form action="./?action=process_register" method="post">
              <div class="form-group has-feedback">
                <input type="email" name="username" required class="form-control" placeholder="Escriba su correo electrónico" value="" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" name="password" id="campo" required class="form-control" placeholder="Escriba su contraseña"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="view" name="name" required class="form-control" placeholder="Escriba su nombre" value="" />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="view" name="lastname" required class="form-control" placeholder="Escriba su apellido" value="" />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                  <a href="./" class="btn btn-default btn-block btn-flat"><i class="fa fa-arrow-left"></i> Regresar</a>
                </div><!-- /.col -->
              </div>
            </form>
          </div>
        </div>
        <?php else:?>
        <!-- /.login-logo -->
      <div class="login-box">
        <div class="login-logo">
          <a href="./"><b>&nbsp;</b></a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
          <center><h1>SISTEMA DE VENTAS EXITO</h1></center><br>
          <form action="./?action=processlogin" method="post">
            <div class="form-group has-feedback">
              <input type="text" name="username" required class="form-control" value="admin" placeholder="Escriba su Usuario o Correo Electrónico" />
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="password" required class="form-control" value="admin" placeholder="Contraseña"/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Acceder</button>
              </div><br><br>
              <div style="text-align: center; margin-bottom: -5px;">
                <a href="./?view=register">Registrarme</a>&nbsp;&nbsp;
                <a href='#' data-toggle='modal' data-target="#myEmail" >Recuperar</a>
              </div>
            </div>
          </form>
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
      <?php endif; ?>
      <?php endif; ?>

      <div class="modal fade" id="myEmail"><!--Inicio de ventana modal 2-->
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" style="text-align: center;">Ingresa tu Correo Electrónico</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="post" id="addtag" action="index.php?action=email_rec_send" role="form">
                <div class="form-group">
                  <div class="col-md-12">
                    <input type="email" name="email" required class="form-control" value="" placeholder="Correo que ingresaste en el registro" required="yes">
                  </div>
                </div>
                <div class="form-group" style="text-align: center;">
                  <button type="submit" class="btn btn-primary">Enviar Correo</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div><!--Fin de ventana modal 2-->

      <div class="modal fade" id="logo"><!--Inicio de ventana modal 1-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Ingrese la imagen cuadrada</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="index.php?action=addlogo">
            <div class="form-group">
              <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
              <div class="col-md-6">
                <input type="file" name="image" class="form-control" id="image" placeholder="">
              </div>
            </div>
            <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $_SESSION["user_id"] ?>">
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div><!--Fin de ventana modal 1-->

    </div><!-- ./wrapper -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".datatable").DataTable({
          "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
        });
      });
    </script>
  </body>
</html>