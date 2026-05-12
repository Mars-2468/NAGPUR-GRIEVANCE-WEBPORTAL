// Unauthorized.php (Controller)
class Unauthorized extends CI_Controller {
    public function index() {
        $this->load->view('unauthorized');
    }
}

// unauthorized.php (View)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unauthorized Access</title>
</head>
<body>
    <h1>You are not authorized to access this page.</h1>
</body>
</html>
