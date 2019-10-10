<?php

return [
    'sign-up' => [
        'name' => 'Регистрация на сайте',
        'alias' => 'sign-up',
        'text' => '<p>Здравствуй добрый человек {first_name} {last_name}</p>
                    <p>Твой <b>login</b> в этом бреном мире: {login}</p>',
        'var' => '{first_name},{last_name},{login}'
    ],
    'confirm-sign-up' => [
        'name' => 'Потверждение регистрации',
        'alias' => 'confirm-sign-up',
        'text' => '<p>Перейди по ссылки {first_name} {last_name}</p>
                    <p>{link}</p>',
        'var' => '{first_name},{last_name},{link}'
    ],
    'sign-up-by-network' => [
        'name' => 'Регистрация на сайте через соц.сеть',
        'alias' => 'sign-up-by-network',
        'text' => '<p>Здравствуй добрый человек</p>
                        <p>Вы были зарегистрированы через соц.сеть {network}</p>
                        <p>Ваш <b>login: </b> {login}</p>
                        <p>Ваш <b>password: </b> {password} (вы можете его изменить в личном кабинете)</p>',
        'var' => '{first_name},{last_name},{login},{password},{network}'
    ],
    'reset-password' => [
        'name' => 'Зброс пароля',
        'alias' => 'reset-password',
        'text' => '<p>Здраствуй добрый человек {first_name}</p>
                        <p>Нажми на ссылку и да прибудет с тобой новый пароль:</p>
                        <p>{reset_link}</p>',
        'var' => '{first_name},{last_name},{reset_link}'
    ],
    'new-password' => [
        'name' => 'Новый пароль',
        'alias' => 'new-password',
        'text' => '<p>Здраствуй {first_name} {last_name}</p>
                        <p>Вам был установленн новый пароль : {new_password}</p>',
        'var' => '{first_name},{last_name},{new_password}'
    ],
    'verify-passport-success' => [
        'name' => 'Успешная верификация паспорта',
        'alias' => 'verify-passport-success',
        'text' => '<h3>Возрадуйся добрый человек</h3>
                        <p>Твой паспорт прошел верификацию</p>
                        <p>Теперь ты не просто букашка,а человек с <b>бумажкой</b> !!!</p>',
        'var' => '{first_name},{last_name},{series},{number}'
    ],
    'verify-passport-error' => [
        'name' => 'Верификация паспорта отклонена',
        'alias' => 'verify-passport-error',
        'text' => '<h3>OOPS!!!!</h3>
                        <p>Что-то пошло не так</p>
                        <p>Твой скан был откланен</p>
                        <p><b>¯ \ _ (ツ) _ / ¯</b></p>',
        'var' => '{first_name},{last_name},{series},{number}'
    ],
    'verify-passport-int-error' => [
        'name' => 'Верификация загранпаспорта отклонена',
        'alias' => 'verify-passport-int-error',
        'text' => '<h3>OOPS!!!!</h3>
                        <p>Что-то пошло не так</p>
                        <p>Скан загранпаспорта на имя {first_name}{last_name},был откланен.</p>
                        <p><b>¯ \ _ (ツ) _ / ¯</b></p>',
        'var' => '{first_name},{last_name},{series},{number}'
    ]
];