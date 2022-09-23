<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de carros</title>

    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        td img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            aspect-ratio: 1;
        }

        #form {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 32px auto;
            gap: 8px;
        }


        #form button, #form input {
            border: none;
            border-radius: 5px;
        }

        #form input {
            padding: 8px;
            border: 1px solid #64DDBB;
        }

        #form button {
            padding: 8px 32px;
            background: #64DDBB;
            color: #FFF;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <form method="POST" id="form">
        <div>
            <input type="search" placeholder="Buscar por nome, email, sexo, status, descrição ou profissão..." name="busca" />
        </div>
        <button type="submit">Procurar</button>
    </form>
    
</body>
</html>

<?php
    include 'banco.php';
    $sql = "SELECT * FROM employee;";
    if (isset($_POST['busca'])) {
        $searchTerm = $_POST['busca'];
        $searchByEmail = "OR email LIKE '%" . $searchTerm . "%'";
        $searchByGender = "OR gender LIKE '%" . $searchTerm . "%'";
        $searchByJob = "OR job LIKE '%" . $searchTerm . "%'";
        $searchByDescription = "OR description_of_office LIKE '%" . $searchTerm . "%'";
        $searchByStatus = "OR status LIKE '%" . $searchTerm . "%';";
        $sql = "SELECT * FROM employee WHERE name LIKE '%" . $searchTerm . "%'" . $searchByEmail . $searchByGender . $searchByJob . $searchByDescription . $searchByStatus;
    }
    $pdo = Banco::conectar();
    $sql = $pdo->prepare($sql);
    $sql->execute();

    $employeeList = $sql->fetchAll();
    echo '<table>';
        echo '<tr>';
            echo '<th>Nome</th>';
            echo '<th>Sobrenome</th>';
            echo '<th>email</th>';
            echo '<th>Celular</th>';
            echo '<th>Gênero</th>';
            echo '<th>Cargo</th>';
            echo '<th>cpf</th>';
            echo '<th>Salario</th>';
            echo '<th>Shift</th>';
            echo '<th>Descrição de cargo</th>';
            echo '<th>Status</th>';
            echo '<th>Foto</th>';
        echo '</tr>';
    for ($index = 0; $index < COUNT($employeeList); $index++) {
        echo '<tr>';
            echo '<td>' . $employeeList[$index]['name'] . '</td>';
            echo '<td>' . $employeeList[$index]['last_name'] . '</td>';
            echo '<td>' . $employeeList[$index]['email'] . '</td>';
            echo '<td>' . $employeeList[$index]['phone'] . '</td>';
            echo '<td>' . $employeeList[$index]['gender'] . '</td>';
            echo '<td>' . $employeeList[$index]['job'] . '</td>';
            echo '<td>' . $employeeList[$index]['cpf'] . '</td>';
            echo '<td>' . $employeeList[$index]['salary'] . '</td>';
            echo '<td>' . $employeeList[$index]['shift'] . '</td>';
            echo '<td>' . $employeeList[$index]['description_of_office'] . '</td>';
            echo '<td>' . $employeeList[$index]['status'] . '</td>';
            echo '<td> <img src="' . $employeeList[$index]['status'] . '" alt="foto de perfil" width="250px" height="250px" /> </td>';
        echo '</tr>';
    }
    echo '</table>';
?>