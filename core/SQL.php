<?php

class SQL extends SQLite3
{
    function __construct()
    {
        $this->open('core/toprak.db', SQLITE3_OPEN_READWRITE);
    }
}

global $db;
$db = new SQL();