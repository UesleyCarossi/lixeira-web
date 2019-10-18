<?php

	require '../banco.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
    }

	if ( null==$id ) {
		header("Location: index.php");
    }

	if ( !empty($_POST)) {

		$nomeErro = null;
		$data = null;
		$img = null;

		$nome = $_POST['nome'];
		$data = $_POST['data'];
		$imagem = $_FILES['imagem']['name'];

		//Validação
		$validacao = true;
		if (empty($nome))
                {
                    $nomeErro = 'Por favor digite o nome!';
                    $validacao = false;
                }

		if (empty($data))
                {
                    $dataErro = 'Por favor digite a data!';
                    $validacao = false;
		}
		
		if(empty($imagem))
        {
            $dataErro = 'Por favor selecione pelo menos uma imagem!';
            $validacao = false;
        }

		// update data
		if ($validacao)
                {
                    $pdo = Banco::conectar();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE evento  set nome = ?, data = ? WHERE id = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($nome,$data,$id));
                    Banco::desconectar();
                    header("Location: index.php");
		}
	} else {
        $pdo = Banco::conectar();
		
		//evento
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM evento where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$nome = $data['nome'];
        $data = $data['data'];
		
		//imagem
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT ei.* FROM evento_imagem ei INNER JOIN evento e ON e.id = ei.evento where e.id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$id = $data['id'];
		$nome = $data['nome'];
        $imagem = $data['data'];
		
		Banco::desconectar();
	}
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
				<title>Atualizar Evento</title>
    </head>

    <body>
        <div class="container">

            <div class="span10 offset1">
							<div class="card">
								<div class="card-header">
                    <h3 class="well"> Atualizar Evento </h3>
                </div>
								<div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post" multipart enctype="multipart/form-data">

                    <div class="control-group <?php echo !empty($nomeErro)?'error':'';?>">
                        <label class="control-label">Nome</label>
                        <div class="controls">
                            <input name="nome" class="form-control" size="50" type="text" placeholder="Nome" value="<?php echo !empty($nome)?$nome:'';?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="help-inline"><?php echo $nomeErro;?></span>
                                <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($dataErro)?'error':'';?>">
                        <label class="control-label">Data</label>
                        <div class="controls">
							<input class="form-control" name="data" type="date" required="" value="<?php echo !empty($data)?$data: '';?>">
                            <?php if (!empty($dataErro)): ?>
                                <span class="help-inline"><?php echo $dataErro;?></span>
                                <?php endif; ?>
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

                    <br/>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Atualizar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
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
