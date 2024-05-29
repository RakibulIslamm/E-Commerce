<?php

class PleskAPI {
    private $baseUrl;
    private $username;
    private $password;

    public function __construct($baseUrl, $username, $password) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->username = $username;
        $this->password = $password;
    }

    private function sendRequest($endpoint, $method, $data = null) {
        $url = $this->baseUrl . $endpoint;
        $curl = curl_init($url);

        $headers = [
            'Content-Type: application/json'
        ];

        if ($data) {
            $dataString = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
            $headers[] = 'Content-Length: ' . strlen($dataString);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_USERPWD, $this->username . ':' . $this->password);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new Exception('Request Error: ' . curl_error($curl));
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return [
            'status_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }

    public function createDatabase($dbName, $dbType, $dbHost, $parent_domain, $server_id) {
        $data = [
            'name' => $dbName,
            'type' => $dbType,
            'host' => $dbHost,
            'parent_domain' => [
                'id' => $parent_domain
            ],
            'server_id' => $server_id,
        ];

        $result = $this->sendRequest('/databases', 'POST', $data);

        if ($result['status_code'] == 200) {
            return $result['response'];
        } else {
            throw new Exception('Error creating database: ' . json_encode($result['response']));
        }
    }

    // Additional methods to interact with the Plesk API can be added here
}

$config = require 'config.php';

//example usage
try {
    $plesk = new PleskAPI(
        $config['base_url'],
        $config['username'],
        $config['password']
    );
    $response = $plesk->createDatabase('example_db', 'mysql', 'aster.ecommerce.eforge.it', 1, 1);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
