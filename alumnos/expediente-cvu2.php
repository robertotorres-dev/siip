<?php
  require_once "../core/modelo-usuarios.php";
  require_once "modelo-cvu.php";
  
  session_start( );
  $obj = new Usuarios( );
  $obj->id_usuario = $_SESSION["id_usuario"];
  $obj->codigo = $_SESSION["codigo"];
  $obj->contrasena = $_SESSION["contrasena"];
  $obj->validarSession( );
  
  $exito = 0;
  if( is_uploaded_file( $_FILES["archivo"]["tmp_name"] ) )
  {
    if( $_FILES["archivo"]["size"]<5000000 )
    {
      if( $_FILES["archivo"]["type"]=="application/pdf" )
      {
        move_uploaded_file( $_FILES["archivo"]["tmp_name"], "../uploads/".$_FILES["archivo"]["name"] );
        $exito = 1;
      }
    }
  }
  
  if( $_FILES["archivo"]["name"]!=null && $exito==0 )
  {
    header( "Location: administracion-cvu.php?id_docente=".$_POST["id_docente"]."&error=1" );
    exit( );
  }
  
  $obj2 = new CVU( );
  $obj2->id_docente = $_POST["id_docente"];
  $obj2->descripcion = $_POST["descripcion"];
  $obj2->fecha = $_POST["fecha"];
  $obj2->archivo = $_FILES["archivo"]["name"];
  $obj2->status = 1;
  $obj2->agregarCVU( );
  
  header( "Location: expediente-cvu.php?id_docente=$obj2->id_docente" );
  exit( );
?>