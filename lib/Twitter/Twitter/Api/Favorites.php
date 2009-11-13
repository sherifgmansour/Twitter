<?php

namespace Twitter\Api;

use \Twitter\Api;

class Favorites extends Api
{
    public function getMostRecent($username = null)
    {
        $username = $username ? $username : $this->_client->getUsername();
        return $this->get('favorites', array(
            'id' => $username
        ));
    }

    public function createFavorite($id)
    {
        return $this->post(sprintf('favorites/create/%s', $id));
    }

    public function deleteFavorite($id)
    {
        return $this->delete(sprintf('favorites/destroy/%s', $id));
    }
}