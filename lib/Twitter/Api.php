<?php

namespace Twitter;

use \Twitter\Client\Client;

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

    private function _getPageNumPaginated($path, array $data = array())
    {
        if ($this->_nextPage === false) {
            return false;
        }

        $data['page'] = $this->_nextPage;

        $results = $this->get($path, $data);

        if ($results) {
            $this->_nextPage++;
        } else {
            $this->_nextPage = false;
        }

        return $results;
    }

    private function _getCursorPaginated($path, array $data = array())
    {
        if ($this->_nextCursor === false) {
            return false;
        }

        $data = array();
        $data['cursor'] = $this->_nextCursor;

        $results = $this->get($path, $data);

        $this->_nextCursor = $this->_client->getNextCursor();

        return $results;
    }

    public function getUser($username)
    {
        return $this->get(sprintf('users/show/%s', $username));
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