<?php

return [
    "sidebar" => [
        [
            "icon" => icon_class("grid"),
            "text" => "Dashboard",
            "title" => "",
            "route" => "admin.home",
            "target" => "_self",
            "activeIn" => ["admin.home"],
        ],
        [
            "icon" => icon_class("users"),
            "text" => "Gerenciar membros",
            "title" => "",
            "activeIn" => ["admin.users.index", "admin.users.create", "admin.users.edit"],
            "target" => "_self",
            "items" => [
                [
                    "icon" => icon_class("list"),
                    "text" => "Listar membros",
                    "title" => "",
                    "route" => "admin.users.index",
                    "target" => "_self",
                    "activeIn" => ["admin.users.index"]
                ],
                [
                    "icon" => icon_class("userPlus"),
                    "text" => "Novo",
                    "title" => "",
                    "route" => "admin.users.create",
                    "target" => "_self",
                    "activeIn" => ["admin.users.create"]
                ],
                [
                    "icon" => icon_class("pencilSquare"),
                    "text" => "Editar usuário",
                    "title" => "",
                    "route" => "",
                    "target" => "_self",
                    "activeIn" => ["admin.users.edit"],
                    "visibleIn" => ["admin.users.edit"]
                ]
            ]
        ],
        [
            "icon" => icon_class("media"),
            "text" => "Mídias",
            "title" => "",
            "activeIn" => ["admin.images.index"],
            "target" => "_self",
            "items" => [
                [
                    "icon" => icon_class("images"),
                    "text" => "Imagens",
                    "title" => "",
                    "route" => "admin.images.index",
                    "target" => "_self",
                    "activeIn" => ["admin.images.index"]
                ]
            ],
        ],
        [
            "icon" => icon_class("page"),
            "text" => "Blog",
            "title" => "",
            "activeIn" => ["admin.blog.articles.index", "admin.blog.articles.create", "admin.blog.articles.edit", "admin.blog.categories.index", "admin.blog.tags.index"],
            "target" => "_self",
            "items" => [
                [
                    "icon" => icon_class("pageFillEarmarkText"),
                    "text" => "Artigos",
                    "title" => "",
                    "route" => "admin.blog.articles.index",
                    "target" => "_self",
                    "activeIn" => ["admin.blog.articles.index", "admin.blog.articles.create", "admin.blog.articles.edit"]
                ],
                [
                    "icon" => icon_class("folderFill"),
                    "text" => "Categorias",
                    "title" => "",
                    "route" => "admin.blog.categories.index",
                    "target" => "_self",
                    "activeIn" => ["admin.blog.categories.index"]
                ]
            ],
        ],
        [
            "icon" => icon_class("pageEarmarkText"),
            "text" => "Páginas",
            "title" => "",
            "route" => "admin.pages.index",
            "activeIn" => ["admin.pages.index", "admin.pages.create", "admin.pages.edit"],
            "target" => "_self",
        ],
        [
            "icon" => icon_class("linkExternalRight"),
            "text" => "Abrir o site",
            "title" => "",
            "route" => "front.home",
            "target" => "_blank",
            "activeIn" => [],
        ],
        [
            "icon" => icon_class("logout"),
            "text" => "Logout",
            "title" => "",
            "route" => "auth.logout",
            "target" => "_self",
            "activeIn" => [],
        ],
    ],
];
