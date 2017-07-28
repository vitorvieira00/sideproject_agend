<?php

function pegarContatos($busca = null){

    $contatosAuxiliar = file_get_contents('contatos.json');//pegando dados do arquivo json
    $dadosConvertidos = json_decode($contatosAuxiliar, true);//convertendo para um array

    $contatosEncontrados = array();

    if ($busca == null){
        return $dadosConvertidos;
    } else {
        foreach ($dadosConvertidos as $contato){
            if ($busca == $contato['nome']){
                $contatosEncontrados[] = $contato;
            }
        }

        return $contatosEncontrados;
    }
}

function converterDadosEredireciona($contatos){
    $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);//arrumar na hora de executar

    file_put_contents('contatos.json', $contatosJson);

    header("Location: index.php"); //voltar para a tela de index

}

function cadastrar($nome, $email, $telefone){
    $contatos = pegarContatos();
    $contato = [
        'id'      => uniqid(),//gerar um id diferente de todos os outros a cada vez que for atualizado
        'nome'    => $nome,
        'email'   => $email,
        'telefone'=> $telefone
    ];
    array_push($contatos, $contato);

    converterDadosEredireciona($contatos);
}

function excluirContato($id){

    $contatosAuxiliar = pegarContatos();//chama a função pegarContatos, que recebr o conteudo do arquivo, convertendo para um array e retornando esses valores

    foreach ($contatosAuxiliar as $posicao => $contato){
        if($id == $contato['id']) {
            unset($contatosAuxiliar[$posicao]);
        }
    }

    converterDadosEredireciona($contatosAuxiliar);
}
//EDITAR CONTATO
function buscarContatoParaEditar($id_procurado){

    $contatosAuxiliar = pegarContatos();//chama a função pegarContatos, que recebr o conteudo do arquivo, convertendo para um array e retornando esses valores

    foreach ($contatosAuxiliar as $contato){
        if ($contato['id'] == $id_procurado){
            return $contato;
        }
    }
}

//SALVAR CONTATO EDITADO
function salvarContatoEditado($id, $nome, $email, $telefone){

    $contatosAuxiliar = pegarContatos();//chama a função pegarContatos, que recebr o conteudo do arquivo, convertendo para um array e retornando esses valores

    foreach ($contatosAuxiliar as $posicao => $contato){
        if ($contato['id'] == $id){
            $contatosAuxiliar[$posicao]['nome'] = $nome;
            $contatosAuxiliar[$posicao]['email'] = $email;
            $contatosAuxiliar[$posicao]['telefone'] = $telefone;
            break;
        }
    }

    converterDadosEredireciona($contatosAuxiliar);
}

//GERENCIAMENTO DE ROTAS
if ($_GET['acao'] == 'cadastrar'){
    cadastrar($_POST['nome'], $_POST['email'], $_POST['telefone']);
} elseif ($_GET['acao'] == 'excluir'){
    excluirContato($_GET['id']);
} elseif ($_GET['acao'] == 'editar'){
    salvarContatoEditado($_GET['id'], $_POST['nome'], $_POST['email'], $_POST['telefone']);
}