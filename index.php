<?php 
  <?php
$subdomain = 'hmanucharyan'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
    'client_id' => 'c3a181d9-22d9-447a-9ce5-1eeb0d525c16',
    'client_secret' => 'l3i4HWOYPevCyPFTsbU9WDxL3Yl0rZWPBOaQyHvtkP6yh1uzNcyiL2I0aXjTxehY',
    'grant_type' => 'authorization_code',
    'code' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZkYzJmOGE2YmQwMDQ1MTRjNmViMzY4ZTAzZTNjYzUwMzIyODFhOTI3MjBhYTQ4N2ZiMjQzY2I5ODRkZTQwYmZmMjhjOThjM2M4MjUyZWU5In0.eyJhdWQiOiJjM2ExODFkOS0yMmQ5LTQ0N2EtOWNlNS0xZWViMGQ1MjVjMTYiLCJqdGkiOiJmZGMyZjhhNmJkMDA0NTE0YzZlYjM2OGUwM2UzY2M1MDMyMjgxYTkyNzIwYWE0ODdmYjI0M2NiOTg0ZGU0MGJmZjI4Yzk4YzNjODI1MmVlOSIsImlhdCI6MTcxNDQ3ODY1MSwibmJmIjoxNzE0NDc4NjUxLCJleHAiOjE3MTcxMTM2MDAsInN1YiI6IjEwOTk5NjU0IiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMxNzI4MTk0LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiYzFlNzg1MWItZWY2MS00YjFkLTgyMDMtYTMxMTIwMThmZDM4In0.hw8sWt8R-AidOLL4s4iUlsagQyV_-V6BTw2YaBw0IO6T_refiXT0CWxsU6GGoBYS13zDPsyCxyPG29vu543VkBG1ZqmrILCnyb__WvEd4NSOTeSU1abztlOoj842MnWY6-qnLjceUu8QhYNqIUWRQvneydwzQ6kXL8WIMpCsgVjDn_TJ75ENNkoo0kABEMAHGK1LKhADknMHDoq3DOS0UsXA-n248ZJ_xdBoz-CCiU9BrkghI5gminXrKJwL1XmKTNDJG4VfLynJWrrKYcl1VdyUOUfZD1JT7vhsTxUGsfewv7TgMVV_buHQXkBUoo26J48hjMyZ-okeWG_AuiBMaA',
    'redirect_uri' => 'https://test.ru/',
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
$code = (int)$code;
$errors = [
    400 => 'Bad request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal server error',
    502 => 'Bad gateway',
    503 => 'Service unavailable',
];

try
{
    /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
    if ($code < 200 || $code > 204) {
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    }
}
catch(\Exception $e)
{
    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}

/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
$response = json_decode($out, true);
print_r($response);
$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in']; //Через сколько действие токена истекает
?>
