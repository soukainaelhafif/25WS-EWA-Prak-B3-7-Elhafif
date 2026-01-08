<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/**
 * Abstract BaseController class providing common methods for all controllers.
 * 
 * This class offers utility functions to:
 * - Render HTML views by extracting data variables and including the view file.
 * - Return JSON responses with proper headers and formatting.
 * 
 * Controllers extending this base class can use these methods to simplify response handling.
 */
abstract class BaseController
{
    /**
     * Extract data variables and include the view file.
     *
     * @param string $viewFile Path to the PHP view file.
     * @param array $data Variables to extract and pass to the view.
     * @return void
     */
    protected function renderHtml(string $viewFile, array $viewData = []): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        extract($viewData); // Extract variables so keys become variable names in the view
        require $viewFile;
    }

    /**
     * Outputs the response as JSON.
     *
     * @param mixed $data The data to encode and return.
     * @return void
     */
    protected function renderJson(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
