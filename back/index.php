<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "lojati" : "teste");



function teste() {
    echo "API respondendo com sucesso!";
}

function createClientes($con){
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
    $endereco = $_POST["endereco"] ?? "";

    try{
        $stmt = $con->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?,?,?,?)");
        $stmt -> execute([$nome, $email, $telefone, $endereco]);
        echo "Cliente cadastrado com sucesso!";
    }catch(PDOException $e){
        echo $e;
    }
    exit;
}
function readClientes($con){
    header("Content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
echo $rota;
echo $_SERVER["REQUEST_METHOD"];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    createClientes($con);
}elseif ($rota == "clientes"){
    readClientes($con);
}else {
    teste();
}


?>