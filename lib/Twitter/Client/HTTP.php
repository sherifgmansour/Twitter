<?php

namespace Twitter\Client;

class HTTP extends AbstractClient
{
    protected $_username;
    protected $_password;

    public function __construct($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    protected function _doFetch($url, array $data = array(), $method = 'get')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_username.':'.$this->_password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        if ($method == 'post' || $method == 'delete') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}