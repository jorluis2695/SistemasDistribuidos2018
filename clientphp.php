<?php
$GLOBALS['THRIFT_ROOT']= '/home/ubuntu/thrift/thrift-0.11.0/lib/php/lib';
require_once "/home/ubuntu/gen-php/Types.php";
require_once "/home/ubuntu/gen-php/Gifsv.php";

require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Transport/TTransport.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Transport/TSocket.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Protocol/TProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Transport/TBufferedTransport.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Type/TMessageType.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Factory/TStringFuncFactory.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/StringFunc/TStringFunc.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/StringFunc/Core.php';
require_once $GLOBALS['THRIFT_ROOT'].'/Thrift/Type/TType.php';
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TSocket;
use Thrift\Transport\TSocketPool;
use Thrift\Transport\TFramedTransport;


$host='127.0.0.1';
$port='9999';
$socket= new Thrift\Transport\TSocket($host,$port);
$socket->setSendTimeout(60000);
$socket->setRecvTimeout(60000);
$transport= new TBufferedTransport($socket);
$protocol= new TBinaryProtocol($transport);
$cliente= new GifsvClient($protocol);
$transport->open();
?>
<html lang="en">
<head>
  <title>GIFs POPULARES</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!--   <link rel="stylesheet" href="css/main.css">   -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>
<body>
<script type="text/javascript">
function submitform()
{
    document.forms["myform"].submit();
}
</script>

<?php
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
function data_uri($file, $mime) 
{  
  //$contents = file_get_contents($file);
  $base64   = base64_encode($file); 
  return ('data:' . $mime . ';base64,' . $base64);
}
debug_to_console("Prueba de mensaje");
//debug_to_console("".$cliente->TopGifs("todos"));


?>
    <div class="jumbow3-container jumbotron justify-content-md-center w3-mobile">
      	<h1>Proyecto de Sistemas Distribuidos</h1>
      	<img src="img/logo.png" align="left">
        <div class="col sombra" align="center" >
	        <p class="lead" >Grupo:	</p>
	        <div class="" align="center">
				<li class="lead">Jorge Cedeno</li>
				<li class="lead">Daniel Villalba</li>
			</div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="myform">
		        <input type=submit name="categoria" class="btn btn-lg btn-primary" href="#" value="Top 10 General">
			<input type=submit name="categoria" class="btn btn-lg btn-primary" href="#" value="Top 10 Gatos">
			<input type=submit name="categoria" class="btn btn-lg btn-primary" href="#" value="Top 10 Perros">
			<input type=submit name="categoria" class="btn btn-lg btn-primary" href="#" value="Top 10 Deportes">		        

		    </form>
        </div>
    </div>
    	<section class="text-center"> 
    <div class="row" >
    	<div class="col-xs-12" >
    		
	
    		<?php
		if($_SERVER["REQUEST_METHOD"]== "POST"){
                debug_to_console("Metodo Post Ejecutado");
                debug_to_console($_POST['categoria']);
                if($_POST['categoria'] == "Top 10 General"){
			debug_to_console("Click a todos");
                        $topGifs=array();
                        $topGifs=$cliente->TopGifs("todos");
                        debug_to_console("Click a todos");
                        //return $topGifs;
                }
                else if($_POST['categoria'] =="Top 10 Gatos"){
                         $topGifs=array();
                         $topGifs=$cliente->TopGifs("cat");
                        debug_to_console("Click a cat"); 
                        //return $topGifs;
                }
                else if($_POST['categoria'] == "Top 10 Perros"){
                         $topGifs=array();
                        $topGifs=$cliente->TopGifs("dog");
                        debug_to_console("Click a dog");                        
                        //return $topGifs;       
                 }
                else if($_POST['categoria'] == "Top 10 Deportes"){
                        $topGifs=array();
                        $topGifs=$cliente->TopGifs("sports");
                        debug_to_console("Click a sports");
                        //return $topGifs;
               }
		echo " <h3>" . $_POST['categoria'] ." </h3>";

		echo "<table class='table table-striped'>";
		//$topGifs = $cliente->TopGifs("sports");
        	echo "<tr>";
		$count = 0;        	
		foreach($topGifs as $imagenGif){
                     	$count = $count + 1;
			echo "<td><img src=" . data_uri($imagenGif,'image/gif')  ." width='250' height='250'></td>";
			if($count == 4)
			{
				echo "</tr><tr>";
			}
			else if($count == 8)
                        {
                                echo "</tr><tr>";
                        }
			//debug_to_console($imagenGif);
		}
		echo "</tr>";
    		echo "</table>";
}	
	?>
    	</div>
    </div>
    </section>
</body>
</html>
