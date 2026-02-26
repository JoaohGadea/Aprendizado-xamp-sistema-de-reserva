<?php
session_start();

class Passenger {
    private $name;
    private $age;
    private $seatNumber;

    public function __construct($name, $age, $seatNumber) {
        $this->name = $name;
        $this->age = $age;
        $this->seatNumber = strtoupper($seatNumber);
    }

    public function getName() {
        return $this->name;
    }

    public function getAge() {
        return $this->age;
    }

    public function getSeatNumber() {
        return $this->seatNumber;
    }
}

// Inicializa array de reservas
if (!isset($_SESSION['reservations'])) {
    $_SESSION['reservations'] = [];
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $seatNumber = strtoupper($_POST["seatNumber"]);

    // Verifica se assento já está reservado
    if (isset($_SESSION['reservations'][$seatNumber])) {
        $message = "❌ Assento já reservado!";
    } else {
        $passenger = new Passenger($name, $age, $seatNumber);
        $_SESSION['reservations'][$seatNumber] = $passenger;
        $message = "✅ Reserva realizada com sucesso!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Painel de Reservas</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1504198453319-5ce911bafcde');
    background-size: cover;
    margin: 0;
    padding: 40px;
    color: white;
}

.container {
    background: rgba(255,255,255,0.95);
    padding: 30px;
    border-radius: 15px;
    color: black;
    max-width: 900px;
    margin: auto;
}

h2 {
    text-align: center;
}

form {
    margin-bottom: 30px;
}

input {
    padding: 8px;
    margin: 5px 0;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    padding: 10px;
    background: #1e3c72;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background: #16305c;
}

.message {
    margin: 10px 0;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 10px;
    text-align: center;
}

th {
    background-color: #1e3c72;
    color: white;
}
</style>
</head>
<body>

<div class="container">
<h2>Sistema de Reservas de Passageiros</h2>

<form method="POST">
<label>Nome:</label>
<input type="text" name="name" required>

<label>Idade:</label>
<input type="number" name="age" required>

<label>Número do Assento (ex: 12A):</label>
<input type="text" name="seatNumber" required>

<button type="submit">Reservar Assento</button>
</form>

<div class="message"><?php echo $message; ?></div>

<h3>Painel de Assentos Reservados</h3>

<table>
<tr>
<th>Assento</th>
<th>Nome</th>
<th>Idade</th>
</tr>

<?php
foreach ($_SESSION['reservations'] as $seat => $passenger) {
    echo "<tr>";
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $passenger->getName() . "</td>";
    echo "<td>" . $passenger->getAge() . "</td>";
    echo "</tr>";
}
?>
</table>

</div>

</body>
</html>