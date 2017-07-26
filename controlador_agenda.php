<?php
function pegarContatos(){
    $contatosAuxiliar = file_get_contents('contatos.json');//guardando os resultados
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);//convertendo para um array
    return $contatosAuxiliar;
}

function cadastrar($nome){
    $contatos = pegarContatos();
    $contato = [
        'id'      => uniqid(),//gerar um id diferente de todos os outros a cada vez que for atualizado
        'nome'    => $nome,
        'email'   => $_POST['email'],
        'telefone'=> $_POST['telefone']
    ];
    array_push($contatos, $contato);
    $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);//arrumar na hora de executar
    file_put_contents('contatos.json', $contatosJson);
    header("Location: index.php");
}
function excluirContato($id){
    $contatosAuxiliar = file_get_contents('contatos.json');//guardando os resultados
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);//convertendo para um array
    foreach ($contatosAuxiliar as $posicao => $contato){
        if($id == $contato['id']) {
            unset($contatosAuxiliar[$posicao]);
        }
    }
    $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);//arrumar na hora de executar
    file_put_contents('contatos.json', $contatosJson);
    header('Location: index.php');
}
//EDITAR CONTATO
function buscarContatoParaEditar($id_procurado){
    $contatosAuxiliar = file_get_contents('contatos.json');//guardando os resultados
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);//convertendo para um array
    foreach ($contatosAuxiliar as $contato){
        if ($contato['id'] == $id_procurado){
            return $contato;
        }
    }
}
function salvarContatoEditado($id){
    $contatosAuxiliar = file_get_contents('contatos.json');//guardando os resultados
    $contatosAuxiliar = json_decode($contatosAuxiliar, true);//convertendo para um array
    foreach ($contatosAuxiliar as $posicao => $contato){
        if ($contato['id'] == $id){
            $contatosAuxiliar[$posicao]['nome'] = $_POST['nome'];
            $contatosAuxiliar[$posicao]['email'] = $_POST['email'];
            $contatosAuxiliar[$posicao]['telefone'] = $_POST['telefone'];
            break;
        }
    }
    $contatosJson = json_encode($contatosAuxiliar, JSON_PRETTY_PRINT);//arrumar na hora de executar
    file_put_contents('contatos.json', $contatosJson);
    header('Location: index.php');
}
//GERENCIAMENTO DE ROTAS
if ($_GET['acao'] == 'cadastrar'){
    cadastrar($_POST['nome']);
} elseif ($_GET['acao'] == 'excluir'){
    excluirContato($_GET['id']);
} elseif ($_GET['acao'] == 'editar'){
    salvarContatoEditado($_GET['id']);
}