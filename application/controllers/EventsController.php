<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors',0);

class EventsController extends CI_Controller {
    

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
	 {
	     Parent::__construct();
	     $this->load->library('Mylibrary');
	     $this->load->library('Themeonelayoutwidgets');
	     $this->Mylibrary=new Mylibrary();
	     $this->Themeonelayoutwidgets=new Themeonelayoutwidgets();
	     header('Access-Control-Allow-Origin: *');
	 }
	  public function index()
	 {
	   //  echo 2;exit;
	       $this->db->where('status',1);
	       $query = $this->db->get('table_events');
	       //echo $this->db->last_query();exit;
	       $res = $query->result();
	       //print_r($res);
	       $json = array();
       
            $alldata = array();
            foreach($res as $row)
            {
               $stratdate = date("m/d/Y", strtotime($row->start));
               $enddate =  date("m/d/Y", strtotime($row->end)); 
               $data['id'] = $row->id;
               $data['title'] = $row->title;
               $data['start'] ="$stratdate";
               $data['end'] ="$enddate";
               $data['status'] = $row->status;
               
               array_push($alldata, $data);
            }
            echo json_encode($alldata, JSON_UNESCAPED_SLASHES);
        //     while ($row = mysqli_fetch_assoc($result)) 
        //     {
        //         //var_dump(date("m/d/Y", strtotime($row['start'])));
        //         $stratdate = date("m/d/Y", strtotime($row['start']));
        //         $enddate =  date("m/d/Y", strtotime($row['end']));
        //         $data['id'] = $row['id'];
        //         $data['title'] = $row['title'];
        //         $data['start'] ="$stratdate";
        //         $data['end'] ="$enddate";
        //         $data['status'] = $row['status'];
        
        //         array_push($alldata, $data);
        //     }
        //     mysqli_free_result($result);
         
        //     mysqli_close($conn);
        //     echo json_encode($alldata, JSON_UNESCAPED_SLASHES);
        	}
}
