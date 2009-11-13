<?php

namespace Twitter;

use \Twitter\Client\Client;

/**
 * Base Twitter Api class
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
class Api
{
    protected $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_initialize();
    }

    protected function _initialize()
    {
    }

    public function getUser($username)
    {
        return $this->get(sprintf('users/show/%s', $username));
    }

    public function reportSpam($username)
    {
        return $this->post('report_spam', array(
            'screen_name' => $username
        ));
    }

    public function get($path, array $data = array())
    {
        return $this->_client->fetch($path, $data, 'get');
    }

    public function post($path, array $data = array())
    {
        return $this->_client->fetch($path, $data, 'post');
    }

    public function put($path, array $data = array())
    {
        return $this->_client->fetch($path, $data, 'put');
    }

    public function delete($path, array $data = array())
    {
        return $this->_client->fetch($path, $data, 'delete');
    }
}