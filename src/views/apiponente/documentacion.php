<style>
    button{
        margin-left: 100px;
        margin-top: 50px;
        background-color: #333333;
        color: white;
        padding: 20px;
        border-radius: 10px;
    }
    button>a{
        width: 100%;
        color: white;
        text-decoration: none;
        height: 100%;
    }
    button:hover{
        background: white;
    }
    button:hover>a{
        color: black;
        background: white;
    }
    p{
        text-align: center  ;

        width: 20%;
        color: black;
    }
</style>
<br>
<button><a href="<?=BASE_URL?>Usuario/generarNuevoToken/">Generar Token</a></button>
<?php
if (isset($_SESSION['generarToken'])){
    echo "<p> ".$_SESSION['generarToken']."</p>";
    unset($_SESSION['generarToken']);
}
?>