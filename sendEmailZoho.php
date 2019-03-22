<?php 
    include('zoho.php');
    

    $mysqli = new mysqli('localhost', 'xxxxx', 'xxxxx', 'xxxxxxx');

    if ($mysqli->connect_errno) {
        // La conexión falló. ¿Que vamos a hacer? 
        // Se podría contactar con uno mismo (¿email?), registrar el error, mostrar una bonita página, etc.
        // No se debe revelar información delicada

        // Probemos esto:
        echo "Lo sentimos, este sitio web está experimentando problemas.";

        // Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
        // de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
        echo "Error: Fallo al conectarse a MySQL debido a: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";

        // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
        exit;
    }

    $sql = "SELECT * FROM table";
    echo $sql;
    $resultado = $mysqli->query($sql);
    echo " resultado ".$resultado->num_rows;
    if ($resultado->num_rows > 0) {
        $zoho = new zoho();
        echo "testing....<br />";
        $auth = $zoho->getAuth();
        echo " <pre>";
        echo $auth;
        while ($lead = $resultado->fetch_assoc()) {
            $result = $zoho->postData($auth, $lead['name'],$lead['lastname'], $lead['email'],'adresse','by','postr','spain','Some comment'); 
            print " resultado ".$result;
            if($result==200){
                $sql="insert into into ";
                echo $sql; 

                if ($mysqli->query($sql)) {
                   echo "New record created successfully";
                } else {
                   echo "Error: " . $sql . "" ;
                }                
            }
        }
        print_r($result);
    }

    mysqli_close($mysqli)
 ?>
