<?php
class TSHelper
{
	public static function getCurrencyText($amout, $currency = "EUR")
	{
		return sprintf(TS::CurrencyText, $amout, $currency);
	}

	public static function getShortDateTextFromDBDate($dbdate)
	{
		return date(TS::ShortDateText, strtotime($dbdate));
	}

	public static function getShortDateText($timestamp)
	{
		return date(TS::ShortDateText, $timestamp);
	}
};
?>
