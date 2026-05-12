<?php
class ErrorsController extends CI_Controller {
    public function custom_404() {
        // Load a custom 404 view
        $this->output->set_status_header(404);
        $data['message'] = 'Sorry, the page you are looking for does not exist.';
        $this->load->view('errors/custom_404', $data);
    }

    public function custom_error($code = 500) {
        $this->output->set_status_header($code);
        $data['message'] = 'Oops! Something went wrong. Please try again later.';
        $this->load->view('errors/custom_error', $data);
    }
}


?>