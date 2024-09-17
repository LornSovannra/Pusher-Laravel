<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    private $credentialsFilePath;

    public function __construct()
    {
        $this->credentialsFilePath = storage_path('app/public/firebase_service_account.json');
    }

    public function index()
    {
        $client = new Google_Client();
        $guzzleClient = new Client(['verify' => false]);
        $client->setHttpClient($guzzleClient);
        $client->setAuthConfig($this->credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $token = $client->fetchAccessTokenWithAssertion();
        $access_token = $token['access_token'];

        $response = Http::withOptions([
            'verify' => false
        ])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/panel-kingdom/messages:send', [
                'message' => [
                    'topic' => 'general',
                    'notification' => [
                        'title' => 'TESTING NOTIFICATION WITH BACKEND CONFIG',
                        'body' => 'IF YOU SEE THIS NOTIFICATION, IT MEANT THAT YOU HAVE SUCCESSFULLY SUBSCRIBED TO FCM.',
                    ]
                ]
            ]);

        if ($response->successful()) {
            return response()->json(["message" => "push notification success", "error" => $response->json()]);
        }

        return response()->json(["message" => "failed to push notification", "error" => $response->json()]);
    }

    public function store(Request $request) {}

    public function show($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
