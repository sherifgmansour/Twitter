<?php

namespace Twitter\Api;

use \Twitter\Api;

/**
 * Social Graph Methods
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
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