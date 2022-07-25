<?php

return [
    "sidebar" => [
        [
            "icon" => "bi bi-grid-fill",
            "text" => "Dashboard",
            "title" => "",
            "route" => "member.home",
            "target" => "_self",
            "activeIn" => ["member.home"],
        ],
        [
            "icon" => "bi bi-diagram-3-fill",
            "text" => "Example",
            "title" => "",
            "activeIn" => ['member.example', 'member.exampleTwo'],
            "items" => [
                [
                    "icon" => "bi bi-app-indicator",
                    "text" => "Account Information",
                    "title" => "",
                    "route" => "member.example",
                    "target" => "_self",
                    "activeIn" => ['member.example'],
                ],
                [
                    "icon" => "bi bi-app-indicator",
                    "text" => "Direct Refferals",
                    "title" => "",
                    "route" => "member.exampleTwo",
                    "target" => "_self",
                    "activeIn" => ['member.exampleTwo'],
                ],
                [
                    "icon" => "bi bi-app-indicator",
                    "text" => "Binary Log",
                    "title" => "",
                    "route" => "member.example",
                    "target" => "_self",
                    "activeIn" => ['member.example'],
                ]
            ],
        ],
        [
            "icon" => "bi bi-person-lines-fill",
            "text" => "Profile",
            "title" => "",
            "route" => "member.profile",
            "target" => "_self",
            "activeIn" => ["member.profile"],
        ],
        [
            "icon" => "bi bi-box-arrow-up-right",
            "text" => "Abrir o site",
            "title" => "",
            "route" => "front.home",
            "target" => "_blank",
            "activeIn" => [],
        ],
        [
            "icon" => "bi bi-box-arrow-left",
            "text" => "Logout",
            "title" => "",
            "route" => "auth.logout",
            "target" => "_self",
            "activeIn" => [],
        ],
    ],
];
