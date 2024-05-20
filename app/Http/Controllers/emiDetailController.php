<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\LoanDetail;
use App\EmiDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



class emiDetailController extends Controller
{
    private $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
    private $tableName ="emi_details";
    public function index()
    {
        $emi_data = $emi_column = $errors= $loanDetails=[];
        return view('test.process_data',compact('emi_data', 'emi_column', 'errors'));
    }

    public function EmiDetail(Request $res){

        if(!session('repeat')){
            session(['repeat' => 1]);
        }else{
            session()->forget('repeat');
            return redirect()->route('loan-details');
        }

        $loanDetails = LoanDetail::all(); 
        $minDate     = Carbon::parse($loanDetails->min('first_payment_date'));
        $maxDate     = Carbon::parse($loanDetails->max('last_payment_date'));
        $monthdDiff  = $minDate->diffInMonths($maxDate);
        $errors      = [];
        
        $emi_column = ['clientId'=>0];
        $sql_query = "CREATE TABLE emi_details (id INT AUTO_INCREMENT PRIMARY KEY,clientId INT,";

        $year   = $minDate->year; 
        $m      = $minDate->month;
        $limit  = $monthdDiff + $m;
       
        for($i=$m;$i<=$limit;$i++){
            $sql_query .= $year."_".$this->months[$m]." DECIMAL(10, 2),";
           
            $emi_column [$year."_".$this->months[$m]] = 0;
            $m++;
            if($i%12==0){
                $m =1;
                $year++;
            }
        }

        $sql_query .= "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

        if (Schema::hasTable($this->tableName)) {
            DB::statement("DROP TABLE ".$this->tableName);
        } 

        DB::statement($sql_query);

        if (!Schema::hasTable($this->tableName)){
            $errors[] = "table is not created";
            return view('test.process_data', compact('emi_data', 'emi_column', 'errors'));
        }
    
        foreach($loanDetails as $loan){
                 $amount            = $loan->loan_amount;
                 $startDate         = Carbon::parse($loan->first_payment_date);
                 $lastDate          = Carbon::parse($loan->last_payment_date);
                 $remPayments       = $loan->num_of_payment;
                 $amountPerMonth    = round($amount/$remPayments,2);
                 $lastMonthPayment  =  $amount - ($remPayments-1)*$amountPerMonth;
                 $y                 = $startDate->year; 
                 $m    =  $limit_m          = $startDate->month;
                 for($i=$m; $i<$remPayments+ $limit_m ; $i++){
                      $column_name = $y."_".$this->months[$m];
                      $emi_column[$column_name] = $amountPerMonth;
                      $m++;
                      if($i%12==0){
                        $m =1;
                        $y++;
                    }
                 }
                 $last_column       = $lastDate->year."_".$this->months[$lastDate->month];
                 $emi_column[$last_column] = $lastMonthPayment;
                 $emi_column['clientId'] = $loan->clientid;



                 $check = EmiDetails::create($emi_column);
                 $emi_column = array_fill_keys(array_keys($emi_column), 0);
                 if(!$check);
                 {
                    $error[] = 'error while inserting the data' ;
                 }
        }

        $emi_data = EmiDetails::all();
        return view('test.process_data', compact('emi_data', 'emi_column', 'errors','loanDetails'));
    }
}
