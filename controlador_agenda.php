<?php

function pegarContatos(){

    $contatosAuxiliar = file_get_contents('contatos.json');
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);
    return $contatosAuxiliar;

}

pegarContatos();

exit();


function cadastrar($nome){

    $contatos = pegarContatos();

    $contato = [
        'id'      => uniqid(),
        'nome'    => $nome,
        'email'   => $_POST['email'],
        'telefone'=> $_POST['telefone']
    ];
    array_push($contatos, $contato);
    $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);
    file_put_contents('contatos.json', $contatosJson);
    header("Location: index.php");
}

function excluirContato($id){

    $contatosAuxiliar = file_get_contents('contatos.json');
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);

    foreach ($contatosAuxiliar as $posicao => $contato){
        if($id == $contato['id']) {
            unset($contatosAuxiliar[$posicao]);
        }
    }
    $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
    file_put_contents('contatos.json', $contatosJson);

    header('Location: index.php');
}

//EDITAR CONTATO
function buscarContatoParaEditar($id_procurado){

    $contatosAuxiliar = file_get_contents('contatos.json');
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);

    foreach ($contatosAuxiliar as $contato){
        if ($contato['id'] == $id_procurado){
            return $contato;
        }
    }
}

function salvarContatoEditado($id){

    $contatosAuxiliar = file_get_contents('contatos.json');
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);

    foreach ($contatosAuxiliar as $posicao => $contato){

        if ($contato['id'] == $id){

            $contatosAuxiliar[$posicao]['nome'] = $_POST['nome'];
            $contatosAuxiliar[$posicao]['email'] = $_POST['email'];
            $contatosAuxiliar[$posicao]['telefone'] = $_POST['telefone'];

            break;
        }
    }
    $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);
    file_put_contents('contatos.json', $contatosJson);
    header('Location: index.php');
}

//ROTAS
if ($_GET['acao'] == 'cadastrar'){
    cadastrar($_POST['nome']);
} elseif ($_GET['acao'] == 'excluir'){
    excluirContato($_GET['id']);
} elseif ($_GET['acao'] == 'editar'){
    salvarContatoEditado($_GET['id']);
}