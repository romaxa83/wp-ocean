<?php

return [
    'SMTP_from' => 'noreply@5okean.com',
    'GTM_key' => 'GTM-PM8C25Z', //GTM-PM8C25Z //GTM-5GFRTC
    'GAtrackingId' => 'UA-1999931-6',
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'status_order' => [
        0 => 'Удаленный',
        1 => 'Новый',
        2 => 'Выполнен'
    ],
    'apiUrl' => 'https://export.otpusk.com',
    'apiToken' => '2c123-154f7-92ee1-a09d8-be715',
    //'apiToken' => '2716a-a6aa2-8ce60-439c2-641a5',
    //'apiToken' => '273be-019f1-02bb0-c2607-3e982',
    'proxy_enable' => FALSE,
    //https://hidemyna.me/ru/proxy-list/
    'proxy' => [
        //'195.230.131.210:3128'
        //'93.171.27.99:53281',
        //'195.80.140.212:8081'
        //'109.108.80.194:37640'
        //'194.29.60.48:45416'
        '94.179.130.34:43902'
    ],
    'filter_days_range' => 7,
    'posts_on_page' => 9,
    'posts_download_page' => 9,
    'review__on_page' => 10,
    'hotel_service' => [
        'aquapark' => 'akwapark.svg',
        'animation' => 'animator.svg',
        'outdoor_pool' => 'bassein.svg',
        'indoor_pool' => 'bassein.svg',
        'heated_pool' => 'bassein.svg',
        'pool' => 'bassein.svg',
        'coffee' => 'chainik.svg',
        'playground' => 'detskaya_ploshadka.svg',
        'childpool' => 'detskiy_bassein.svg',
        'nursery' => 'detskiy_klub.svg',
        'childmenu' => 'detskoe_menu.svg',
        'discotheque' => 'disko.svg',
        'youngsters' => 'dlja_molodeji.svg',
        'adults' => 'dlya_vzroslih.svg',
        'town' => 'gorod_pljaj.svg',
        'network' => 'internet.svg',
        'lan' => 'internet.svg',
        'wifi' => 'internet.svg',
        'ski_storage' => 'room_ski.svg',
        'family' => 'semeiniy_otdih.svg',
        'ski_rental' => 'ski.svg',
        'own' => 'sobstvenniy_pljaj.svg',
        'relaxing' => 'spokoiniy_otdih.svg',
        'one_line_beach' => 'tip_plyaja.svg',
        'two_line_beach' => 'tip_plyaja.svg',
        'next_beach_line' => 'tip_plyaja.svg'
    ],
    //https://stage.5okean.com/
    'reCaptcha' => [
        'siteKey' => '6Lcf2qYUAAAAAHePv0926HNnG8yuPDqLZIZ-Mtp9',
        'secret' => '6Lcf2qYUAAAAAJNbU2ZJ6nKW7gdyBAu6MWLEpRxk',
    ],
    //http://ocean.4sale.pp.ua/
//    'reCaptcha' => [
//        'siteKey' => '6Lf1_pMUAAAAACkPcBgkkeTd7rEipmLtlTzlautb',
//        'secret' => '6Lf1_pMUAAAAAI4LaKIGsGSCWbRI4blY09Qx9sIi',
//    ],
    'dataApiDefault' => [
        'deptCity' => 'Киева',
        'deptCityCid' => 1544,
        'days' => 7,
        'people' => 2,
        'page' => 1
    ],
    'priority' => [
        'Турция',
        'Египет'
    ],
    'city' => [
        'turkey' => [
            'Алания',
            'Анталия',
            'Белек',
            'Бодрум',
            'Даламан',
            'Дидим',
            'Измир',
            'Каппадокия',
            'Кемер',
            'Кушадасы',
            'Мармарис',
            'Сиде',
            'Стамбул',
            'Фетхие'
        ]
    ],
    'morphy' => [
        'bali' => 'Бали',
        'dominican republic' => 'Доминикану',
    ],
    'version-release' => 1.1
];
