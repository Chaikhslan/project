<?php

namespace App\View;

class Users extends Main
{
    public function content($data = [])
    {
        $columns = [
            'id' => [
                'label' => '#',
                'class' => 'text-justify'
            ],
            'email' => [
                'label' => 'Email',
                'class' => '',
            ],
            'name' => [
                'label' => 'Имя менеджера',
                'class' => '',
            ],
            'table-actions' => [
                'label' => 'Действия',
                'class' => 'text-justify',
                'buttons' => [
                    'update' => [
                        'icon' => 'fa fa-pencil',
                        'route' => '/users/update',
                    ],
                    'delete' => [
                        'icon' => 'fa fa-times',
                        'route' => '/users/delete',
                    ],
                ]
            ]
        ];
        $this->table($columns, $data['data']);
    }
}