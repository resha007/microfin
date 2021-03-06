<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class LoanModel extends Model
{
    protected $table = 'loan';

    protected $primaryKey = 'id';
    
    protected $allowedFields = ['id','customer_id','reason','guarantor_1','guarantor_2','loan_amount','loan_period','loan_interest','created_date','created_by','status','approved_date','approved_by','effective_date'];

    public function __construct() {
        parent::__construct();
        
        $db = \Config\Database::connect();
        $builder = $db->table('loan');
    }
    

    //get guartntors in the db
    function getguarntorlist() {

        // $query = $db->query('YOUR QUERY HERE');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT id, CONCAT((first_name),(' '),(last_name)) as name from customer");
         return $query->getresult();


    }

    //get customer loans by loan id
    public function get_data($id = false) {//$id=1;
        if($id === false) {
            return $this->join('customer', 'customer.id = loan.customer_id', 'LEFT')->join('employee', 'employee.id = loan.created_by', 'LEFT')->select('loan.*')->select('employee.username as username')->select("CONCAT(customer.first_name, ' ', customer.last_name) as customer_id")->where('loan.status', 1)->findAll();
            
        } else {
            return $this->where('status', 1)->findAll();
        }
    }

    //get approved loans
    public function get_approved($id = false) {//$id=1;
        if($id === false) {
            return $this->join('customer', 'customer.id = loan.customer_id', 'LEFT')->join('employee', 'employee.id = loan.created_by', 'LEFT')->select('loan.*')->select('employee.username as username')->select("CONCAT(customer.first_name, ' ', customer.last_name) as customer_id")->where('loan.status', 2)->findAll();
           
        } else {
            return $this->where('status', 1)->findAll();
        }
    }

    public function insert_data($data) {
        if($this->db->table($this->table)->insert($data)){
                return true;
            }
            else{
                return false;
            }
    }

    public function update_data($id,$data) {
        if($this->update($id,$data)){
            return true;
        }
        else{
            return false;
        }
    }

    public function delete_data($id,$data) {
        if($this->update($id,$data)){
            return true;
        }
        else{
            return false;
        }
    }

    //add pending loans to the data table
    public function get_loan_data_by_id($id) {
        $this->join('employee', 'employee.id = loan.created_by', 'LEFT');
        $this->select('employee.username as username');
        return $this->where('loan.id', $id)->first();

    }


    //Imal- For Payment Implementation 
    public function get_data_by_line($id) {
        $this->join('customer', 'customer.id = loan.customer_id', 'LEFT');
        $this->join('line', 'line.id = customer.line_id', 'LEFT');
        $this->select("CONCAT(line.code, ' ', line.name) as line");
        $this->select("CONCAT(customer.first_name, ' ', customer.last_name) as customer");
        $this->select("CONCAT(loan.id) as loanid");
        $this->select("CONCAT(loan.loan_amount) as loanamount");
        $this->where('customer.line_id', $id);
        return $this->findAll();
    }

    // public function get_data_by_line($lineid) {
    //     // $this->join('line', 'line.id = customer.line_id', 'LEFT');
    //     $this->join('loan', 'customer.id = loan.customer_id', 'LEFT');
    //     return $this->where('customer.line_id', $lineid)->first();

    // }

    public function get_loan_data_by_customer_id($id) {
        
        // $this->join('line', 'line.id = customer.line_id', 'LEFT');
        // $this->select('customer.*');
        // $this->select("CONCAT(line.code, ' - ', line.name) as line");
        // //$this->where('status', 1);
        // return $this->findAll();
        $this->join('customer', 'customer.id = loan.customer_id', 'LEFT');
        $this->join('customer cust', 'cust.id = loan.guarantor_1', 'LEFT');
        $this->join('customer cust1', 'cust1.id = loan.guarantor_2', 'LEFT');
        $this->select('loan.*');
        $this->select("CONCAT(customer.first_name, ' ', customer.last_name) as customer");
        $this->select('customer.*');
        $this->select("CONCAT(cust.first_name) as name");
        $this->select("CONCAT(cust1.first_name) as name2");
        $this->where('customer.id', $id);
        $this->orwhere('loan.status', 1);
        $this->Where('loan.status', 2);
        return $this->findAll();
        //return $this->where('status', 1)->orWhere('status', 2)->findAll();
        
    
    }

    public function get_loan_data_by_loan_id($id) {
     
        $this->join('customer', 'customer.id = loan.customer_id', 'LEFT'); 
        $this->join('customer cust', 'cust.id = loan.guarantor_1', 'LEFT');
        $this->join('customer cust1', 'cust1.id = loan.guarantor_2', 'LEFT');
        $this->join('employee', 'employee.id = loan.created_by', 'LEFT');
        $this->select('loan.*');
        $this->select('loan.reason as reason');
        $this->select("CONCAT(customer.first_name, ' ', customer.last_name) as customer");
         $this->select('employee.username as username');
        // $this->select('customer.*');
        $this->select("CONCAT(cust.first_name, ' ', cust.last_name) as guarantor_1");
        $this->select("CONCAT(cust1.first_name, ' ', cust1.last_name) as guarantor_2");
        
        return $this->where('loan.id', $id)->first();
    }


}
?>
