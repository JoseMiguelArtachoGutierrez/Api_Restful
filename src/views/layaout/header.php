<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página</title>
    <style>
        *{
            margin: 0;
            padding: 0;

        }
        header{
            color: white;
            height: 15vh;
            background-color: #333333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }
        /* Estilo para el encabezado (h1) */
        .header {
            font-size: 24px;
            color: white;
            text-align: center;
        }

        /* Estilo para la lista no ordenada (ul) */
        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Estilo para los elementos de la lista (li) */
        .nav-item {
            display: inline-block;
            margin-right: 10px;
        }

        /* Estilo para los enlaces (a) */
        .nav-link {
            text-decoration: none;
            background-color: white;
            color: black;
            font-weight: bold;
            padding: 5px 10px;

            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Estilo para los enlaces cuando se pasan por encima (hover) */
        .nav-link:hover {
            background-color: #000;
            color: #fff;
        }

    </style>
</head>
<body>
<header>
    <h1 class="header">Api_Restful</h1>

    <ul class="nav-list">
        <li class="nav-item"><a href="<?=BASE_URL?>" class="nav-link">Inicio</a></li>
        <?php if (isset($_SESSION['identity'])): ?>
            <li class="nav-item"><a href="<?=BASE_URL?>Apiponente/documentacion/" class="nav-link">Documentacion</a></li>
            <li class="nav-item"><a href="<?=BASE_URL?>Usuario/logout/" class="nav-link">Cerrar Sesion</a></li>
        <?php else: ?>
            <li class="nav-item"><a href="<?=BASE_URL?>Usuario/identificarse/" class="nav-link">Identificarse</a></li>
            <li class="nav-item"><a href="<?=BASE_URL?>Usuario/registro/" class="nav-link">Registro</a></li>
        <?php endif; ?>
    </ul>
</header>


</body>
</html>
