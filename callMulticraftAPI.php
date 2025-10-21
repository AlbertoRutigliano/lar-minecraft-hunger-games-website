<?php
	require('MulticraftAPI.php');

	// Configurazione sicura (non esposta al client)
	$url = getenv('API_URL');
	$apiUser = getenv('API_USER');
	$apiPassword = getenv('API_KEY');

	// Legge i dati in ingresso
	$command = $_POST['command'] ?? null;
	$params = $_POST['params'] ?? [];

	// Se i parametri arrivano in JSON (più pulito)
	if (is_string($params)) {
		$decoded = json_decode($params, true);
		if (json_last_error() === JSON_ERROR_NONE) {
			$params = $decoded;
		}
	}

	// Verifica input minimo
	if (!$command) {
		http_response_code(400);
		echo json_encode(['error' => 'Missing "command" parameter']);
		exit;
	}

	try {
		$api = new MulticraftAPI($url, $apiUser, $apiPassword);

		// Esegue la chiamata dinamica
		$result = call_user_func_array([$api, $command], (array)$params);

		header('Content-Type: application/json');
		echo json_encode($result);

	} catch (Exception $e) {
		http_response_code(500);
		echo json_encode(['error' => $e->getMessage()]);
}