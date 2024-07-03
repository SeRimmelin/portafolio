<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function fetchData()
    {
        $client = new Client();
        $response = $client->get('https://7719-190-114-40-115.ngrok-free.app/api/data');

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        }

        return response()->json(['error' => 'Error fetching data'], $response->getStatusCode());
    }

    public function sendData(Request $request)
    {
        $client = new Client();
        try {
            $response = $client->post('https://7719-190-114-40-115.ngrok-free.app/api/users', [
                'json' => $request->all()
            ]);

            if ($response->getStatusCode() == 200) {
                return response()->json(['success' => 'Data sent successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error sending data: ' . $e->getMessage()]);
        }

        return response()->json(['error' => 'Unknown error']);
    }
}
