<?php
 echo "<h1>Prueba connecion a base de datos</h1>";
$mysqli = new mysqli("host_mariadb", "root", "custom.2023", "custom_db");

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MYSQL: ( " . $mysqli->connect_errno . " )" . $mysqli->connect_errno;
}

echo $mysqli->host_info . "<br />";

$mysqli = new mysqli("host_mariadb", "root", "custom.2023", "custom_db", 3306);

if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MYSQL con puerto 3306: ( " . $mysqli->connect_errno . " )" . $mysqli->connect_errno;
}

echo $mysqli->host_info . "<br />";

// Verificar si la tabla ya existe
$check_table = "SHOW TABLES LIKE 'users'";
$table_result = $mysqli->query($check_table);

// Si la tabla no existe, crearla
if ($table_result->num_rows == 0) {
    // Crear tabla
    $create_table = "CREATE TABLE users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )";

    if ($mysqli->query($create_table) === TRUE) {
        echo "Tabla creada con éxito.";

        // insertar 5 registros

        // Crear arreglo con los valores a insertar
        $values = array("'John'", "'Jane'", "'Mike'", "'Emily'", "'Jessica'");

        // Crear consulta de inserción
        $insert_query = "INSERT INTO users (name) VALUES (" . implode("), (", $values) . ")";

        // Ejecutar consulta
        if ($mysqli->query($insert_query) === TRUE) {
            echo "Registros insertados con éxito.";
        } else {
            echo "Error al insertar registros: " . $mysqli->error;
        }
    } else {
        echo "Error al crear tabla: " . $mysqli->error;
    }
} else {
    echo "La tabla ya existe.";
}

// Crear consulta
$sql = "SELECT * FROM users";
$result = $mysqli->query($sql);

// Obtener resultados
if ($result->num_rows > 0) {
    echo "<h1>Registros retornados</h1><br />";
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
    }
} else {
    echo "No hay resultados.";
}

// Cerrar conexión
$mysqli->close();
