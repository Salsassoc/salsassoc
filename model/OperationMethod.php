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
};

?>
