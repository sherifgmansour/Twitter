<?php

namespace Twitter\Api;

use \Twitter\Api;

class SocialGraph extends Api
{
    public function getFriendIds($username = null)
    {
        $username = $username ? $username : $this->_client->getUsername();
        return $this->get(sprintf('friends/ids/%s', $username));
    }

    public function getFollowerIds($username = null)
    {
        $username = $username ? $username : $this->_client->getUsername();
        return $this->get(sprintf('followers/ids/%s', $username));
    }
}