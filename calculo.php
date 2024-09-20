<?php
    require_once("servidor.php");

    $nombre=$_POST['nombre'];
    echo "Nombre del Cliente: " . $nombre . "</br>";

    $saldo=$_POST['saldo'];
    echo "Saldo Previo: $" . $saldo . "</br>";

    $operacion=$_POST['op'];
    echo "Operacion: " . $operacion . "</br>";

    $importe=$_POST['monto'];
    echo "Importe: $" . $importe . "</br>";

    if($operacion == "Abono")
    {
        $saldo=$saldo+$importe;
        echo "Nuevo Saldo: $" . $saldo . "</br>";
    }
    else if($operacion == "Cargo")
    {
        $presaldo = $saldo*0.01;
        $saldo=($saldo - $presaldo) - $importe;
        if($saldo<=0)
        {
            $saldo=0;
            echo "Nuevo Saldo: $" . $saldo . "</br>";
        }
    }
    else
    {
        echo "No se pudo completar la operacion, verifique su saldo o el monto.";
    }

    $conec=new servidor ("localhost", "rootbasicos", "");
    $c = $conec->conecta();
    $sql = $c->prepare("insert into cajero (nombre, saldo, operacion, importe)
    values (:a, :b, :c, :d)");

    $sql->bindParam(":a", $nombre);
    $sql->bindParam(":b", $saldo);
    $sql->bindParam(":c", $operacion);
    $sql->bindParam(":d", $importe);

    $sql->execute();
    $sql->closecursor();
    
?>