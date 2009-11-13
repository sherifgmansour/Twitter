<?php

namespace Twitter\Client;

/**
 * Public interface for Twitter clients
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
interface Client
{
    function fetch($path, array $data = array(), $method = 'get');
    function getUsername();
    function setUsername($username);
}