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
        background-color: #555555;
    }

    .message {
        color: #4caf50;
        font-weight: bold;
        margin-bottom: 15px;
    }

</style>

<body>
<?php
if (isset($_SESSION['register'])){
    echo $_SESSION['register'];
    unset($_SESSION['register']);
}

?>
    <h1>Registro</h1>
    <form action="<?=BASE_URL?>Usuario/crearUusario/" method="post">
        <label>Nombre: </label>
        <input type="text" name="data[nombre]"><br>
        <label>Apellidos: </label>
        <input type="text" name="data[apellidos]"><br>
        <label>Email: </label>
        <input type="text" name="data[email]"><br>
        <label>Password: </label>
        <input type="text" name="data[password]">
        <input type="submit" value="Registrarse">
    </form>
</body>