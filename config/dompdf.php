<?php

return [

    'show_warnings' => false,
    'public_path' => null,

    'options' => [
        "isRemoteEnabled" => true,
        "isHtml5ParserEnabled" => true,
        "isPhpEnabled" => true,
        "defaultPaperSize" => "a4",
        "defaultFont" => "times",

        "font_dir"   => storage_path("fonts/"),
        "font_cache" => storage_path("fonts/"),
        "temp_dir"   => storage_path("fonts/"),
        "chroot"     => base_path(),
    ],

    "font_family" => [

        "times" => [
            "normal"      => "Times-Roman",
            "bold"        => "Times-Bold",
            "italic"      => "Times-Italic",
            "bold_italic" => "Times-BoldItalic",
        ],

        // REGISTER NAMA FONT SESUAI FILE
        "NotoSansJavanese" => [
            "normal"      => storage_path("fonts/NotoSansJavanese-Regular.ttf"),
            "bold"        => storage_path("fonts/NotoSansJavanese-Bold.ttf"),
            "italic"      => storage_path("fonts/NotoSansJavanese-Regular.ttf"),
            "bold_italic" => storage_path("fonts/NotoSansJavanese-Bold.ttf"),
        ],
    ],

    "paper" => "A4",
    "orientation" => "portrait",
];
