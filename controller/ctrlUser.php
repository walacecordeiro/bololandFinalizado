<?php
require_once("dao.php");
//Perfil do Usuario --------------------------------------
$user = array(
    "nome" => trim(""),
    "email" => trim(""),
    "tel" => trim(""),
    "numero" => trim(""),
    "complemento" => trim(""),
    "senha" => trim(""),
    "confsenha" => trim(""),
    "cep"  => trim(""),
    "logradouro" => trim(""),
    "bairro" => trim(""),
    "cidade" => trim(""),
    "uf" => trim(""),
    "id_user" => trim("")
);

//Action -------------------------------------------------
if (!empty($_REQUEST["action"])) {

    switch ($_REQUEST["action"]) {
        case "log":
            $user["email"] = trim($_POST["email"]);
            $user["senha"] = crypt(trim($_POST["pws"]), $user["email"]);
            login($user);
            break;

        case "off":
            logout();
            break;

        case "getUser":
            $user = get($_GET['id']);
            break;

        case "edit":
            $user = pojo();
            if (edit($user)) {
                aviso("Usuario atualizado!");
                $user = get($_POST['id_user']);
            } else {
                erro("Erro ao atualizar!");
            }
            break;

        case "add":
            $user = pojo();
            var_dump($user);
            $erros = validar($user);
            if ($erros == "") {
                if (add($user)) {
                    aviso("Usuario Cadastrado!");
                } else {
                    erro("Erro ao Cadastrado!");
                }
            } else {
                erro($erros);
            }
            break;
    }
}

//Functions ----------------------------------------------
function pojo()
{
    $user['nome'] = trim($_POST["nome"]);
    $user['email'] = trim($_POST["email"]);
    $user['tel'] = trim($_POST["tel"]);
    $user['numero'] = trim($_POST["numero"]);
    $user['complemento'] = trim($_POST["complemento"]);
    $user['cep'] = trim($_POST["cep"]);
    $user['logradouro'] = trim($_POST["logradouro"]);
    $user['bairro'] = trim($_POST["bairro"]);
    $user['cidade'] = trim($_POST["cidade"]);
    $user['uf'] = trim($_POST["uf"]);

    if (!empty($_POST["senha"])) {
        $user['senha'] = crypt(trim($_POST["senha"]), $user['email']);
        $user['confsenha'] = trim($_POST["confsenha"]);
    } else {
        $user['id_user'] = trim($_POST["id_user"]);
    }
    return $user;
}

function login($usuario)
{
    $sql = "select id_user, nome, email, foto from usuario where email = '$usuario[email]' and senha = md5('$usuario[senha]') and ativo";
    $result = query($sql);

    if (mysqli_num_rows($result) == 1) {
        //aviso("Usuario encontrado");
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION["user"] = mysqli_fetch_array($result);

        header('Location: index.php');
    } else {
        erro("Usuario não encontrado");
    }
}

function logout()
{
    // if(session_status() !== PHP_SESSION_ACTIVE){
    //     session_start();
    // }
    //Ternarios
    session_status() !== PHP_SESSION_ACTIVE ? session_start() : "";
    session_destroy();

    header('Location: index.php');
}

function get($id)
{
    $sql = "select * from usuario, endereco where id_user = $id and usuario.cep = endereco.cep";
    return mysqli_fetch_array(query($sql));
}

function edit($user)
{
    //Enviar Foto
    require_once("files.php");
    if (!empty($_FILES["foto"])) {
        $novaFoto = upload("img/perfil/", $_FILES["foto"]);
    } else {
        $novaFoto = $user['foto'];
    }

    //busca do cep
    buscaCep($user);

    $sql = "update usuario set
                nome = '$user[nome]',
                email = '$user[email]',
                tel = '$user[tel]',
                numero = '$user[numero]',
                complemento = '$user[complemento]',
                cep = '$user[cep]',
                foto = '$novaFoto'
                where id_user = $user[id_user] and ativo;";
   
    return query($sql);
}

function add($user)
{
    $sqlUser = "insert into usuario (nome, email, tel, numero, complemento, senha, cep, tipo) values ('$user[nome]', '$user[email]', '$user[tel]', '$user[numero]', '$user[complemento]', md5('$user[senha]'), '$user[cep]', (select id_tipo from tipo where tipo = 'cliente'))";

    buscaCep($user);

    return query($sqlUser);
}

function validar($user)
{
    $erros = "";
    if ($user['nome'] == "") {
        $erros .= "Nome em branco.<br>";
    }
    if ($user['email'] == "") {
        $erros .= "E-mail em branco.<br>";
    }
    if ($user['senha'] == "") {
        $erros .= "Senha em branco.<br>";
    } else if (strlen($user['senha']) < 7) {
        $erros .= "Senha muito curta. Minimo de 8 caracteres.<br>";
    } else if ($user['senha'] != $user["confsenha"]) {
        $erros .= "Senhas diferentes.<br>";
    }
    return $erros;
}

//Endereco
function buscaCep($user)
{
    //Comandos do Banco de Dados: SQL
    $sqlBuscaCep = "select cep from endereco where cep = $user[cep]";
    $sqlCep = "insert into endereco (cep, logradouro, bairro, cidade, uf) values ('$user[cep]' , '$user[logradouro]', '$user[bairro]', '$user[cidade]', '$user[uf]')";
    
    //Conecta o banco de dados
    $conn = mysqli_connect(LOCAL, USER, PASS, BASE);
    mysqli_set_charset($conn, "utf8");

    //Busca do CEP (Endereco) e guarda no $result
    $result = mysqli_query($conn, htmlspecialchars($sqlBuscaCep)) or die(mysqli_error($conn));

    //Se o resultado da busca do CEP for igual a 0
    if (mysqli_num_rows($result) == 0) {
        //Cadastro do CEP (Endereco)
        mysqli_query($conn, htmlspecialchars($sqlCep)) or die(mysqli_error($conn));
    }
}