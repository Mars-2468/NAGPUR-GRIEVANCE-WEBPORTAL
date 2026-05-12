<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CacheTest extends CI_Controller {

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
	    $this->load->model('AddMenuModel');
	    
	 }
	 
	 
	 
	public function index()
	{
	 
	  $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	  //$menuListt = $this->AddMenuModel->getMenuData('001');
	 
	  //$menuListt = array(1,2,3,4,5);
	 
	  
	       

            if ( ! $menuList = $this->cache->get('menuList'))
            {
                   
                    $menuList = $menuListt;
                    $this->cache->save('menuList', $menuList->result(), 10000);
                   
            }
            else
            {
                echo "data already saved";
                $menuList = $this->cache->get('menuList');
            }
            
            
            print_r($menuList);
            
            
            $testing = "srinivas test";
            
            if ( ! $test = $this->cache->get('ttt'))
            {
                    echo 'Saving to the cache!<br />';
                    $data = $testing;
                    $this->cache->save('ttt', $data, 10000);
                   
            }
            else
            {
                
                $testing = $this->cache->get('ttt');
            }
            
            echo $testing;
            
            
           /* $memcache = new Memcache;
        $memcache->connect("localhost",11211);

        $data=$memcache->get("test_key");

        if($data){
            echo 'cache data:';
            var_dump($data);
        }else{
            $data=$this->db->query("SELECT count(*) as ca FROM menu_type_mst")->row();
            $memcache->set("test_key",$data,false,10); // 10 seconds
            echo 'real data:';
            var_dump($data);
        }*/
            
            
	  
	   
	}
}
