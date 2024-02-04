<style>


    h1 {
        text-align: center;
        color: black;
    }

    form {

        max-width: 400px;
        margin: 0 auto;
        margin-top: 50px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 20px black;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #333333;
        color: #fff;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #333333;
    }

    .message {
        color: #333333;
        font-weight: bold;
        margin-bottom: 15px;
    }

</style>

<body>
<?php
if (isset($_SESSION['login'])){
    echo $_SESSION['login'];
    unset($_SESSION['login']);
}

?>
<h1>Iniciar Sesion</h1>
    <form action="<?=BASE_URL?>Usuario/login/" method="post">
        <label>Email: </label>
        <input type="text" name="data[email]"><br>
        <label>Password: </label>
        <input type="text" name="data[password]">
        <input type="submit" value="Iniciar Sesion">
    </form>
</body>