<?php
    require_once 'header.html';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    use chillerlan\QRCode\QRCode;
    
    $idEvento = $_GET['idEvento'];
    $nomeEvento = $_GET['evento'];
    var_dump($nomeEvento);

    $data = "idEvento=".$idEvento."&start";

    echo "<div class='container-fluid'>
            <div class='row'>
                <div class='col-3'>
                </div>
                <div class='col-6'>
                <div>";
                echo $nomeEvento;
                echo "</div>";
                echo '<img src="'.(new QRCode)->render($data).'" />';
                echo "</div>
                <div class='col-3'>
                </div>
            </div>
        </div>";

    require_once 'footer.html';
?>