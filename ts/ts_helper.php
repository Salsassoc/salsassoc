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

	public static function getCotisationType($type)
	{
		switch($type){
		case 1: return TS::Cotisation_Type_Membership;
		case 2: return TS::Cotisation_Type_Course;
		default: break;
		}
		return "";
	}
};
?>
