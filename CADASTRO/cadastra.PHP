<?php
//CRIAR CONEXÃO

 define('HOST','localhost');
 define('USER','root');
 define('PASS','');
 define('BASE','cadlogin');

$conn = new MySQLi(HOST,USER,PASS,BASE);
if(!$conn){
    echo "<p: style='color:red; text-align:center; font-size:25px;'>ERRO DE CONEXÃO!</p>";
    }

//VERIFICAR SE O FORMULARIO FOI SUBMETIDO

if($_SERVER["REQUEST_METHOD"]=="POST"){
    //RECUPERA OS VALORES DO FORMULARIO

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $confirmasenha = $_POST["confirmaSenha"];

//VERIFICAR SE A SENHA E A CONFIRMAÇÃO SÃO IGUAIS

if($senha === $confirmasenha){
    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
    $retorno = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($retorno);

    if($row){
        print "<script>alert('USUÁRIO JÁ EXISTE!');</script>";
    } else {
        $hashsenha = password_hash ($senha,PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuario (usuario, senha) values ('$usuario', '$hashsenha')";
        $retorno = mysqli_query($conn,$sql);
        
        if($retorno === true){
            print "<script>alert('CADASTRO REALIZADO. AVANCE PARA O LOGIN');</script>";
            print "<script>location.href='login.html';</script>";
         } else{
            echo"ERRO AO CADASTRAR USUARIO". $conn->error;
         }
     
    }
} else {
    print "<script>alert('AS SENHAS NÃO COINCIDEM!');</script>";
}

}
$conn->close();

?>
