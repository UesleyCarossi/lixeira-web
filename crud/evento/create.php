<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <title>Adicionar Evento</title>
</head>

<body>
    <div class="container">
        <div clas="span10 offset1">
          <div class="card">
            <div class="card-header">
                <h3 class="well"> Adicionar Evento </h3>
            </div>
            <div class="card-body">
            <form class="form-horizontal" action="create.php" method="post" multipart enctype="multipart/form-data">

                <div class="control-group <?php echo !empty($nomeErro)?'error ' : '';?>">
                    <label class="control-label">Nome</label>
                    <div class="controls">
                        <input size="50" class="form-control" name="nome" type="text" placeholder="Nome" required="" value="<?php echo !empty($nome)?$nome: '';?>">
                        <?php if(!empty($nomeErro)): ?>
                            <span class="help-inline"><?php echo $nomeErro;?></span>
                            <?php endif;?>
                    </div>
                </div>

                <div class="control-group <?php echo !empty($dataErro)?'error ': '';?>">
                    <label class="control-label">Data</label>
                    <div class="controls">
						<input class="form-control" name="data" type="date" required="" value="<?php echo !empty($data)?$data: '';?>">
                        <?php if(!empty($dataErro)): ?>
                            <span class="help-inline"><?php echo $dataErro;?></span>
                            <?php endif;?>
                    </div>
                </div>
				
				<div class="control-group <?php echo !empty($imagemErro)?'error ': '';?>">
                    <label class="control-label">Imagem</label>
                    <div class="controls">
						<input class="form-control" name="imagem[]" type="file" required="" value="<?php echo !empty($imagem)?$imagem: '';?>" multiple >
                        <?php if(!empty($imagemErro)): ?>
                            <span class="help-inline"><?php echo $imagemErro;?></span>
                            <?php endif;?>
                    </div>
                </div>

                <div class="form-actions">
                    <br/>

                    <button type="submit" class="btn btn-success">Adicionar</button>
                    <a href="index.php" type="btn" class="btn btn-default">Voltar</a>

                </div>
            </form>
          </div>
        </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>

<?php
	function console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}

    require '../banco.php';

    if(!empty($_POST))
    {
        //Acompanha os erros de validação
        $nomeErro = null;
        $dataErro = null;
		$imagemErro = null;

        $nome = $_POST['nome'];
        $data = $_POST['data'];
		$imagem = $_FILES['imagem']['name'];

        //Validaçao dos campos:
        $validacao = true;
        if(empty($nome))
        {
            $nomeErro = 'Por favor digite o nome do evento!';
            $validacao = false;
        }

        if(empty($data))
        {
            $dataErro = 'Por favor digite a data do evento!';
            $validacao = false;
        }
		
		if(empty($imagem))
        {
            $dataErro = 'Por favor selecione pelo menos uma imagem!';
            $validacao = false;
        }
		
        //Inserindo no Banco:
        if($validacao)
        {
            $pdo = Banco::conectar();
			
			//evento
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO evento (nome, data) VALUES(?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome,$data));
			
			$last_id = $pdo->lastInsertId();
			console_log($last_id);
			
			//imagem
			$total = count($imagem);
			for( $i=0 ; $i < $total ; $i++ ) {
				
				$image_data = base64_encode(file_get_contents($_FILES['imagem']['tmp_name'][$i])); //SQL Injection defence!
				$image_name = addslashes($_FILES['imagem']['name'][$i]);
				
				$sql = "INSERT INTO evento_imagem (nome, data, evento) VALUES(?,?,?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($image_name,$image_data,$last_id));
			}
			
            Banco::desconectar();
            header("Location: index.php");
        }
    }
?>
