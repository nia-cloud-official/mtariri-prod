<?php 

class Payment { 
    private $paymentType; 
    private $paymentMethod; 
    private $paymentBankAccount;
    private $paymentPendingAmount;
    private $InitialPaymentAmount;
    private $paymentDueDate;
    private $paymentStatus;
    private $ecocashAccount;
    private $paypalAccount;
    private $amountToPay;
    public $paymentMethods;

    
    public function __construct(){
        # [ Nothing to do here ]
    }

    public function executePayment(/*$paymentType,*/ $paymentMethod/*,$InitialPaymentAmount,$amountToPay*/){
        $paymentMethods = array(file_get_contents('paymentMethods.json'));
         foreach ($paymentMethods as $method => $value) {
            echo $method["2"];
         }
        if($paymentMethod === $value[1]){
            
        }else if($paymentMethod === $value[2]){
            
        }else if($paymentMethod === $value[3]){
            
        }
    }
}


$pay = new Payment();
$pay->executePayment("ecocash");
?>