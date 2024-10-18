<?php
// Datos de la conexión a la base de datos
$host = 'mysql-sistema10.alwaysdata.net';
$dbname = 'sistema10_escolar';
$username = 'sistema10'; // Cambia el usuario si es diferente
$password = 'SistemaGestor00';     // Cambia la contraseña si es diferente

try {
    // Crear conexión con PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Establecer el modo de error de PDO para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los CURPs
    $sql = "SELECT curp FROM alumnos_lista";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener todos los resultados como un array
    $curps = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generar el formato de INSERT
    echo "INSERT INTO alumnos_lista (id, curp)\nVALUES\n";

    // Inicializar el ID en 30
    $id = 1;

    // Recorrer el array de CURPs para generar los valores de INSERT
    $values = [];
    foreach ($curps as $row) {
        $curp = $row['curp'];
        $values[] = "($id, '$curp')"; // Asignar ID incremental y CURP
        $id++; // Incrementar el ID en cada iteración
    }

    // Imprimir los valores separados por comas
    echo implode(",\n    ", $values) . ";\n";

} catch (PDOException $e) {
    // Manejar errores de conexión o consulta
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>