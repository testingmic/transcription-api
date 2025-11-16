<?php

namespace App\Libraries;

class ChatPrompts {
    /**
     * Generate the analysis prompt
     * 
     * @param string $context
     * @param array $responseSet
     * @return string
     */
    public function analysisPrompt($text) {

        $prompt = "Analyze this transcription and provide a comprehensive summary in JSON format.

        Transcription:
        {$text}

        Please provide a JSON response with this structure:
        {
        'overview': '2-3 sentence summary of the main discussion',
        'keyPoints': [
            { 'text': 'Key point 1', 'timestamp': '00:15' },
            { 'text': 'Key point 2', 'timestamp': '05:30' }
        ],
        'actionItems': [
            { 'text': 'Action item description', 'assignee': 'Person name if mentioned', 'deadline': 'Date if mentioned' }
        ],
        'decisions': ['Decision 1', 'Decision 2'],
        'questions': ['Question 1', 'Question 2'],
        'sentiment': 'positive' | 'neutral' | 'negative'
        }

        Extract timestamps from the transcription when available. Be specific and actionable.";

        return $prompt;
    }

    /**
     * Extract content from a code block of specified type
     * 
     * @param string $text The text containing code blocks
     * @param string $type The type of code block to extract (e.g., 'json', 'sql')
     * @return string|null The extracted content or null if not found
     */
    private function extractCodeBlock($text = null, $type = '') {
        if (empty($text) || !is_string($text)) {
            return null;
        }

        // Clean up the text - normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        
        // Pattern that matches content between triple backticks with type
        $pattern = '/```\s*' . preg_quote($type, '/') . '\s*\n([\s\S]*?)\n\s*```/';
        
        if (preg_match($pattern, $text, $matches)) {
            // Get the content and clean it up
            $content = $matches[1];
            
            // Remove any leading/trailing whitespace while preserving indentation
            $lines = explode("\n", $content);
            
            // Remove empty lines from start and end
            while (!empty($lines) && trim($lines[0]) === '') {
                array_shift($lines);
            }
            while (!empty($lines) && trim(end($lines)) === '') {
                array_pop($lines);
            }
            
            if (empty($lines)) {
                return null;
            }
            
            return implode("\n", $lines);
        }

        // Fallback pattern for edge cases (no newlines after type)
        $pattern = '/```\s*' . preg_quote($type, '/') . '\s*([\s\S]*?)```/';
        if (preg_match($pattern, $text, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * Extract the JSON from the text
     * 
     * @param string $text
     * @return string|null
     */
    public function extractJsonFromText($text = null) {
        return $this->extractCodeBlock($text, 'json');
    }

    /**
     * Extract the SQL from the text
     * 
     * @param string $text
     * @return string|null
     */
    public function extractSqlFromText($text = null) {
        return $this->extractCodeBlock($text, 'sql');
    }

}
?>