<?php
    require '../banco.php';
    $id = null;
    if(!empty($_GET['id']))
    {
        $id = $_REQUEST['id'];
    }

    if(null==$id)
    {
        header("Location: index.php");
    }
    else
    {
       $pdo = Banco::conectar();
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM evento where id = ?";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $data = $q->fetch(PDO::FETCH_ASSOC);
       Banco::desconectar();
    }
	
	function list_imagem(){
		
		$id = null;
		if(!empty($_GET['id']))
		{
			$id = $_REQUEST['id'];
		}
		
	   $pdo = Banco::conectar();
	   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $sql = "SELECT * FROM evento_imagem where evento = ? order by id asc";
       $q = $pdo->prepare($sql);
       $q->execute(array($id));
       $data = $q->fetchAll(PDO::FETCH_ASSOC);
		
	   if (count($data) > 0) { 
		   
			foreach ($data as $row) {
				echo '<div>';
				echo '	<img src="data:image/jpg;base64,' . $row['data'] . '" value="' . $row['id'] . '" />';
				echo '</div>';
				
			}
			
	   }
	   
	   
	   Banco::desconectar();
	}
	
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <title>Informações do Evento</title>
		<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
		<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
    </head>

    <body>
        <div class="container">
            <div class="span10 offset1">
                  <div class="card">
    					<div class="card-header">
                    <h3 class="well">Informações do Evento</h3>
                </div>
                <div class="container">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['nome'];?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Data</label>
                        <div class="controls">
                            <label class="carousel-inner">
                                <?php echo $data['data'];?>
                            </label>
                        </div>
                    </div>
					
					<div>
						<?php list_imagem() ?>
					</div>
                    
                    <br/>
                    <div class="form-actions">
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                  </div>
                  </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="../assets/js/bootstrap.min.js"></script>
		<style>
		img {
			width: 100%;
			margin: 5px;
		}
		</style>
    </body>

    </html>
