<?php

class SQL extends SQLite3
{
    function __construct()
    {
        $this->open('toprak.db');
    }
}

global $db;
$db = new SQL();