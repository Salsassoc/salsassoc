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

	public static function pdoErrorText($pdoErrors)
	{
		return sprintf(TS::DatabaseError, $pdoErrors[0], $pdoErrors[1], $pdoErrors[2]);
	}
};
?>
