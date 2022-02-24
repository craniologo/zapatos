<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <style type="text/css">
        ${demo.css}
    </style>
<head>
<?php $admin = UserData::getById($_SESSION["user_id"]);
$a = new Database; $connection = $a->connect();
$sett = SettingData::getByAdmin($admin->admin_id); ?>
<!--inicio de grafico de torta-->
<script type="text/javascript">
$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Numero de Ventas por Usuario'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.0f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Ventas<br/>'
        },
        series: [{
            name: "Usuario",
            colorByPoint: true,
            data: [ <?php if($admin->id==1){
                        $sql = "SELECT user_id, COUNT(user_id) AS suma FROM sell WHERE operation_type_id=2 GROUP BY user_id";
                    }else{
                        $sql = "SELECT user_id, COUNT(user_id) AS suma FROM sell WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY user_id";
                    }
                $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)){ 
            $dat = $registros["user_id"]; ?>
           
            ['<?php $name = UserData::getById($dat);
            echo $name->name." ".$name->lastname; ?>', <?php echo $registros["suma"] ?>],
            <?php } ?>
            ]
        }],
        drilldown: {
            series: []
        }
    });
});
</script>
<!--Fin de grafico de torta-->
<!--inicio de grafico de torta-->
<script type="text/javascript">
$(function () {
    // Create the chart
    $('#container1').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Monto de Ventas por Usuario'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name} <?php echo $sett->coin; ?> {point.y:.2f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b><?php echo $sett->coin; ?> {point.y:.2f}</b><br/>'
        },
        series: [{
            name: "Usuario",
            colorByPoint: true,
            data: [ <?php if($admin->id==1){
                        $sql = "SELECT user_id, SUM(total) AS suma FROM sell WHERE operation_type_id=2 GROUP BY user_id";
                    }else{
                        $sql = "SELECT user_id, SUM(total) AS suma FROM sell WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY user_id";
                    }
                $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)){ 
            $dat = $registros["user_id"]; ?>
           
            ['<?php $name = UserData::getById($dat);
            echo $name->name." ".$name->lastname; ?>', <?php echo $registros["suma"] ?>],
            <?php } ?>
            ]
        }],
        drilldown: {
            series: []
        }
    });
});
</script>
<!--Fin de grafico de torta-->
<!--inicio de grafico de barras-->
<script type="text/javascript"> 
$(function () {
    // Create the chart
    $('#container2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Productos de Mayor Rentabilidad'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'P. Compra - P. Venta'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b><?php echo $sett->coin; ?> {point.y:.2f}</b><br/>'
        },

        series: [{
            name: "Producto",
            colorByPoint: true,
            data: [ <?php if($admin->id==1){
                $sql = "SELECT size_id, SUM(price_out - price_in) AS resta FROM product GROUP BY size_id ORDER BY resta DESC LIMIT 5";
            }else{
                $sql = "SELECT size_id, SUM(price_out - price_in) AS resta FROM product WHERE admin_id=$admin->admin_id GROUP BY size_id ORDER BY resta DESC LIMIT 5";
            }
                $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)){ 
            $dat = $registros["size_id"]; ?>
            [
                '<?php $name = ProductData::getBySerieId($dat); echo substr($name->modelo, 0, 15); ?>',
                <?php echo $registros["resta"]; ?>
            ],
            <?php
            }
            ?>
            ]
        }],
    });
});
</script> 
<!--Fin de grafico de barras-->
<!--inicio de grafico de barras-->
<script type="text/javascript"> 
$(function () {
    // Create the chart
    $('#container3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Numero de Artículos Vendidos por Modelo y Talla'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Cantidad'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Pares<br/>'
        },

        series: [{
            name: "Producto",
            colorByPoint: true,
            data: [ <?php if($admin->id==1){
                $sql = "SELECT product_id,size_id, SUM(q) AS suma FROM operation WHERE operation_type_id=2 GROUP BY product_id,size_id ORDER BY suma DESC LIMIT 5";
            }else{
                $sql = "SELECT product_id,size_id, SUM(q) AS suma FROM operation WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY product_id,size_id ORDER BY suma DESC LIMIT 5";
            }
                $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)){ 
            $dat = $registros["product_id"];
            $siz = $registros["size_id"]; 
            ?>
            [
                '<?php $name = ProductData::getById($dat); $size = Serie_sizeData::getById($siz); echo substr($name->modelo, 0, 12)." talla ".$size->size; ?>',
                <?php echo $registros["suma"]; ?>
            ],
            <?php
            }
            ?>
            ]
        }],
    });
});
</script> 
<!--Fin de grafico de barras-->
<!--Inicio del grafico anual-->
<script type="text/javascript">
$(function () {
    $('#container4').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Número de Ventas en los Últimos 15 Días'
        },
        xAxis: {
            categories: [  <?php if($admin->id==1){
                    $sql = "SELECT created, COUNT(user_id) AS suma FROM sell WHERE operation_type_id=2 GROUP BY created ORDER by created DESC LIMIT 15";
                }else{
                    $sql = "SELECT created, COUNT(user_id) AS suma FROM sell WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY created ORDER by created DESC LIMIT 15";
                }
                $result = mysqli_query($connection,$sql);
                while ($registros = mysqli_fetch_array($result)) 
                { ?>
                    '<?php $fecha = $registros["created"];
                    echo substr($fecha,2,8) ?>',
                <?php } ?>
            ]
        },
        yAxis: {
            title: {
                text: '<b>Cantidad</b>'
            },
            labels: {
                formatter: function () {
                    return this.value + '';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Ventas',
            data: [
                <?php if($admin->id==1){
                $sql = "SELECT created, COUNT(user_id) AS suma FROM sell WHERE operation_type_id=2 GROUP BY created ORDER by created DESC LIMIT 15";
            }else{
                $sql = "SELECT created, COUNT(user_id) AS suma FROM sell WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY created ORDER by created DESC LIMIT 15";
            }
            $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)) 
            {
            ?>
                <?php echo $registros["suma"] ?>,
            <?php } ?>
            ]
        }]
    });
});
</script> 
<!--Fin del grafico anual-->
<!--Inicio del grafico anual-->
<script type="text/javascript">
$(function () {
    $('#container5').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Monto de Ventas de los Últimos 15 Días'
        },
        xAxis: {
            categories: [ <?php if($admin->id==1){
            $sql = "SELECT created, SUM(total) AS suma FROM sell WHERE operation_type_id=2 GROUP BY created LIMIT 15";
        }else{            
            $sql = "SELECT created, SUM(total) AS suma FROM sell WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY created LIMIT 15";
        }
            $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)) 
            { ?>
                '<?php $fecha = $registros["created"];
                echo substr($fecha,2,8); ?>',
            <?php } ?>
            ]
        },
        yAxis: {
            title: {
                text: '<b>Ventas <?php echo $sett->coin; ?></b>'
            },
            labels: {
                formatter: function () {
                    return this.value + '';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Ventas <?php echo $sett->coin; ?>',
            data: [ <?php if($admin->id==1){
                $sql = "SELECT created, SUM(total) AS suma FROM sell WHERE operation_type_id=2 GROUP BY created LIMIT 15";
            }else{
                $sql = "SELECT created, SUM(total) AS suma FROM sell WHERE operation_type_id=2 and admin_id=$admin->admin_id GROUP BY created LIMIT 15";
            }
            $result = mysqli_query($connection,$sql);
            while ($registros = mysqli_fetch_array($result)) 
            { ?>
                <?php echo $registros["suma"] ?>,
            <?php } ?>
            ]
        }]
    });
});
</script> 
<!--Fin del grafico anual-->
</head>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <h2><i class="fa fa-bar-chart-o"></i> Productividad</h2>
            <p>Gráficas estadísticas de productividad para la toma de decisiones en la empresa.</p>
            <ol class="breadcrumb">
              <li><a href="./?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
              <li><i class="fa fa-bar-chart-o"></i> Gráficas</li>
              <li class="active"><i class="fa fa-bar-chart-o"></i> Productividad</li>
            </ol>
            <div class="col-sm-6" id="container" style="min-width: auto; height: 250px; border: 1px solid" >
            <!--Muestra el grafico dinamico-->
            </div>
            <div class="col-sm-6" id="container1" style="min-width: auto; height: 250px; border: 1px solid" >
            <!--Muestra el grafico de barras-->
            </div>
            <div class="col-sm-6" id="container2" style="min-width: auto; height: 250px; border: 1px solid" >
            <!--Muestra el grafico anual-->
            </div>
            <div class="col-sm-6" id="container3" style="min-width: auto; height: 250px; border: 1px solid" >
            <!--Muestra el grafico de torta-->
            </div>
            <div class="col-sm-6" id="container4" style="min-width: auto; height: 250px; border: 1px solid" >
            <!--Muestra el grafico dinamico-->
            </div>
            <div class="col-sm-6" id="container5" style="min-width: auto; height: 250px; border: 1px solid" >
            <!--Muestra el grafico de barras-->
            </div>
            <body>
                <script src="graficas/js/highcharts.js"></script>
                <script src="graficas/js/modules/exporting.js"></script>
                <script src="graficas/js/jquery.min.js"></script>
            </body>
        </div> <!--row-->
    </div>
</html>