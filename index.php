<?php
require './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['API_KEY']; // Coloque sua API Key da OpenWeather


$url = "https://api.openweathermap.org/data/2.5/weather?lat=-21.4061&lon=-48.5047&appid={$apiKey}";

// Inicia o cURL
$ch = curl_init();

// Define as opções
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição
$response = curl_exec($ch);

// Verifica erros
if ($response === false) {
    echo "Erro ao acessar a API: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Fecha a conexão cURL
curl_close($ch);

// Decodifica JSON
$data = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 98%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f0f2f5;
        }
        .weather-card {
            background: white;
            padding: 20px; q
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; 
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .weather-info {
            margin: 10px 0;
            padding: 10px;
            border-bottom: 1px solid #eee;
            color: white;
        }
        .city-name {
            font-size: 24px;
            color: white;
            margin-bottom: 20px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 300px;
            height: 300px;
            border-radius: 10px;
            background-color: #1C1C1C;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1)
        }
    </style>
</head>
<body>
    <div class="weather-card">
       <div class="container">
        <div class="city-name"><?php echo $data['name']; ?></div>
            <div class="weather-info">
                <strong>Temperatura:</strong> <?php echo ($data['main']['temp'] - 273.15); ?>°C
            </div>
            <div class="weather-info">
                <strong>Clima:</strong> <?php echo ucfirst($data['weather'][0]['description']); ?>
            </div>
            <div class="weather-info">
                <strong>Umidade:</strong> <?php echo $data['main']['humidity']; ?>%
            </div>
            <div class="weather-info">
                <strong>Vento:</strong> <?php echo $data['wind']['speed']; ?> m/s
            </div>
       </div>
    </div>
</body>
</html>
