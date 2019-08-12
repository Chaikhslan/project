<?php

namespace App\Controller;

class Users
{
    public function run()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `users`
            ");
        $stmt->execute();

        $view = new \App\View\Users();
        $view->render([
            'data' => $stmt->fetchAll()
        ]);
    }
}