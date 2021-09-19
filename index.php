<?php

$url = 'https://api.apify.com/v2/key-value-stores/TyToNta7jGKkpszMZ/records/LATEST?disableRedirect=true';

$ch = curl_init($url); //define a url a ser consumida
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //retorna a tranferencia de dados em forma de string
$dado = json_decode(curl_exec($ch)); //faz a decodificacao, necessita de: curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) para o correto funcionamento;

//get nos elementos da api
$recovered = $dado->recovered; 
$infected = $dado->infected;
$deceased = $dado->deceased;

$data = new DateTime($dado->lastUpdatedAtApify) //classe usado para modificar a vizualizacao da data

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">

    <!--usado para o grafico, google charts-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);
        var c = document.getElementById("mortes").text

        function drawChart() {
            var dados = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Recuperados', <?= $recovered?>],
                ['Mortes', <?= $deceased ?>],
                ['Infectados', <?=$infected ?>]
            ]);

            var options = {
                title: 'Casos de COVID-19 no Brasil',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(dados, options);
        }
    </script>

    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <title>Covid-19</title>
</head>

<body>
    <div class="container">
        <h1>Dados Atualizados COVID-19 no Brasil</h1>
        <section>
            <h4>Próxima Atualização em: <?= $data->format('d-m-Y H:i:s') ?></h4>
            <table>
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Quantidade de Infectados</th>
                        <th>Quantidade de Mortes</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i = 0;
                    foreach ($dado->infectedByRegion as $e) { 
                        print "<tr>";
                        print "<td>$e->state</td>";
                        print "<td>$e->count</td>";
                        if (property_exists($dado, "deceasedByRegion")) {
                            $a = json_encode($dado->deceasedByRegion[$i]->count); 
                            $i++;
                            echo "<td>$a</td>";
                        }
                        print "</tr>";
                    }
                    ?>

                </tbody>
            </table>
        </section>
        <div id="piechart_3d"></div>
    </div>
</body>

<!--scipts datatables-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> 
<script src="js_datatables/script.js"></script> 

</html>