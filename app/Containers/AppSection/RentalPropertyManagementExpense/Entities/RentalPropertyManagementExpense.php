<?php

namespace App\Containers\AppSection\RentalPropertyManagementExpense\Entities;

use Doctrine\ORM\Mapping as ORM;


class RentalPropertyManagementExpense
{
    protected $pro_rentals_property_management_id;
    protected $due_date;
    protected $tax;
    protected $user_id;
    protected $role_id;
    protected $worker_name;
    protected $worker_mobile_no;
    protected $worker_email;
    protected $worker_amount;
    protected $worker_amount_paid_status;
    protected $worker_amount_paid_transaction;
    protected $worker_notes;
    protected $status;
    protected $total_amount;
    protected $amount_receive_status;
    protected $amount_commission;
    protected $amount_receive_transaction;

    protected $worker_amount_paid_date;
    protected $amount_recieve_date;
    protected $amount_type;
    protected $worker_amount_type;


    protected $pro_rentals_property_management_expense_id;
    protected $worker_id;
    protected $worker_details_id;
    protected $expense_details;
    protected $worker_details;
    protected $expense_management_master_id;
    protected $amount;
    protected $property_damage_image_1;
    protected $property_damage_image_2;

    protected $search_val;
    protected $field_db;
    protected $per_page;
    protected $start_date;
    protected $end_date;
    protected $from;
    protected $to;

    public function __construct($request = null)
    {
        $this->worker_amount_type = isset($request['worker_amount_type']) ? $request['worker_amount_type'] : null;
        $this->due_date = isset($request['due_date']) ? $request['due_date'] : null;
        $this->amount_type = isset($request['amount_type']) ? $request['amount_type'] : null;
        $this->tax = isset($request['tax']) ? $request['tax'] : null;
        $this->user_id = isset($request['user_id']) ? $request['user_id'] : null;
        $this->role_id = isset($request['role_id']) ? $request['role_id'] : null;
        $this->worker_amount_paid_date = isset($request['worker_amount_paid_date']) ? $request['worker_amount_paid_date'] : null;
        $this->amount_recieve_date = isset($request['amount_recieve_date']) ? $request['amount_recieve_date'] : null;

        $this->expense_details = isset($request['expense_details']) ? $request['expense_details'] : null;
        $this->worker_details = isset($request['worker_details']) ? $request['worker_details'] : null;

        $this->pro_rentals_property_management_id = isset($request['pro_rentals_property_management_id']) ? $request['pro_rentals_property_management_id'] : null;
        $this->worker_id = isset($request['worker_id']) ? $request['worker_id'] : null;
        $this->worker_details_id = isset($request['worker_details_id']) ? $request['worker_details_id'] : null;


        $this->worker_name = isset($request['worker_name']) ? $request['worker_name'] : null;
        $this->worker_mobile_no = isset($request['worker_mobile_no']) ? $request['worker_mobile_no'] : null;
        $this->worker_email = isset($request['worker_email']) ? $request['worker_email'] : null;
        $this->worker_amount = isset($request['worker_amount']) ? $request['worker_amount'] : null;
        $this->worker_amount_paid_status = isset($request['worker_amount_paid_status']) ? $request['worker_amount_paid_status'] : null;
        $this->worker_amount_paid_transaction = isset($request['worker_amount_paid_transaction']) ? $request['worker_amount_paid_transaction'] : null;
        $this->worker_notes = isset($request['worker_notes']) ? $request['worker_notes'] : null;
        $this->status = isset($request['status']) ? $request['status'] : null;
        $this->total_amount = isset($request['total_amount']) ? $request['total_amount'] : null;
        $this->amount_receive_status = isset($request['amount_receive_status']) ? $request['amount_receive_status'] : null;
        $this->amount_commission = isset($request['amount_commission']) ? $request['amount_commission'] : null;
        $this->amount_receive_transaction = isset($request['amount_receive_transaction']) ? $request['amount_receive_transaction'] : null;

        $this->pro_rentals_property_management_expense_id = isset($request['pro_rentals_property_management_expense_id']) ? $request['pro_rentals_property_management_expense_id'] : null;
        $this->expense_management_master_id = isset($request['expense_management_master_id']) ? $request['expense_management_master_id'] : null;
        $this->amount = isset($request['amount']) ? $request['amount'] : null;
        $this->property_damage_image_1 = isset($request['property_damage_image_1']) ? $request['property_damage_image_1'] : null;
        $this->property_damage_image_2 = isset($request['property_damage_image_2']) ? $request['property_damage_image_2'] : null;

        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
        $this->start_date = isset($request['start_date']) ? $request['start_date'] : null;
        $this->end_date = isset($request['end_date']) ? $request['end_date'] : null;
        $this->from = isset($request['from']) ? $request['from'] : null;
        $this->to = isset($request['to']) ? $request['to'] : null;
    }

    public function getFromDate()
    {
        return $this->from;
    }
    public function getToDate()
    {
        return $this->to;
    }
    public function getStartDate()
    {
        return $this->start_date;
    }
    public function getEndDate()
    {
        return $this->end_date;
    }
    public function getWorkerAmountType()
    {
        return $this->worker_amount_type;
    }

    public function getDueDate()
    {
        return $this->due_date;
    }


    public function getAmountType()
    {
        return $this->amount_type;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function getworkerAmountPaidDate()
    {
        return $this->worker_amount_paid_date;
    }

    public function getAmountRecieveDate()
    {
        return $this->amount_recieve_date;
    }


    public function getExpenseDetails()
    {
        return $this->expense_details;
    }
    public function getWorkerDetails()
    {
        return $this->worker_details;
    }

    public function getProRentalsPropertyManagementId()
    {
        return $this->pro_rentals_property_management_id;
    }
    public function getWorkerId()
    {
        return $this->worker_id;
    }
    public function getWorkerDetailsId()
    {
        return $this->worker_details_id;
    }



    public function getWorkerName()
    {
        return $this->worker_name;
    }

    public function getWorkerMobileNo()
    {
        return $this->worker_mobile_no;
    }

    public function getWorkerEmail()
    {
        return $this->worker_email;
    }

    public function getWorkerAmount()
    {
        return $this->worker_amount;
    }

    public function getWorkerAmountPaidStatus()
    {
        return $this->worker_amount_paid_status;
    }

    public function getWorkerAmountPaidTransaction()
    {
        return $this->worker_amount_paid_transaction;
    }

    public function getWorkerNotes()
    {
        return $this->worker_notes;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    public function getAmountReceiveStatus()
    {
        return $this->amount_receive_status;
    }

    public function getAmountCommission()
    {
        return $this->amount_commission;
    }

    public function getAmountReceiveTransaction()
    {
        return $this->amount_receive_transaction;
    }


    public function getProRentalsPropertyManagementExpenseId()
    {
        return $this->pro_rentals_property_management_expense_id;
    }

    public function getExpenseManagementMasterId()
    {
        return $this->expense_management_master_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPropertyDamageImage1()
    {
        return $this->property_damage_image_1;
    }

    public function getPropertyDamageImage2()
    {
        return $this->property_damage_image_2;
    }




    public function getSearchVal()
    {
        return $this->search_val;
    }

    public function getFieldDB()
    {
        return $this->field_db;
    }

    public function getPerPage()
    {
        return $this->per_page;
    }
}
