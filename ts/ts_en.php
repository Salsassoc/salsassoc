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
	const Main_Menu_Memberships = "Memberships";
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
	const FiscalYear_Members_CotisationsAmount = "Cotisations amount";
	const FiscalYear_Members_CotisationsPaymentMethod = "Payment method";
	const FiscalYear_OperationsCount = "%d operations";

	// Cotisation
	const Cotisation_Cotisation = "Cotisation";
	const Cotisation_CotisationTitle = "Cotisation #%d";
	const Cotisation_CotisationAll = "All cotisations";
	const Cotisation_CotisationMembership = "Membership only";
	const Cotisation_CotisationRegister = "Register a membership";
	const Cotisation_NewRegister = "New membership";
	const Cotisation_Form_GlobalInfo = "Global information";
	const Cotisation_CotisationCount = "Cotisation count: %d";
	const Cotisation_Label = "Label";
	const Cotisation_Type = "Type";
	const Cotisation_StartDate = "Start date";
	const Cotisation_EndDate = "End date";
	const Cotisation_BasicPrice = "Basic price";
	const Cotisation_FiscalYear = "Year";
	const Cotisation_Members = "Members";
	const Cotisation_AmountCollected = "Amount collected";
	const Cotisation_Add = "Add";
	const Cotisation_View = "View";
	const Cotisation_MembersCount = "%d members";
	const Cotisation_Type_Membership = "Membership";
	const Cotisation_Type_Course = "Course";
	const Cotisation_Type_Gift = "Gift";
	const Cotisation_Type_Credit = "Credit";
	const Cotisation_CotisationList = "Cotisations list";
	const Cotisation_AddNew = "Add a cotisation";

    // Membership
	const Membership_Memberships = "Memberships";
	const Membership_MembershipAll = "Memberships";
	const Membership_AddMembership = "Add a membership";
	const Membership_MembershipCount = "Memberships count : %d";
	const Membership_Date = "Date";
	const Membership_Type = "Type";
	const Membership_View = "View";
    const Membership_Num = "Membership #%d";
	const Membership_MemberInfos = "Member informations";
	const Membership_Membership = "Membership";
	const Membership_Comments = "Comments";

    // Membership type
	const MembershipType_MembershipStandard = "Standard";
	const MembershipType_MembershipDiscounted = "Avantages jeunes";
	const MembershipType_ExecutiveBoard = "Executive board";
	const MembershipType_Professor = "Professor";

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
	const Person_Address = "Address";
	const Person_Zipcode = "Zipcode";
	const Person_City = "City";
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
	const Person_Check = "Check";

    // Accounting
    const Accounting_OperationAll = "All operations";
    const Accounting_Accounts = "Accounts";
    const Accounting_AccountAdd = "Add account";
    const Accounting_OperationCategoryList = "Categories";
    const Accounting_OperationCategoryAdd = "Add a catogory";
    const Accounting_OperationAdd = "Add an operation";

    // Accounting operation
    const AccountingOperation_OperationCount = "Operation count: %d";
    const AccountingOperation_Label = "Label";
    const AccountingOperation_LabelBank = "Bank label";
    const AccountingOperation_Number = "Number";
    const AccountingOperation_Category = "Category";
    const AccountingOperation_DateValue = "Date";
    const AccountingOperation_DateEffective = "Date effective";
    const AccountingOperation_Type = "Type";
    const AccountingOperation_Amount = "Amount";
    const AccountingOperation_AmountDebit = "Debit";
    const AccountingOperation_AmountCredit = "Credit";
    const AccountingOperation_FiscalYear = "Fiscal year";
    const AccountingOperation_CalendarYear = "Calendar year";
    const AccountingOperation_Account = "Account";
    const AccountingOperation_View = "View";
	const AccountingOperation_Form_GlobalInfo = "Global information";
	const AccountingOperation_Form_Transaction = "Transaction";
	const AccountingOperation_Form_Account = "Account";


    // Accounting operation type
    const AccountingOperationType_Debit = "Debit";
    const AccountingOperationType_Credit = "Credit";

    // Accountint operation category
    const AccountingOperationCategory_AddCategory = "Add a category";
    const AccountingOperationCategory_ViewCategory = "Category #%d";
    const AccountingOperationCategory_List = "Category list";
	const AccountingOperationCategory_Form_GlobalInfo = "Global information";
    const AccountingOperationCategory_Count = "Category count: %d";
    const AccountingOperationCategory_Label = "Label";
    const AccountingOperationCategory_View = "View";

    // Accountint operation method
	const AccountingOperationMethod_Unknown = "Unknown";
	const AccountingOperationMethod_CheckDeposit = "Check deposit";
	const AccountingOperationMethod_CheckPayment = "Check payment";
	const AccountingOperationMethod_CashDeposit = "Cash deposit";
    const AccountingOperationMethod_CashWithdrawal = "Cash withdrawal";
    const AccountingOperationMethod_BankTransfertReceived = "Transfert received";
    const AccountingOperationMethod_BankTransfertIssued = "Transfert issued";
    const AccountingOperationMethod_BankDirectDebit = "Direct debit";
    const AccountingOperationMethod_BankInterest = "Interest";

    // Accountint account
    const AccountingAccount_List = "Account list";
	const AccountingAccount_Form_GlobalInfo = "Global information";
    const AccountingAccount_AccountCount = "Account count: %d";
    const AccountingAccount_Label = "Label";
    const AccountingAccount_Type = "Type";
    const AccountingAccount_Operations = "Operations";
    const AccountingAccount_AmountIncomings = "Recettes";
    const AccountingAccount_AmountOutcomings = "Dépenses";
    const AccountingAccount_AmountBalance = "Balance";
    const AccountingAccount_View = "View";

	// Payment
	const Payment_Payment = "Payment";
	const PaymentMethod_None = "None";
	const PaymentMethod_Check = "Check";
	const PaymentMethod_Cash = "Cash";
	const PaymentMethod_CreditCard = "Credit card";

	// Account type
	const AccountType_Other = "Other";
	const AccountType_CashBox = "Cash Box";
	const AccountType_BankAccount = "Bank account";

};
?>
