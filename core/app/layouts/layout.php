<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SAVI | ZAPATOS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="plugins/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/dist/css/skins/skin-blue-light.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="plugins/jquery/jquery-2.1.4.min.js"></script>
    <script src="plugins/morris/raphael-min.js"></script>
    <script src="plugins/morris/morris.js"></script>
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <link rel="stylesheet" href="plugins/morris/example.css">
    <script src="plugins/jspdf/jspdf.min.js"></script>
    <script src="plugins/jspdf/jspdf.plugin.autotable.js"></script>
    <?php if(isset($_GET["view"]) && $_GET["view"]=="sell"):?>
    <script type="text/javascript" src="plugins/jsqrcode/llqrcode.js"></script>
    <script type="text/javascript" src="plugins/jsqrcode/webqr.js"></script>
    <?php endif;?>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.3&appId=628533080877859&autoLogAppEvents=1"></script>

  </head>

  <body class="<?php if(isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])):?>  skin-blue-light sidebar-collapse sidebar-mini <?php else:?>login-page<?php endif; ?>"
    style="background-image: url('storage/background.jpg'); background-size: cover;">
    <div class="wrapper">
      <?php if(isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])):?>
      <header class="main-header"><!-- Main Header -->
        <a href="./" class="logo"><!-- Logo -->
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b>Z</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">SAVI<b>&nbsp;ZAPATOS</b></span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <?php if(isset($_SESSION["user_id"])):
              $msgs = MessageData::getUnreadedByUserId($_SESSION["user_id"]); ?>

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
                  <li class="footer"><a href="https://www.sergestec.com/download/manual_sistema_calzado.pdf" target="_blank"><i class="fa fa-book"></i> Manual de usuario</a></li>
                  <li class="header">Sugerencias y Mejoras del Sistema</li>
                  <li class="footer"><a href="http://soporte.sergestec.com" target="_blank"><i class="fa fa-ticket"></i> Ir al sistema de tickets</a></li>
                  <li class="header">Tienes <?php echo count($msgs);?> mensajes nuevos</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                    <?php foreach($msgs as $i):?>
                      <li><!-- start message -->
                        <a href="./?view=messages&opt=open&code=<?php echo $i->code;?>">
                          <h4>
                        <?php if($i->user_from!=$_SESSION["user_id"]):?>
                        <?php $u = $i->getFrom(); echo $u->name." ".$u->lastname;?>
                        <?php elseif($i->user_to!=$_SESSION["user_id"]):?>
                        <?php $u = $i->getTo(); echo $u->name." ".$u->lastname;?>
                      <?php endif; ?>
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>

                          </h4>
                          <p><?php echo $i->message; ?></p>
                        </a>
                      </li>
                    <?php endforeach; ?>

                    </ul>
                  </li>
                  <li class="footer"><a href="./?view=messages&opt=all">Todos los mensajes</a></li>
                </ul>
              </li>
              <?php endif;?>
              
              <li class="dropdown user user-menu"><!-- User Account Menu -->
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><!-- The user image in the navbar-->                  
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class=""><?php if(isset($_SESSION["user_id"]) ){ echo UserData::getById($_SESSION["user_id"])->name;
                  if(Core::$user->kind==1){ echo " (Admin)"; }
                  else if(Core::$user->kind==2){ echo " (Ejecutivo)"; }
                  else if(Core::$user->kind==3){ echo " (Cajero)"; }
                  }else if (isset($_SESSION["client_id"])){ echo PersonData::getById($_SESSION["client_id"])->name." (Cliente)" ;}?> <b class="caret"></b> </span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <?php if(Core::$user->image!=""){
                      $url = "storage/profiles/".Core::$user->image;
                      if(file_exists($url)){
                        echo "<img src='$url' class='img-circle'>";
                      }
                    }else{
                      echo "<img src='storage/profiles/default.jpg' class='img-circle'>";
                    }  ?>
                    <p>
                    <?php echo Core::$user->name." ".Core::$user->lastname;?>
                    </p>
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
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">ADMINISTRACION</li>
            <?php if(isset($_SESSION["user_id"])):?>
            <?php if(Core::$user->kind==1):?>
            <li><a href="./index.php?view=home"><i class='fa fa-dashboard'></i> <span>Inicio</span></a></li>
            <?php endif; ?>
            <li><a href="./index.php?view=alerts"><i class='fa fa-bell-o'></i> <span>Alertas</span></a></li>
            <li><a href="./index.php?view=sell"><i class='fa fa-shopping-cart'></i> <span>Vender</span></a></li>
            <?php if(Core::$user->kind==2 || Core::$user->kind==3):?>
            <li><a href="./index.php?view=sells"><i class='fa fa-usd'></i> <span>Ventas</span></a></li>
            <li><a href="index.php?view=spends"><i class="fa fa-coffee"></i> <span>Gastos</span></a></li>
            <li><a href="index.php?view=inventaries"><i class="fa fa-cubes"></i> <span>Inventario Global</span></a></li>
            <li><a href="index.php?view=clients"><i class="fa fa-male"></i> <span>Clientes</span></a></li>
            <?php endif; ?>
            <?php if(Core::$user->kind==3):?>
            <li><a href="index.php?view=providers"><i class="fa fa-truck"></i> <span>Proveedores</span></a></li>
            <li><a href="index.php?view=box"><i class="fa fa-archive"></i> <span>Caja</span></a></li>
            <li><a href="index.php?view=res"><i class="fa fa-refresh"></i> <span>Reabastecimientos</span></a></li>
            <li><a href="./?view=trasps"><i class="fa fa-exchange"></i> <span>Traspasos</span></a></li>
            <?php endif; ?>
            <?php if(Core::$user->kind==1):?>
            <li class="treeview">
              <a href="#"><i class='fa fa-th-list'></i> <span>Catálogos</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="./index.php?view=serie_size"><i class='fa fa-list-ol'></i> <span>Series</span></a></li>
                <li><a href="./index.php?view=details"><i class='fa fa-star-half-o'></i> <span>Marcas y Colores</span></a></li>
                <li><a href="./index.php?view=products"><i class='fa fa-apple'></i> <span>Productos</span></a></li>
                <li><a href="index.php?view=clients"><i class="fa fa-male"></i> <span>Clientes</span></a></li>
                <li><a href="index.php?view=providers"><i class="fa fa-truck"></i> <span>Proveedores</span></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class='fa fa-money'></i> <span>Finanzas</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="./index.php?view=sells"><i class='fa fa-usd'></i> <span>Ventas</span></a></li>
                <li><a href="index.php?view=box"><i class="fa fa-archive"></i> <span>Caja</span></a></li>
                <li><a href="index.php?view=spends"><i class="fa fa-coffee"></i> <span>Gastos</span></a></li>
                <li><a href="index.php?view=balance"><i class="fa fa-area-chart"></i> <span>Balance</span></a></li>
                <li><a href="index.php?view=gain"><i class="fa fa-money"></i> <span>Liquidez</span></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class='fa fa-bar-chart-o'></i> <span>Estadísticas</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="./index.php?view=analytics"><i class='fa fa-bar-chart-o'></i> <span>Analytics</span></a></li>
                <!-- <li><a href="index.php?view=reports"><i class="fa fa-tags"></i> <span>Marcas</span></a></li>
                <li><a href="./index.php?view=sellreports"><i class="fa fa-list-ol"></i> <span>Ventas</span></a></li>
                <li><a href="./index.php?view=sell_user"><i class="fa fa-users"></i> <span>Usuarios</span></a></li>
                <li><a href="index.php?view=gencodebar"><i class="fa fa-barcode"></i> <span>Código de barras</span></a></li> -->
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class='fa fa-cube'></i> <span>Stock</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="index.php?view=inventaries"><i class="fa fa-cubes"></i> <span>Inventario Global</span></a></li>
                <li><a href="index.php?view=res"><i class="fa fa-refresh"></i> <span>Reabastecimientos</span></a></li>
                <li><a href="index.php?view=stocks"><i class="fa fa-building"></i> <span>Sucursales</span></a></li>
                <li><a href="./?view=readjustments"><i class="fa fa-adjust"></i> <span>Reajustes</span></a></li>
                <li><a href="./?view=trasps"><i class="fa fa-exchange"></i> <span>Traspasos</span></a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php if(Core::$user->kind==1):?>
            <li class="treeview">
              <a href="#"><i class='fa fa-cog'></i> <span>Administracion</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php if(Core::$user->id==1):?>
                <li><a href="index.php?view=user_admins"><i class="fa fa-users"></i><span>Administradores</span></a></li>
                <li><a href="./?view=campains" ><i class='fa fa-bullhorn'></i><span>Campañas</span></a></li>
                <li><a href="./?view=stats"><i class='fa fa-area-chart'></i><span>Estadisticas</span></a></li>
                <?php endif;?>
                <li><a href="./?view=users"><i class="fa fa-users"></i> <span>Usuarios</span></a></li>
                <li><a href="./?view=settings"><i class="fa fa-cogs"></i> <span>Configuracion</span></a></li>
              </ul>
            </li>
          <?php endif; ?>
            <?php elseif(isset($_SESSION["client_id"])):?>
          <?php endif;?>
          </ul><!-- /.sidebar-menu -->
        </section><!-- /.sidebar -->
      </aside>
    <?php endif;?>

      <!-- Content Wrapper. Contains page content -->
      <?php if(isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])):?>
      <div class="content-wrapper">
        <?php View::load("index");?>
      </div><!-- /.content-wrapper -->
        <footer class="main-footer">
          <b class="pull-left">Copyright &copy; 2022 <a href="https://www.sergestec.com/" target="_blank">SERGESTEC</a></b>
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
          <center><h1>SISTEMA DE VENTAS DE CALZADO</h1></center><br>
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
                <input type="email" name="email" required class="form-control" placeholder="Escriba su correo electrónico" value="" />
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
    <div class="login-box" >
      <div class="login-logo">
        <a href="./"><b>&nbsp;</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body" >
        <center><h1>SISTEMA DE VENTA DE CALZADO</h1></center>
        <form action="./?action=processlogin" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" required class="form-control" value="eabanto2@hotmail.com" placeholder="Escriba su Usuario o Correo Electrónico" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" required class="form-control" value="admin" placeholder="Escriba su contraseña" />
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
      <?php endif;?>
      <?php endif;?>

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


    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <!-- Bootstrap 3.3.2 JS -->
    <script src="plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="plugins/dist/js/app.min.js" type="text/javascript"></script>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
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
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>

