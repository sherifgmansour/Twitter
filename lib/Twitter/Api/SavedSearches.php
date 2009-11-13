<?php

namespace Twitter\Api;

use \Twitter\Api;

/**
 * Saved Searches Methods
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
class SavedSearches extends Api
{
    public function getSavedSearches()
    {
        return $this->get('saved_searches');
    }

    public function getSavedSearch($id)
    {
        return $this->get(sprintf('saved_searches/show/%s', $id));
    }

    public function createSavedSearch($query)
    {
        return $this->post('saved_searches/create', array(
            'query' => $query
        ));
    }

    public function deleteSavedSearch($id)
    {
        return $this->delete('saved_searches/destroy', array(
            'id' => $id
        ));
    }
}