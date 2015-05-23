<script type="text/javascript">

        var chart;
        var arrow;
        var axis;

        AmCharts.ready(function () {
            // create angular gauge
            chart = new AmCharts.AmAngularGauge();
            chart.addTitle("OSP's Finalizadas");

            // create axis
            axis = new AmCharts.GaugeAxis();
            axis.startValue = 0;
            axis.endValue = 100;
            axis.endAngle = 90;
            axis.startAngle = -90;
            // color bands
            var band1 = new AmCharts.GaugeBand();
            band1.startValue = 0;
            band1.endValue = 25;
            band1.color = '#00ff00';
            band1.innerRadius = "25%";

            var band2 = new AmCharts.GaugeBand();
            band2.startValue = 25;
            band2.endValue = 50;
            band2.color = '#00ff00';
            band2.innerRadius = "25%";

            var band3 = new AmCharts.GaugeBand();
            band3.startValue = 50;
            band3.endValue = 75;
            band3.color = '#00ff00';
            band3.innerRadius = "25%";

            var band4 = new AmCharts.GaugeBand();
            band4.startValue = 75;
            band4.endValue = 100;
            band4.color = '#00ff00';
            band4.innerRadius = "25%";

            axis.bands = [band1, band2, band3,band4];

            // bottom text
            axis.bottomTextYOffset = -10;
            axis.setBottomText("<?php echo $valores_grafico['finalizadas'] ?> %");
            chart.addAxis(axis);

            // gauge arrow
            arrow = new AmCharts.GaugeArrow();
            arrow.color = "black";
            chart.addArrow(arrow);

            chart.write("finalizadas");
            // change value every 2 seconds
            arrow.setValue(<?php echo $valores_grafico['finalizadas'] ?>);


             //========================================

            chart = new AmCharts.AmAngularGauge();
            chart.addTitle("OSP's Executadas");

            // create axis
            axis = new AmCharts.GaugeAxis();
            axis.startValue = 0;
            axis.endValue = 100;
            axis.endAngle = 90;
            axis.startAngle = -90;
            // color bands
            var band1 = new AmCharts.GaugeBand();
            band1.startValue = 0;
            band1.endValue = 25;
            band1.color = '#007700';
            band1.innerRadius = "25%";

            var band2 = new AmCharts.GaugeBand();
            band2.startValue = 25;
            band2.endValue = 50;
            band2.color = '#007700';
            band2.innerRadius = "25%";

            var band3 = new AmCharts.GaugeBand();
            band3.startValue = 50;
            band3.endValue = 75;
            band3.color = '#007700';
            band3.innerRadius = "25%";

            var band4 = new AmCharts.GaugeBand();
            band4.startValue = 75;
            band4.endValue = 100;
            band4.color = '#007700';
            band4.innerRadius = "25%";

            axis.bands = [band1, band2, band3,band4];

            // bottom text
            axis.bottomTextYOffset = -10;
            axis.setBottomText("<?php echo $valores_grafico['executadas'] ?> %");
            chart.addAxis(axis);

            // gauge arrow
            arrow = new AmCharts.GaugeArrow();
            arrow.color = "black";
            chart.addArrow(arrow);

            chart.write("executadas");
            arrow.setValue(<?php echo $valores_grafico['executadas'] ?>);

            //========================================

            chart = new AmCharts.AmAngularGauge();
            chart.addTitle("OSP's Pendentes");

            // create axis
            axis = new AmCharts.GaugeAxis();
            axis.startValue = 0;
            axis.endValue = 100;
            axis.endAngle = 90;
            axis.startAngle = -90;
            // color bands
            var band1 = new AmCharts.GaugeBand();
            band1.startValue = 0;
            band1.endValue = 25;
            band1.color = "orange";
            band1.innerRadius = "25%";

            var band2 = new AmCharts.GaugeBand();
            band2.startValue = 25;
            band2.endValue = 50;
            band2.color = "orange";
            band2.innerRadius = "25%";

            var band3 = new AmCharts.GaugeBand();
            band3.startValue = 50;
            band3.endValue = 75;
            band3.color = "orange";
            band3.innerRadius = "25%";

            var band4 = new AmCharts.GaugeBand();
            band4.startValue = 75;
            band4.endValue = 100;
            band4.color = "orange";
            band4.innerRadius = "25%";

            axis.bands = [band1, band2, band3,band4];

            // bottom text
            axis.bottomTextYOffset = -10;
            axis.setBottomText("<?php echo $valores_grafico['pendentes'] ?> %");
            chart.addAxis(axis);

            // gauge arrow
            arrow = new AmCharts.GaugeArrow();
            arrow.color = "black";
            chart.addArrow(arrow);

            chart.write("pendentes");
            // change value every 2 seconds
             arrow.setValue(<?php echo $valores_grafico['pendentes'] ?>);


             //========================================

            chart = new AmCharts.AmAngularGauge();
            chart.addTitle("OSP's Sem Planejamento");

            // create axis
            axis = new AmCharts.GaugeAxis();
            axis.startValue = 0;
            axis.endValue = 100;
            axis.endAngle = 90;
            axis.startAngle = -90;
            // color bands
            var band1 = new AmCharts.GaugeBand();
            band1.startValue = 0;
            band1.endValue = 25;
            band1.color = "red";
            band1.innerRadius = "25%";

            var band2 = new AmCharts.GaugeBand();
            band2.startValue = 25;
            band2.endValue = 50;
            band2.color = "red";
            band2.innerRadius = "25%";

            var band3 = new AmCharts.GaugeBand();
            band3.startValue = 50;
            band3.endValue = 75;
            band3.color = "red";
            band3.innerRadius = "25%";

            var band4 = new AmCharts.GaugeBand();
            band4.startValue = 75;
            band4.endValue = 100;
            band4.color = "red";
            band4.innerRadius = "25%";

            axis.bands = [band1, band2, band3,band4];

            // bottom text
            axis.bottomTextYOffset = -10;
            axis.setBottomText("<?php echo $valores_grafico['sem_planejamento'] ?> %");
            chart.addAxis(axis);

            // gauge arrow
            arrow = new AmCharts.GaugeArrow();
            arrow.color = "black";
            chart.addArrow(arrow);

            chart.write("sem_planejamento");
            arrow.setValue(<?php echo $valores_grafico['sem_planejamento'] ?>);
            // change value every 2 seconds        
        });

    </script>
    
<aside id='graficos'>   

    <div id='sem_planejamento'></div>
    <div id='pendentes'></div>
    <div id='executadas'></div>
    <div id='finalizadas'></div>

</aside>