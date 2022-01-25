<?php

namespace App\Controllers;

use App\Models\LoanModel;
use CodeIgniter\Controller;

class Loan extends Controller
{
    

    public function index()
    {
        $LoanModel = new LoanModel();


        //get guarntor names from the customer table
        $data['guarantordata'] = $LoanModel->getguarntorlist();


		return view('loan_new', $data);
    }

    function get(){ 
        $LoanModel = new LoanModel();

		//$data = $CustomerModel->where("status='1' OR status='2'")->orderBy('id', 'ASC')->paginate(10);
        $data = $LoanModel->get_data();

        //set numbers to names
        for($i=0;$i<sizeof($data);$i++){
            if($data[$i]["created_by"] == 1){
                $data[$i]["created_by"] = "Admin";
            }else{
                $data[$i]["created_by"] = "Rider";
            }

            if($data[$i]["status"] == 1){
                $data[$i]["status"] = "Pending";
            }else if($data[$i]["status"] == 2){
                $data[$i]["status"] = "Approved";
            }
        }
        

		echo json_encode($data);
	}

	function save(){
        helper(['form', 'url']);
        
        $model = new LoanModel();
        
        $data = [
            'customer_id'	=>	$this->request->getVar('customer_id'),
            'reason'	    =>	$this->request->getPost('reason'),
            'guarantor_1'   =>	$this->request->getVar('guarantor_1'),
            'guarantor_2'	=>	$this->request->getVar('guarantor_2'),
            'loan_amount'	=>	$this->request->getPost('loan_amount'),
            'loan_period'   =>	$this->request->getVar('loan_period'),
            'loan_interest'	=>	$this->request->getVar('loan_interest'),
            'created_by'    =>	$this->request->getVar('created_by'),
            'status'	    =>	$this->request->getVar('status')
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
        
        $model = new LoanModel();

        $id = $this->request->getPost('id');
        
        $data = [
            'customer_id'	=>	$this->request->getVar('customer_id'),
            'reason'	    =>	$this->request->getPost('reason'),
            'guarantor_1'        =>	$this->request->getVar('guarantor_1'),
            'guarantor_2'	=>	$this->request->getVar('guarantor_2'),
            'loan_amount'	    =>	$this->request->getPost('loan_amount'),
            // 'loan_period'        =>	$this->request->getVar('loan_period'),
            // 'loan_interest'	=>	$this->request->getVar('loan_interest'),
            'created_by'	    =>	$this->request->getVar('created_by'),
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
        
        $model = new LoanModel();

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

    //get the customer id for current customer
    function loan_by_id(){
        helper(['form', 'url']);
        
        $model = new LoanModel();

        $id = $this->request->getPost('id');

        $result = $model->get_loan_data_by_id($id);

        if($result != false){
            //$data = $model->where('id', $save_data)->first();
            echo json_encode(array("status" => true , 'data' => $result));
        }else{
            echo json_encode(array("status" => false , 'data' => $result));
        }
        
    }

    




    // function calculate total_amount_per_day(){
    //     $model = new LoanModel();
        
            // $loan_interest_rate=$this->request->getVar('loan_interest')/100
            // $total_interast_amount=$this->request->getPost('loan_amount')*$loan_interest_rate
            // $total_amount=$this->request->getPost('loan_amount') + $total_interast_amount
            // $repay_per_day=$total_amount/65
            /*loan_interest_rate = 30/100 = 0.3
            To get the interest to the principal amount(total_interast_amount)= principal amount*0.3
            Total payeble amount=principal amount + total_interast_amount
            Amount to pay in 65 days = total payable amount/65 */
    // }

	//Imal - for Payment Implementation
    function byline(){
        helper(['form', 'url']);
        
        
        $model = new LoanModel();

        $id = $this->request->getPost('line_id');

        $result = $model->get_data_by_line($id);

        if($result != false){
            //$data = $model->where('id', $id->first();
            echo json_encode(array("status" => true , 'data' => $result));
        }else{
            echo json_encode(array("status" => false , 'data' => "empty"));
        }
        
    }
}

?>

