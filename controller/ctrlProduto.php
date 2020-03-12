<?php
require_once("dao.php");
//Perfil do Produto --------------------------------------
$prod = array(
    "nome" => "",
    "descricao" => "",
    "quant" => "",
    "valor" => "",
    "foto1" => null,
    "foto2" => null,
    "foto3" => null,
    "foto4" => null,
    "foto5" => null,
    "id_produto" => null
);

//Action -------------------------------------------------
if (!empty($_REQUEST["action"])) {

    switch ($_REQUEST["action"]) {
        case "log":
            $prod["email"] = trim($_POST["email"]);
            $prod["senha"] = crypt(trim($_POST["pws"]), $prod["email"]);
            login($prod);
            break;

        case "off":
            logout();
            break;

        case "getProd":
            $prod = get($_GET['id']);
            break;

        case "edit":
            $prod = pojo();
            if (edit($prod)) {
                aviso("Produto atualizado!");
                $prod = get($_POST['id_produto']);
            } else {
                erro("Erro ao atualizar!");
            }
            break;

        case "add":
            $prod = pojo();
            $erros = validar($prod);
            if ($erros == "") {
                if (add($prod)) {
                    aviso("Produto Cadastrado!");
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
function get($id)
{
    $sql = "select * from produto, endereco where id_produto = $id";
    return mysqli_fetch_array(query($sql));
}

function edit($prod)
{

    $prod['foto1'] = enviarFoto($_FILES['foto1']);
    $prod['foto2'] = enviarFoto($_FILES['foto2']);
    $prod['foto3'] = enviarFoto($_FILES['foto3']);
    $prod['foto4'] = enviarFoto($_FILES['foto4']);
    $prod['foto5'] = enviarFoto($_FILES['foto5']);

    

    $sql = "update produto set
                nome = '$prod[nome]',
                descricao = '$prod[descricao]',
                quant = '$prod[quant]',
                valor = '$prod[valor]',
                ativo = '$prod[ativo]'
                ";
    if ($prod['foto1'] != null)
        $sql .= ",foto1 = '$prod[foto1]' ";

    if ($prod['foto2'] != null)
        $sql .= ",foto2 = '$prod[foto2]' ";

    if ($prod['foto3'] != null)
        $sql .= ",foto3 = '$prod[foto3]' ";

    if ($prod['foto4'] != null)
        $sql .= ",foto4 = '$prod[foto4]' ";

    if ($prod['foto5'] != null)
        $sql .= ",foto5 = '$prod[foto5]' ";

    $sql .= " where id_produto = $prod[id_produto];";

    var_dump($sql);

    $conn = mysqli_connect(LOCAL, USER, PASS, BASE);
    mysqli_set_charset($conn, "utf8");
    $result = mysqli_query($conn, htmlspecialchars($sql)) or die(mysqli_error($conn));
    return $result;
}

function pojo()
{
    $prod['nome'] = trim($_POST["nome"]);
    $prod['descricao'] = trim($_POST["descricao"]);
    $prod['valor'] = trim($_POST["valor"]);
    $prod['quant'] = trim($_POST["quant"]);
    isset($_POST['ativo'])? $prod['ativo'] = 1 : $prod['ativo'] = 0;
    $prod['id_produto'] = trim($_POST["id_produto"]);
    return $prod;
}

function add($prod)
{
    $prod['foto1'] = enviarFoto($_FILES['foto1']);
    $prod['foto2'] = enviarFoto($_FILES['foto2']);
    $prod['foto3'] = enviarFoto($_FILES['foto3']);
    $prod['foto4'] = enviarFoto($_FILES['foto4']);
    $prod['foto5'] = enviarFoto($_FILES['foto5']);

    $sqlprod = "insert into Produto (nome, descricao, quant, valor, ativo, foto1, foto2, foto3, foto4, foto5) values ('$prod[nome]', '$prod[descricao]', '$prod[quant]', '$prod[valor]', '$prod[ativo]', '$prod[foto1]', '$prod[foto2]', '$prod[foto3]', '$prod[foto4]', '$prod[foto5]')";

    return query($sqlprod);
}

function validar($prod)
{
    $erros = "";
    if (empty($_FILES['foto1'])) {
        $erros .= "Foto em branco.<br>";
    }
    if ($prod['nome'] == "") {
        $erros .= "Nome em branco.<br>";
    }
    if ($prod['descricao'] == "") {
        $erros .= "Descrição em branco.<br>";
    }
    if ($prod['quant'] < 0) {
        $erros .= "Quantidade negativa.<br>";
    }
    if ($prod['valor'] < 0) {
        $erros .= "Valor negativa.<br>";
    }
    return $erros;
}

function enviarFoto($foto)
{
    //Enviar Foto
    require_once("files.php");
    if (!empty($foto))
        return upload("img/ofertas/", $foto);
    return $null;
}

function getAll()
{
    $sql = "select * from produto"; // and ativo";
    return query($sql);
}
