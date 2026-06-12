<?php
class Debug
{
    /**
     * Sends data to the browser console using JSON.
     * Note: This works best when the output is not strictly JSON API.
     */
    public static function console($data)
    {
        $output = json_encode($data);
        echo "<script>console.log('DEBUG: " . addslashes($output) . "');</script>";
    }

    /**
     * Logs data to the server's error log file.
     */
    public static function log($data)
    {
        error_log(print_r($data, true));
    }
}

// Example usage:-
// require_once "../utils/debug.php";

// $id = intval($_GET['id'] ?? 0);

// Browser console
// Debug::console(["Checking ID" => $id]); 

// Server log
// Debug::log("User requested room with ID: " . $id);