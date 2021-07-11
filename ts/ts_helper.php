<?php
class TSHelper
{
	public static function getYesNoUnknownText($bool)
	{
		if($bool != null){
			return ($bool == 'false' ? TS::No : TS::Yes);
		}
		return "?";
	}

	public static function getCurrencyText($amout, $currency = "EUR")
	{
		return sprintf(TS::CurrencyText, $amout, $currency);
	}

	public static function getShortDateTextFromDBDate($dbdate)
	{
		if($dbdate != null){
			return date(TS::ShortDateText, strtotime($dbdate));
		}
		return "";
	}

	public static function getShortDateText($timestamp)
	{
		return date(TS::ShortDateText, $timestamp);
	}

	public static function getMembershipType($type)
	{
		switch($type){
		case 1: return TS::MembershipType_MembershipStandard;
		case 2: return TS::MembershipType_MembershipDiscounted;
		case 3: return TS::MembershipType_ExecutiveBoard;
		case 4: return TS::MembershipType_Professor;
		default: break;
		}
		return "";
	}


	public static function getCotisationType($type)
	{
		switch($type){
		case 1: return TS::Cotisation_Type_Membership;
		case 2: return TS::Cotisation_Type_Course;
		case 3: return TS::Cotisation_Type_Gift;
		case 4: return TS::Cotisation_Type_Credit;
		default: break;
		}
		return "";
	}

	public static function getPaymentMethod($method)
	{
		switch($method){
		case 0: return TS::PaymentMethod_None;
		case 1: return TS::PaymentMethod_Check;
		case 2: return TS::PaymentMethod_Cash;
		case 3: return TS::PaymentMethod_CreditCard;
		default: break;
		}
		return "";
	}

	public static function getAccountingOperationType($type)
	{
		switch($type){
		case 1: return TS::AccountingOperationType_Debit;
		case 2: return TS::AccountingOperationType_Credit;
		default: break;
		}
		return "";
	}

	public static function getAccountType($type)
	{
		switch($type){
		case 1: return TS::AccountType_CashBox;
		case 2: return TS::AccountType_BankAccount;
		default: break;
		}
		return TS::AccountType_Other;
	}

	public static function getAccountingOperationMethod($method)
	{
		switch($method){
		case OperationMethod::Unknown: return TS::AccountingOperationMethod_Unknown;
		case OperationMethod::CheckDeposit: return TS::AccountingOperationMethod_CheckDeposit;
		case OperationMethod::CheckPayment: return TS::AccountingOperationMethod_CheckPayment;
		case OperationMethod::CashDeposit: return TS::AccountingOperationMethod_CashDeposit;
		case OperationMethod::CashWithdrawal: return TS::AccountingOperationMethod_CashWithdrawal;
		case OperationMethod::BankTransfertReceived: return TS::AccountingOperationMethod_BankTransfertReceived;
		case OperationMethod::BankTransfertIssued: return TS::AccountingOperationMethod_BankTransfertIssued;
		case OperationMethod::BankDirectDebit: return TS::AccountingOperationMethod_BankDirectDebit;
		case OperationMethod::BankInterest: return TS::AccountingOperationMethod_BankInterest;
		default: break;
		}
		return "";
	}

	public static function pdoErrorText($pdoErrors)
	{
		return sprintf(TS::DatabaseError, $pdoErrors[0], $pdoErrors[1], $pdoErrors[2]);
	}
};
?>
