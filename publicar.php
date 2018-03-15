<?php


if($_REQUEST['data_corte']){

$dataInicio = $_REQUEST['data_corte'];
$date = new DateTime($dataInicio);
$data = $date->format("Y-m-d H:i:s");


$iterator = new RecursiveDirectoryIterator($_REQUEST['raiz_projeto']);
$recursiveIterator = new RecursiveIteratorIterator($iterator);


//$dataModificacao = date ("F d Y H:i:s.", filemtime($filename));
?>
<html>
<head><title>Publicador</title></head>
<body>
<table border="1px">
    <tr>
        <td><b>Nome Arquivo</b></td>
        <td><b>Data de modificação</b></td>
    </tr>
    <?php
    try {
        foreach ($recursiveIterator as $entry) {

            if (substr($entry->getFilename(), 0, 1) != "." && $entry->getFileName() != "synced_folders") {

                $verificaSvnFile = explode(".",$entry->getFilename());
                if($verificaSvnFile[1] != "svn-base" && $verificaSvnFile[1] != "pdf" && $verificaSvnFile[1] != "db" && $verificaSvnFile[1] != "db-journal" && $verificaSvnFile[1] != "xml"){
                    $seconds = $entry->getMTime();
                    $seconds = round($seconds);
                    $dataModificacao = date("Y-m-d H:i:s", $seconds);

                    if ($dataModificacao > $data) {
                        ?>
                        <tr>
                            <td><?php echo $entry->getFilename(); ?></td>
                            <td><?php echo $dataModificacao ?></td>
                        </tr>
                        <?php
                    }
                }
            }
        }
    } catch (UnexpectedValueException $e) {
        echo 'Erro: ' . $e->getMessage();
    }

    }
        ?>

    </table>
</body>
</html>
