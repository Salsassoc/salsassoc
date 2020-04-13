<?php

class OperationMethod
{
	const Unknown = 0;
	const CheckDeposit = 10; // Credit
	const CheckPayment = 11; // Debit
	const CashDeposit = 20; // Credit
    const CashWithdrawal = 21; // Debit
    const BankTransfertReceived = 30; // Credit
    const BankTransfertIssued = 31; // Debit
    const BankDirectDebit = 32; // Debit
    const BankInterest = 33; // Credit

    public static function getOperationMethodList()
    {
        $listOpMethod = array();
        $listOpMethod[0] = OperationMethod::Unknown;
        $listOpMethod[1] = OperationMethod::CheckDeposit;
        $listOpMethod[2] = OperationMethod::CheckPayment;
        $listOpMethod[3] = OperationMethod::CashDeposit;
        $listOpMethod[4] = OperationMethod::CashWithdrawal;
        $listOpMethod[5] = OperationMethod::BankTransfertReceived;
        $listOpMethod[6] = OperationMethod::BankTransfertIssued;
        $listOpMethod[7] = OperationMethod::BankDirectDebit;
        $listOpMethod[8] = OperationMethod::BankInterest;
        return $listOpMethod;
    }
};

?>
