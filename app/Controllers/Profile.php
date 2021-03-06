<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\LoanModel;
use App\Models\PaymentModel;
use CodeIgniter\Controller;

class Profile extends Controller
{
    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index()
    {

		return view('profile');
    }

    function get(){ 
        $CustomerModel = new CustomerModel();

		//$data = $CustomerModel->where("status='1' OR status='2'")->orderBy('id', 'ASC')->paginate(10);
        $data = $CustomerModel->get_data();

        //set numbers to names
        for($i=0;$i<sizeof($data);$i++){
            if($data[$i]["gender"] == 1){
                $data[$i]["gender"] = "Male";
            }else{
                $data[$i]["gender"] = "Female";
            }

            if($data[$i]["status"] == 1){
                $data[$i]["status"] = "Active";
            }else if($data[$i]["status"] == 2){
                $data[$i]["status"] = "Inactive";
            }
        }
        

		echo json_encode($data);
	}

    
	function save(){
        helper(['form', 'url']);
        
        $model = new CustomerModel();
        
        $data = [
            'first_name'	=>	$this->request->getPost('first_name'),
            'last_name'	    =>	$this->request->getPost('last_name'),
            'address'        =>	$this->request->getPost('address'),
            'city'	=>	$this->request->getVar('city'),
            'dob'	    =>	$this->request->getVar('dob'),
            'nic'        =>	$this->request->getVar('nic'),
            'gender'	=>	$this->request->getVar('gender'),
            'contact_no'	    =>	$this->request->getVar('contact_no'),
            'email'        =>	$this->request->getVar('email'),
            'line_id'        =>	$this->request->getVar('line'),
            'status'        =>	$this->request->getVar('status')
        ];

        $save_data = $model->insert_data($data);

        if($save_data != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $data));
        }else{
            echo json_encode(array("status" => false , 'data' => $data));
        }
    }

    function update(){
        helper(['form', 'url']);
        
        $model = new CustomerModel();

        $id = $this->request->getPost('id');
        
        $data = [
            'first_name'	=>	$this->request->getPost('first_name'),
            'last_name'	    =>	$this->request->getPost('last_name'),
            'address'        =>	$this->request->getPost('address'),
            'city'	=>	$this->request->getVar('city'),
            'dob'	    =>	$this->request->getVar('dob'),
            'nic'        =>	$this->request->getVar('nic'),
            'gender'	=>	$this->request->getVar('gender'),
            'contact_no'	    =>	$this->request->getVar('contact_no'),
            'email'        =>	$this->request->getVar('email'),
            'line_id'        =>	$this->request->getVar('line'),
            'status'        =>	$this->request->getVar('status')
        ];

        $result = $model->update_data($id, $data);

        if($result != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $data));
        }else{
            echo json_encode(array("status" => false , 'data' => $data));
        }
        
    }

    function delete(){
        helper(['form', 'url']);
        
        $model = new CustomerModel();

        $id = $this->request->getPost('id');
        
        $data = [
            'status'        =>	3
        ];

        $result = $model->delete_data($id, $data);

        if($result != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $data));
        }else{
            echo json_encode(array("status" => false , 'data' => $data));
        }
        
    }

    function by_id(){
        helper(['form', 'url']);
        
        $model = new CustomerModel();

        $id = $this->session->get('id'); 
        //$id = 2;

        $result = $model->get_data_by_id($id); 

        if($result != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $result));
        }else{
            echo json_encode(array("status" => false , 'data' => $result));
        }
        
    }

    function loan_data_by_customer_id(){
        helper(['form', 'url']);
          
        $model = new LoanModel();

        $id = $this->session->get('id'); 
        //$id = 2;

        $result = $model->get_loan_data_by_customer_id($id);

        if($result != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $result));
        }else{
            echo json_encode(array("status" => false , 'data' => $result));
        }
        
    }
////
    function get_payment_data_by_customer_id(){ 
        helper(['form', 'url']);
          
        $model = new PaymentModel();

        $id = $this->session->get('id'); 
        //$id = 2;

        $result = $model->get_data($id);

        if($result != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $result));
        }else{
            echo json_encode(array("status" => false , 'data' => $result));
        }
        
    }

	
}
