<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class WebportalVisitorsCount extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MenuModel');
        header('Content-Type: application/json');
    }

    // http://domain.com/index.php/api/grievance_api/total
    public function total()
    {
        $total = $this->MenuModel->getVisitCountDB();

        echo json_encode([
            //'status' => true,
            'total_visitors_count' => $total
        ]);
    }
}
