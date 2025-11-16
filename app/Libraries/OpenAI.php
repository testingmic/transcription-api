<?php

namespace App\Libraries;

use App\Libraries\ChatPrompts;

class OpenAI {

    private $apiKey;
    private $baseUrl = "https://api.openai.com/v1/chat/completions";
    private $model = "gpt-4o";

    public $conversationId = null;
    public $lastResponseId = null;
    public $errorEncountered = false;
    public $queryEntities = [];
    public $queryMetric = 'unknown';

    /**
     * @param string $apiKey  Your OpenAI or project API key
     */
    public function __construct() {
        $this->apiKey = configs('openai_api_key');
    }

    /**
     * Analyze the response
     * 
     * @param string $context
     * @param string $responseSet
     * 
     * @return array
     */
    public function analyzeResponse($context) {

        // create a new prompt object
        $promptObject = new ChatPrompts();

        // Generate the prompt for the query
        $prompt = $promptObject->analysisPrompt($context);

        // create the payload
        $payload = [
            "model" => $this->model,
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are an expert at analyzing meeting transcriptions and extracting actionable insights. Provide structured, concise summaries."
                ],
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ]
        ];

        // if the context is less than 100 characters, return a default response
        if(strlen($context) < 100) {
            return [
                "overview" => "The transcription provided lacks sufficient content or context to form a comprehensive summary of any discussion.",
                "keyPoints" => [],
                "actionItems" => [],
                "decisions" => [],
                "questions" => [],
                "sentiment" => "neutral"
            ];
        }

        $resultSet = $this->sendRequest($payload);

        // extract the json from the text
        $reqResp = $promptObject->extractJsonFromText($resultSet['text'] ?? $resultSet);

        // decode the json
        $reqResp = !empty($reqResp) ? json_decode($reqResp, true) : [];

        return $reqResp;

    }
    /**
     * Core cURL request handler.
     */
    private function sendRequest($payload) {

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->apiKey
            ],
            CURLOPT_POSTFIELDS => json_encode($payload)
        ]);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new \Exception("cURL Error: " . curl_error($ch));
        }

        curl_close($ch);
        $decoded = json_decode($response, true);

        if(isset($decoded['id']) && !empty($decoded['id'])) {
            $this->conversationId = $decoded['id'];
            $this->lastResponseId = $decoded['id'];
        }

        // Return model message content if available
        return $decoded['choices'][0]['message']['content'] ?? (
            $decoded['output'][0]['content'][0] ?? $response
        );

    }

}
?>
