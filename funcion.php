<?php
    require_once("servidor.php");

    $nombre=$_POST['nom'];
    echo "Nombre: " . $nombre . "</br>";
    $edad=$_POST['edad'];
    echo "Edad: " . $edad . "</br>";
    $fecha=$_POST['date'];
    echo "Fecha: " . $fecha . "</br>";
    $foto=$_FILES['fot'];
    echo "Foto: " . $foto['name'] . "<br>";
    $estadocivil=$_POST['se'];
    echo "Estado Civil: " . $estadocivil . "</br>";
    $genero=$_POST['gen'];
    echo "Genero: " . $genero . "</br>";


    $tempo = $foto['tmp_name'];
    echo "Temporal: " . $tempo. "</br>";
    $nomfoto = $foto['name'];
    echo "Nombre Foto: " . $nomfoto. "</br>";

    $obs = $_POST["observaciones"];
    echo "Observaciones: "  . $obs. "</br>";

    #$doccion = isset($_POST['doccion']) ? $_POST['doccion'] : array();
    $doccion = $_POST['doccion'];

    $x = 1;
    foreach($doccion as $d)
    {
        echo $d;
        if ($x == 1)
        {
            $doc = $d;
        }
        else
        {
            $doc = $doc. ",". $d;
        }
        $x++;
    }

    $ruta = $_SERVER['DOCUMENT_ROOT'] . "/imagenes/" . $nomfoto;
    move_uploaded_file($tempo, $ruta);

    $conec = new servidor ("localhost", "rootbasicos","");
    $c = $conec->conecta();
    $sql = $c->prepare("Insert into basicos (nombre,edad,fecha,foto,genero,estadocivil,observaciones,documentacion)
    values (:a, :b, :c, :d, :e, :f, :g, :h)");

    $sql->bindParam(":a", $nombre);
    $sql->bindParam(":b", $edad);
    $sql->bindParam(":c", $fecha);
    $sql->bindParam(":d", $ruta);
    $sql->bindParam(":e", $genero);
    $sql->bindParam(":f", $estadocivil);
    $sql->bindParam(":g", $obs);
    $sql->bindParam(":h", $doc);
    
    $sql->execute();
    $sql->closecursor();
?>