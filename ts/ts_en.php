<?php
class TS {
	const AppName = "Salsassoc";

	// Global
	const CurrencyText = "%0.2f %s";
	const ShortDateText = "m/d/Y";
	const Yes = "Yes";
	const No = "No";
	const Unknown = "Unknown";
	const Currency = "EUR";
	const Date = "Date";

	const DatabaseError = "Database error : %s => %s : %s";

	// Main
	const Main_Welcome = "Welcome to ".TS::AppName." manager !";
	const Main_Menu_Members = "Members";
	const Main_Menu_People = "People";
	const Main_Menu_Cotisations = "Cotisations";
	const Main_Menu_FiscalYears = "Fiscal years";
	const Main_Menu_Accounting = "Accounting";
	const Main_Menu_Logout = "(Logout)";

	// Fiscal years
	const FiscalYear_FiscalYearCount = "Fiscal year count: %d";
	const FiscalYear_Label = "Label";
	const FiscalYear_YearTitle = "Year #%d";
	const FiscalYear_StartDate = "Start date";
	const FiscalYear_EndDate = "End date";
	const FiscalYear_Members = "Members";
	const FiscalYear_MembershipAmount = "Membership amount";
	const FiscalYear_View = "View";
	const FiscalYear_Form_GlobalInfo = "Global information";
	const FiscalYear_Title = "Title";
	const FiscalYear_IsCurrent = "Current year";
	const FiscalYear_EditFiscalYear = "Edit fiscal year";

	// Cotisation
	const Cotisation_Cotisation = "Cotisation";
	const Cotisation_CotisationAll = "All cotisations";
	const Cotisation_CotisationMembership = "Membership only";
	const Cotisation_CotisationRegister = "Register a membership";
	const Cotisation_NewRegister = "New membership";
	const Cotisation_CotisationCount = "Cotisation count: %d";
	const Cotisation_Label = "Label";
	const Cotisation_Type = "Type";
	const Cotisation_StartDate = "Start date";
	const Cotisation_EndDate = "End date";
	const Cotisation_BasicPrice = "Basic price";
	const Cotisation_Members = "Members";
	const Cotisation_AmountCollected = "Amount collected";
	const Cotisation_View = "View";
	const Cotisation_MembersCount = "%d members";
	const Cotisation_Type_Membership = "Membership";
	const Cotisation_Type_Course = "Course";
	const Cotisation_CotisationMemberInfos = "Member informations";
	const Cotisation_CotisationList = "Cotisations list";

	// Person
	const Person_Members = "Members";
	const Person_MemberNum = "Member #%d";
	const Person_CurrentMembers = "Actual members";
	const Person_AllMembers = "All members";
	const Person_AddMember = "Add a member";
	const Person_PersonCount = "Number of members: %d";
	const Person_Add = "Add";
    const Person_MemberId = "Member #%d";
	const Person_Lastname = "Lastname";
	const Person_Firstname = "Firstname";
	const Person_Birthdate = "Birthdate";
	const Person_Email = "E-mail";
	const Person_Phonenumber = "Phone number";
	const Person_ImageRights = "Image rights";
	const Person_DateCreated = "Creation date";
	const Person_YearCount = "Year count";
	const Person_View = "View";
	const Person_YearCountText = "%d year(s)";
	const Person_OldMember = "Old member";
	const Person_Form_GlobalInfo = "Global information";
	const Person_Comments = "Comments";

    // Accounting
    const Accounting_OperationAll = "All operations";
    const Accounting_Accounts = "Accounts";

    // Accounting operation
    const AccountingOperation_OperationCount = "Operation count: %d";
    const AccountingOperation_Label = "Label";
    const AccountingOperation_Category = "Category";
    const AccountingOperation_DateValue = "Date";
    const AccountingOperation_Type = "Type";
    const AccountingOperation_Amount = "Amount";
    const AccountingOperation_View = "View";

    // Accounting operation type
    const AccountingOperationType_Debit = "Debit";
    const AccountingOperationType_Credit = "Credit";

    // Accountint account
    const AccountingAccount_AccountCount = "Account count: %d";
    const AccountingAccount_Label = "Label";
    const AccountingAccount_Type = "Type";
    const AccountingAccount_Amount = "Amount";
    const AccountingAccount_View = "View";

	// Payment
	const Payment_Payment = "Payment";
	const PaymentMethod_None = "None";
	const PaymentMethod_Check = "Check";
	const PaymentMethod_Cash = "Cash";

	// Account type
	const AccountType_Unknown = "Unknown";
	const AccountType_CashBox = "Cash Box";
	const AccountType_BankAccount = "Bank account";

};
?>
