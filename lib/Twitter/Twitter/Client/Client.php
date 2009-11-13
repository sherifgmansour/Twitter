<?php

namespace Twitter\Client;

interface Client
{
    function fetch($path, array $data = array(), $method = 'get');
    function getUsername();
    function setUsername($username);
}