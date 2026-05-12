<?php
class Page_visit_model extends CI_Model
{
    public function log_visit($uri)
    {
        // Check if page exists
        $query = $this->db->get_where('page_visits', ['page_uri' => $uri]);
        if ($query->num_rows() > 0) {
            // Update count
            $this->db->set('visit_count', 'visit_count+1', FALSE)
                     ->set('last_visited', 'NOW()', FALSE)
                     ->where('page_uri', $uri)
                     ->update('page_visits');
        } else {
            // Insert new
            $this->db->insert('page_visits', [
                'page_uri' => $uri,
                'visit_count' => 1
            ]);
        }
    }
}
