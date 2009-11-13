<?php

namespace Twitter\Api;

use \Twitter\Api;

/**
 * Friendship Methods
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
class Friendships extends Api
{
    public function follow($username)
    {
        return $this->post(sprintf('friendships/create/%s', $username));
    }

    public function unfollow($username)
    {
        return $this->delete(sprintf('friendships/destroy/%s', $username));
    }

    public function exists($usernameA, $usernameB = null)
    {
        $friendship = $this->getFriendship($usernameA, $usernameB);
        if (isset($friendship->relationship)) {
            return $friendship->relationship->source->following
                || $friendship->relationship->source->followed_by
                || $friendship->relationship->target->following
                || $friendship->relationship->target->followed_by;
        } else {
            return false;
        }
    }

    public function isFollowing($username)
    {
        $friendship = $this->getFriendship($username, $this->_client->getUsername());
        return isset($friendship->relationship->source->following) && $friendship->relationship->source->following ? true : false;
    }

    public function isFollowedBy($username)
    {
        $friendship = $this->getFriendship($username, $this->_client->getUsername());
        return isset($friendship->relationship->source->followed_by ) && $friendship->relationship->source->followed_by ? true : false;
    }

    public function getFriendship($usernameA, $usernameB = null)
    {
        $usernameB = $usernameB ? $usernameB : $this->_client->getUsername();;
        return $this->get('friendships/show', array(
            'source_screen_name' => $usernameB,
            'target_screen_name' => $usernameA
        ));
    }
}