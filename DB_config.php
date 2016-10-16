<?php

function DB_connect()
{
    return pg_connect("host=127.0.0.1 user=IIE-gag dbname=IIE-gag-DB password=inovia2016");
}