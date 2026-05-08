<?php

function setting($key)
{
    $db = db_connect();

    $data = $db->table('settings')
        ->where('key', $key)
        ->get()
        ->getRow();

    return $data->value ?? null;
}