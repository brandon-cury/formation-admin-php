<?php
namespace views;
class AlertController {
    public static function alert(string $error, string $type = 'success'): void {
        $_SESSION['alert'][] = ['message' => $error, 'type' => $type];
    }
    
}