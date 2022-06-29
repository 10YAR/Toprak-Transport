<?php

class SQL extends SQLite3
{
    function __construct()
    {
        $this->open('core/toprak.db');
    }
}

global $db;
$db = new SQL();