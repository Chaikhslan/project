<?php

namespace App\Controller;

class Login
{
    public function run()
    {
        if ($_POST) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `users`
            WHERE
                `email` = :email AND `password` = :password
            ");
            $stmt->execute([
                ':email' => $_POST['email'],
                ':password' => sha1($_POST['password'])
            ]);

            if ($user = $stmt->fetch()) {
                $_SESSION['auth'] = $user;
                header('Location: /');
            }
            return;
        }
        $view = new \App\View\Login();
        $view->render();
    }
}