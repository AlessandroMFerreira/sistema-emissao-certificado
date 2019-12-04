<?php
    require_once 'header.html';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    use chillerlan\QRCode\QRCode;
    
    $idEvento = $_GET['idEvento'];
    $nomeEvento = urldecode($_GET['evento']);

    $data = "idEvento=".$idEvento."&start";

    echo "<div class='container-fluid'>
            <div class='row'>
                <div class='col-3'>
                </div>
                <div class='col-6'>
                <div style=\"font-size: 40px; text-align: center; margin-top: 20%;\">";
                echo $nomeEvento;
                echo "<div style=\"font-size: 40px; text-align: center;\">";
                echo '<img src="'.(new QRCode)->render($data).'" />';
                echo "</div>
                <div class='col-3'>
                </div>
            </div>
            <div class='row'>
                <div class='col-3'>
                </div>
                <div class='col-6'>
                <div style=\" text-align: center; margin-top: 10%;\">
                <a href='#' onclick='imprimirTela()' id='btnImprimir'>Imprmir</a>
                <div class='col-3'>
                </div>
            </div>
        </div>";

    require_once 'footer.html';
?>