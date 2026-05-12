<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Citizen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Citizen_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Calcutta');
    }

    // Display all records
    public function index()
    {
        $data['records'] = $this->Citizen_model->get_all_records();
        $this->load->view('citizen/index', $data);
    }

    // Display the form to add a new record
    public function create()
    {
        $this->load->view('admin/citizen_form');
    }

    // Process the form submission to add a new record
    public function store()
    {
        // echo "<pre>";
        // print_r($_FILES); exit;
        // Load form validation library
        $this->load->library('form_validation');

        // Set validation rules for all fields
        $this->form_validation->set_rules('applicant_name', 'Name', 'required');
        $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile_no', 'Mobile', 'required|max_length[11]');
        $this->form_validation->set_rules('property_no', 'Property Number', 'required');
        $this->form_validation->set_rules('property_tax', 'Property Tax', 'required');
        $this->form_validation->set_rules('property_tax', 'Property Tax', 'required');
        if ($this->input->post('property_tax') == 1) {
            $this->form_validation->set_rules('property_tax_proof', 'Property Tax Proof', 'required');
        }

        $this->form_validation->set_rules('solar_energy', 'Solar Energy', 'required');
        if ($this->input->post('solar_energy') == 1) {
            $this->form_validation->set_rules('solar_energy_proof', 'Solar Energy Proof', 'required');
        }

        $this->form_validation->set_rules('led_lights', 'LED Lights', 'required');
        if ($this->input->post('led_lights') == 1) {
            $this->form_validation->set_rules('led_lights_proof', 'LED Lights Proof', 'required');
        }

        $this->form_validation->set_rules('segregate_waste', 'Segregate Waste', 'required');
        if ($this->input->post('segregate_waste') == 1) {
            $this->form_validation->set_rules('segregate_waste_proof', 'Segregate Waste Proof', 'required');
        }

        $this->form_validation->set_rules('balcony_plantation', 'Balcony Plantation', 'required');
        if ($this->input->post('balcony_plantation') == 1) {
            $this->form_validation->set_rules('balcony_plantation_proof', 'Balcony Plantation Proof', 'required');
        }

        $this->form_validation->set_rules('harvesting_rainwater', 'Harvesting Rainwater', 'required');
        if ($this->input->post('harvesting_rainwater') == 1) {
            $this->form_validation->set_rules('harvesting_rainwater_proof', 'Harvesting Rainwater Proof', 'required');
        }

        $this->form_validation->set_rules('co_owners', 'Co-Owners', 'required');
        if ($this->input->post('co_owners') == 1) {
            $this->form_validation->set_rules('co_owners_proof', 'Co-Owners Proof', 'required');
        }
        if ($this->form_validation->run() == FALSE) {
            // Validation failed, redisplay the form with errors
            // echo "erroe"; exit;
            $data['error'] = validation_errors();
            $this->load->view('admin/citizen_form', $data);
        } else {
            // Validation passed, insert the data into the database

            if (!empty($_FILES['property_tax_proof']['name'])) {

                $temp = $_FILES['property_tax_proof']['tmp_name'];
                $name = $_FILES['property_tax_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/property_tax_proof/$fileName";
                $property_tax_proof = '/assets/images/property_tax_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }
            if (!empty($_FILES['solar_energy_proof']['name'])) {

                $temp = $_FILES['solar_energy_proof']['tmp_name'];
                $name = $_FILES['solar_energy_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/solar_energy_proof/$fileName";
                $solar_energy_proof = '/assets/images/solar_energy_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }
            if (!empty($_FILES['led_lights_proof']['name'])) {

                $temp = $_FILES['led_lights_proof']['tmp_name'];
                $name = $_FILES['led_lights_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/led_lights_proof/$fileName";
                $led_lights_proof = '/assets/images/led_lights_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }
            if (!empty($_FILES['segregate_waste_proof']['name'])) {

                $temp = $_FILES['segregate_waste_proof']['tmp_name'];
                $name = $_FILES['segregate_waste_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/segregate_waste_proof/$fileName";
                $segregate_waste_proof = '/assets/images/segregate_waste_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }
            if (!empty($_FILES['balcony_plantation_proof']['name'])) {

                $temp = $_FILES['balcony_plantation_proof']['tmp_name'];
                $name = $_FILES['balcony_plantation_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/balcony_plantation_proof/$fileName";
                $balcony_plantation_proof = '/assets/images/balcony_plantation_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }
            if (!empty($_FILES['harvesting_rainwater_proof']['name'])) {

                $temp = $_FILES['harvesting_rainwater_proof']['tmp_name'];
                $name = $_FILES['harvesting_rainwater_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/harvesting_rainwater_proof/$fileName";
                $harvesting_rainwater_proof = '/assets/images/harvesting_rainwater_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }
            if (!empty($_FILES['co_owners_proof']['name'])) {

                $temp = $_FILES['co_owners_proof']['tmp_name'];
                $name = $_FILES['co_owners_proof']['name'];
                $fileName = time() . $name;
                $path = "./assets/images/co_owners_proof/$fileName";
                $co_owners_proof = '/assets/images/co_owners_proof/' . $fileName;
                $a = move_uploaded_file($temp, $path);
            }

            // $data = $this->input->post();

            $data = array(
                'name' => $this->input->post('applicant_name'),
                'email' => $this->input->post('email_id'),
                'mobile' => $this->input->post('mobile_no'),
                'property_number' => $this->input->post('property_no'),
                'property_tax' => $this->input->post('property_tax'),
                'property_tax_proof' => $property_tax_proof,
                'solar_energy' => $this->input->post('solar_energy'),
                'solar_energy_proof' => $solar_energy_proof,
                'led_lights' => $this->input->post('led_lights'),
                'led_lights_proof' => $led_lights_proof,
                'segregate_waste' => $this->input->post('segregate_waste'),
                'segregate_waste_proof' =>  $segregate_waste_proof,
                'balcony_plantation' => $this->input->post('balcony_plantation'),
                'balcony_plantation_proof' => $balcony_plantation_proof,
                'harvesting_rainwater' => $this->input->post('harvesting_rainwater'),
                'harvesting_rainwater_proof' => $harvesting_rainwater_proof,
                'co_owners' => $this->input->post('co_owners'),
                'co_owners_proof' => $co_owners_proof,
                'created_at' => date('Y-m-d H:i:s')
            );

            $insert_id =   $this->Citizen_model->insert_record($data);
            if ($insert_id) {
                $this->session->set_flashdata('success', 'Record inserted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Record Not inserted!');
            }
            redirect('citizen/create');
        }
    }


    // Display the form to edit a record
    public function edit($id)
    {
        $data['record'] = $this->Citizen_model->get_record_by_id($id);
        $this->load->view('citizen/edit', $data);
    }

    // Process the form submission to edit a record
    public function update($id)
    {
        $data = $this->input->post();
        $this->Citizen_model->update_record($id, $data);
        redirect('citizen/index');
    }

    // Delete a record
    public function delete($id)
    {
        $this->Citizen_model->delete_record($id);
        redirect('citizen/index');
    }
}
