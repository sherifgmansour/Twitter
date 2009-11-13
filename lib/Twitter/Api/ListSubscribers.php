<?php

namespace Twitter\Api;

use \Twitter\Api;

class ListSubscribers extends Api
{
    public function getSubscribers($id)
    {
        if ( ! strstr($id, '/')) {
            $id = $this->_client->getUsername() . '/' . $id;
        }

        return $this->get(sprintf('%s/subscribers', $id));
    }

    public function subscribe($id)
    {
        return $this->post(sprintf('%s/subscribers', $id), array(
            'id' => $this->_client->getUsername()
        ));
    }

    public function unsubscribe($id)
    {
        return $this->delete(sprintf('%s/subscribers', $id), array(
            'id' => $this->_client->getUsername()
        ));
    }

    public function isSubscriber($id, $username = null)
    {
        if ( ! strstr($id, '/')) {
            $id = $this->_client->getUsername() . '/' . $id;
        }

        $username = $username ? $username : $this->_client->getUsername();
        
        if ( ! is_numeric($username)) {
            $user = $this->getUser($username);
            $userId = $user->id;
        } else {
            $userId = $username;
        }

        $result = $this->get(
            sprintf('%s/subscribers/%s', $id, $userId)
        );
        return isset($result->error) ? false : true;
    }
}