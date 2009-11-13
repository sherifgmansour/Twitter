<?php

namespace Twitter\Client;

/**
 * Abstract Twitter client class
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
abstract class AbstractClient implements Client
{
    protected $_username;
    protected $_apiBaseUrl = 'http://api.twitter.com/1';
    protected $_nextCursor;

    public function setApiBaseUrl($url)
    {
        $this->_apiBaseUrl = $url;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getNextCursor()
    {
        return $this->_nextCursor;
    }

    public function fetch($path, array $data = array(), $method = 'get')
    {
        if (strstr($path, '?')) {
            $path = str_replace('?', '.json?', $path);
        } else {
            $path = $path . '.json';
        }
        $url = $this->_apiBaseUrl . '/' . $path;

        if ($method == 'delete') {
            $data['_method'] = 'DELETE';
        }

        if ($method == 'get' && ! empty($data)) {
            $sep = strstr($path, '?') ? '&' : '?';
            $url = $url . $sep . http_build_query($data);
        }

        $json = $this->_doFetch($url, $data, $method);

        preg_match('/"next_cursor":(.*),/', $json, $matches);
        if (isset($matches[1]) && $matches[1] && $matches[1] != $this->_nextCursor) {
            $this->_nextCursor = $matches[1];
        } else {
            $this->_nextCursor = false;
        }

        return json_decode($json);
    }

    abstract protected function _doFetch($url, array $data, $method);
}