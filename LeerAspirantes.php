<?php

session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}

include "php/navbar.php";

?>

<html>
<head>

    <title>Leer Aspirantes</title>
    
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/docs.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/miCSS.css">

    <meta charset="UTF-8">
       
</head>

   <div class="container">   
    <div class="row">

        <div class="col-md-12">
            <h2>Listado de todos los Curruculum</h2>
        </div>

        <br><br>

        <form action="" method="post">

            <div class="col-md-12">
                <strong>Buscar por</strong>
            </div>

            <br>

            <select class="col-md-6 entradaTxt" name="Pais" data-placeholder="Seleccione país" tabindex="-1" aria-hidden="true" >
                <option value="" class="selected">Seleccione el País</option>
                <option value="España">España</option>
                <option value="Otro">Otro</option>
            </select>


            <br><br>                

            <select class="col-md-6" id="ms" name="CategoriasInteres" data-placeholder="Seleccione categoría de interés" tabindex="-1" aria-hidden="true" >
                <option value="" >Selecciona Categoría de Interés</option>
                    <option value="Adminstración"       >Adminstración</option>
                    <option value="Comercial"           >Comercial</option>
                    <option value="Calidad"             >Calidad</option>
                    <option value="I+D+I"               >I+D+I</option>
                    <option value="Recursos Humanos"    >Recursos Humanos</option>
                    <option value="Área financiera"     >Área financiera</option>
            </select>

            <br><br>

            <div class="col-md-12">
                    <input class="btn btn-default" type="submit" name="Buscar" value ="Buscar Registros">
            </div>            

        </form> 

        <br>

        <div class="col-md-12">
            <!-- Volver apantalla inicial -->
            <br><br>
            <input class="btn btn-default" type="button" value="Volver al menú principal" onclick="location.href='GestorPrincipal.php'">
            <br><br>
        </div>  
            

            
        <div class="row show-Migrid">

            <div class="col-md-2"> <label> &nbsp;<B>Nombre</B>&nbsp;</label><br/> </div>
            <div class="col-md-2"> <label> &nbsp;<B>Apellidos</B>&nbsp;</label><br/> </div>
            <div class="col-md-2"> <label> &nbsp;<B>País</B>&nbsp;</label><br/> </div>
            <div class="col-md-2"> <label> &nbsp;<B>Provincia</B>&nbsp;</label><br/> </div>
            <div class="col-md-2"> <label> &nbsp;<B>Municipio</B>&nbsp;</label><br/> </div>
            <div class="col-md-2"> <label> &nbsp;<B>ID usuario</B>&nbsp;</label><br/> </div>

        </div>

 


            
        <?php
           
        ####################################################################################################
        # Leo todo lo que hay en la base de datos MySql
        #################################################################################################### 

        # Conectamos con BD
        include 'conexionBD.php';


        $result = mysqli_query($link, "SELECT * FROM BDAltasCandi");

        ####################################################################################################
        # Si ha pulsado el botón hacemos la búsqueda pedida
        ####################################################################################################    
            
         if ($_POST[Buscar]) { 
             
            $consulta_mysql="select * from BDAltasCandi where CategoriasInteres like '%" .$_POST[CategoriasInteres]. "%' and Pais like '%" .$_POST[Pais]. "%'";

            $resultado_consulta_mysql=mysqli_query($link, $consulta_mysql);
            
             while (($fila = mysqli_fetch_array($resultado_consulta_mysql))!=NULL){


                       printf("<tr> 
                       <td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href=\"VerRegistro.php?id=%d\"> Ver registro </a></td>
                            </tr>",          
                        $fila['Nombre'], $fila['Apellidos'], $fila['Pais'], $fila['Provincia'], $fila['Municipio'],
                        $fila['CategoriasInteres'],
                        $fila['id']);

                    }

                    # Libero la memoria asociada a result y cierro base de datos
                    mysqli_free_result($resultado_consulta_mysql);

                    # Desconectamos BD  
                    include 'desconexionBD.php';
 
            }  
            
        ####################################################################################################
        # Listamos toda la base de datos
        ####################################################################################################    
        if (!$_POST[Buscar]){  
            
            while (($fila = mysqli_fetch_array($result))!=NULL){
        ?>
                    
        <div class="row show-Migrid">
            

            <div class="col-md-2"> <?php echo $fila['Nombre'];?> <br/> </div>
            <div class="col-md-2"> <?php echo $fila['Apellidos'];?> <br/> </div>
            <div class="col-md-2"> <?php echo $fila['Pais'];?> <br/> </div>
            <div class="col-md-2"> <?php echo $fila['Provincia'];?> <br/> </div>
            <div class="col-md-2"> <?php echo $fila['Municipio'];?> <br/> </div>
            <div class="col-md-2"> <?php echo $fila['id'];?><a href="./VerRegistro.php?id=<?php echo $fila['id'];?>" > Ver registro </a> <br/> </div>

        </div>

        <?php 
            }


            # Libero la memoria asociada a result y cierro base de datos
            mysqli_free_result($result);
            
            # Desconectamos BD  
            include 'desconexionBD.php';

        } 


        ?>


            
 
            
    </body>
</html>



