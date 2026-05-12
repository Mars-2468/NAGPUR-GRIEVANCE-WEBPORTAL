<?php
defined('BASEPATH') OR  die('direct scripts are not allowed');

class GeneralSettingsModel extends CI_Model
{
    public function __construct()
    {
        Parent::__construct();
    }
    
    
    public function getUlbList(){
        
        $result1  = array();
        $this->db->select('*');
        $this->db->from('ulbmst');
        $this->db->where('theme_id !=',0,FALSE);
        $result1 = $this->db->get()->result_array();
        
        $this->db->select('*');
        $result2 = $this->db->get('genneral_settings')->result_array();
        
        $result_2 = array();
        foreach($result2 as $key=>$val){
            $result_2[$val['ulbid']]['ulbid'] = $val['ulbid'];
            $result_2[$val['ulbid']]['file_path'] = $val['file_path'];
            $result_2[$val['ulbid']]['setting_name'] = $val['setting_name'];
            $result_2[$val['ulbid']]['title'] = $val['title'];
            $result_2[$val['ulbid']]['alt'] = $val['alt'];
        }
        $result = array();
        foreach($result1 as $key=>$value){
            $result[$value['ulbid']]['ulbid'] = $value['ulbid'];
            $result[$value['ulbid']]['ulbname'] = $value['ulbname'];
            $result[$value['ulbid']]['ulb_type'] = $value['ulb_type'];
            $result[$value['ulbid']]['ulbtelugu'] = $value['ulbtelugu'];
            $result[$value['ulbid']]['base_url'] = $value['base_url'];
            $result[$value['ulbid']]['file_path'] = $result_2[$value['ulbid']]['file_path'];
            $result[$value['ulbid']]['title'] = $result_2[$value['ulbid']]['title'];
            $result[$value['ulbid']]['alt'] = $result_2[$value['ulbid']]['alt'];
        }
        return $result;
    }
    
    public function getUlbGeneralSetting(){
        
        $this->db->select('*');
        $result= $this->db->get('genneral_settings')->result_array();
        
        return $result;
    }
    
    public function insertLogoDetails($params)
    {
        $result=$this->db->replace('genneral_settings',$params);
        return $result;
    }
    public function ulbLogoUpdate($params){
        
        $param = array('ulbid'=>$params['ulbid']);
        
        $this->db->select('*');
        $this->db->from('genneral_settings');
        $this->db->where($param);
        $data =  $this->db->get()->result_array();
        if($data){
            
            $delete_array=array('file_path'=>'');
            $this->db->set($delete_array);
            $this->db->where($param);
            $this->db->update('genneral_settings');
            
            $update = array('file_path'=>$params['file_path'],'title'=>$params['title'],'alt'=>$params['alt']);
            $this->db->set($update);
            $this->db->where($param);
            $result = $this->db->update('genneral_settings');
            echo $result;
        }else{
            $result = $this->db->insert('genneral_settings',$params);
            echo $result;
        }
    }
    public function getLogoDetails($params)
    {
        $select_array=array('*');
        $this->db->select($select_array);
        $this->db->where($params);
        $result= $this->db->get('genneral_settings')->row_array();
        
        return $result;
    }

    public function deleteLogoImg($params){

        $this->db->select('*');
        $this->db->from('genneral_settings');
        $this->db->where($params);
        $data =  $this->db->get();
       foreach ($data->result() as $record)
        {
            $filename = '..' . $record->file_path; 
            if (file_exists($filename))
            {
                unlink($filename);
            }

            // ...and continue with your code
           
            $update_array = array('file_path' => '');
            $this->db->set($update_array);
            $this->db->where($params);
            $result=$this->db->update('genneral_settings');
            return $result;
        }
    }
}
?>