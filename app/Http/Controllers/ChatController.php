<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    protected $ollamaUrl;
    protected $model;

    public function __construct()
    {
        $this->ollamaUrl = env('OLLAMA_URL', 'http://localhost:11434');
        $this->model = env('OLLAMA_MODEL', 'llama3');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $client = new Client();

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are a helpful medical assistant for Mohospital. ' .
                    'Provide accurate information but always recommend ' .
                    'consulting a doctor for serious concerns.'
            ]
        ];

        // Add conversation history if provided
        if ($request->history) {
            $messages = array_merge($messages, $request->history);
        }

        // Add the new message
        $messages[] = [
            'role' => 'user',
            'content' => $request->message
        ];

        try {
            $response = $client->post("{$this->ollamaUrl}/api/chat", [
                'json' => [
                    'model' => $this->model,
                    'messages' => $messages,
                    'stream' => false
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json([
                'response' => $data['message']['content'],
                'history' => array_merge($messages, [
                    [
                        'role' => 'assistant',
                        'content' => $data['message']['content']
                    ]
                ])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to communicate with Ollama: ' . $e->getMessage()
            ], 500);
        }
    }
}