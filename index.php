<?php
require 'controlador_agenda.php';

if(isset($_GET['buscar'])){
    $meusContatos = pegarContatos($_GET['buscar']);

}else{
    $meusContatos = pegarContatos();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container" style="margin-top: 30px;">

    <h3>MINHA AGENDA DE CONTATOS</h3>
    <br />
    
    <form method="get">
        <input type="text" name="buscar">
        <input type="submit">
    </form>
    <br>

    <!-- CADASTRO-->
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" method="post" action="controlador_agenda.php?acao=cadastrar">

                <!--nome-->
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input name="nome" type="text" class="form-control" id="nome">
                </div>

                <!--email-->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>

                <!--telefone-->
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input name="telefone" type="text" class="form-control" id="telefone">
                </div>

                <button type="submit" class="btn btn-default">CADASTRAR</button>

            </form>
        </div>
    </div>

    <br />

    <!--CONTATOS-->
    <div class="row">
        <div class="col-md-12">

            <!-- Conteúdo -->
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>id</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>acoes</th>
                </tr>
                </thead>
                <tbody>
                <!-- repetir -->
                <?php foreach ($meusContatos as $contato): ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?= $contato['id']?></td>
                        <td><?= $contato['nome']?></td>
                        <td><?= $contato['email'] ?></td>
                        <td><?= $contato['telefone'] ?></td>
                        <td>
                            <a href="controlador_agenda.php?acao=excluir&id=<?= $contato['id'] ?>">excluir</a>
                            <a href="formulario_editar_agenda.php?id=<?= $contato['id']?>"> editar</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>