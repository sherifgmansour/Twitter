<?php

namespace Twitter\Api;

use \Twitter\Api;

class Statuses extends Api
{
    private $_nextCursor = '-1';
    private $_nextPage = 1;

    public function getPublicTimeline()
    {
        return $this->get('statuses/public_timeline');
    }

    public function getFriendsTimeline($iteratePages = false)
    {
        if ($iteratePages) {
            return $this->_getPageNumPaginated('statuses/friends_timeline');
        } else {
            return $this->get('statuses/friends_timeline');
        }
    }

    public function getUserTimeline($iteratePages = false)
    {
        if ($iteratePages) {
            return $this->_getPageNumPaginated('statuses/user_timeline');
        } else {
            return $this->get('statuses/user_timeline');
        }
    }

    public function getMentions($iteratePages = false)
    {
        if ($iteratePages) {
            return $this->_getPageNumPaginated('statuses/mentions');
        } else {
            return $this->get('statuses/mentions');
        }
    }

    public function getStatus($id)
    {
        return $this->get(sprintf('statuses/show/%s', $id));
    }

    public function updateStatus($status)
    {
        return $this->post('statuses/update', array(
            'status' => $status
        ));
    }

    public function deleteStatus($id)
    {
        return $this->delete(sprintf('statuses/destroy/%s', $id));
    }

    public function getUserFriends($username, $iteratePages = false)
    {
        if ($iteratePages) {
            return $this->_getCursorPaginated(sprintf('statuses/friends/%s', $username));
        } else {
            return $this->get(sprintf('statuses/friends/%s', $username));
        }
    }

    public function getUserFollowers($username, $iteratePages = false)
    {
        if ($iteratePages) {
            return $this->_getCursorPaginated(sprintf('statuses/followers/%s', $username));
        } else {
            return $this->get(sprintf('statuses/followers/%s', $username));
        }
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
}