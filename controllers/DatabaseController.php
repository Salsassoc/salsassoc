<?php

class DatabaseController
{
    private $_conn;
    private $_errors;

    function __construct($conn, &$errors)
    {
        $this->_conn = $conn;
        $this->_errors = &$errors;
    }
     
    public function fetch($sql, &$results)
    {
        $res = true;

        $stmt = $this->_conn->prepare($sql);
        if($stmt){
            $res = $stmt->execute();
            if ($res) {
                $results = $stmt->fetch();
            }else{
                $this->_errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }
        }else{
	        $res = false;
            $this->_errors[] = TSHelper::pdoErrorText($this->_conn->errorInfo());
        }

        return $res;
    }
     
    public function fetchAll($sql, &$results)
    {
        $res = true;

        $stmt = $this->_conn->prepare($sql);
        if($stmt){
            $res = $stmt->execute();
            if ($res) {
                $results = $stmt->fetchAll();
            }else{
                $this->_errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }
        }else{
	        $res = false;
            $this->_errors[] = TSHelper::pdoErrorText($this->_conn->errorInfo());
        }

        return $res;
    }

    public function addWhere($szCurrentWhere, $cond)
    {
        if($szCurrentWhere != ""){
            return $szCurrentWhere." AND ".$cond;
        }else{
            return " WHERE ".$cond;
        }
    }

    //////////////////////
    // Around person
    //////////////////////

    public function getPersonYearCount(&$listPersonYearCount)
    {
        $sql = "SELECT person.id AS person_id, COUNT(DISTINCT fiscal_year_id) AS year_count";
        $sql .= " FROM person LEFT JOIN membership ON person.id = membership.person_id";
        $sql .= " GROUP BY person.id";
        return $this->fetchAll($sql, $listPersonYearCount);
    }

    public function getPersonListByFiscalYear($fiscalyear, &$listPersons)
    {
        $sql =  "SELECT person.id AS id, person.firstname AS firstname, person.lastname AS lastname, person.birthdate AS birthdate, person.zipcode AS zipcode, person.city AS city, person.email AS email, person.phonenumber AS phonenumber, person.phonenumber2 AS phonenumber2, person.image_rights AS image_rights, creation_date";
        $sql .= " FROM person LEFT JOIN membership ON person.id=person_id";
        $sql .= " WHERE fiscal_year_id=".$fiscalyear['id'];
        $sql .= " AND person_id=person.id";
        $sql .= " ORDER BY lastname, firstname";
        return $this->fetchAll($sql, $listPersons);
    }

    function getPersonListAll(&$listPersons)
    {
        $sql =  "SELECT person.id AS id, person.firstname AS firstname, person.lastname AS lastname, person.birthdate AS birthdate, person.zipcode AS zipcode, person.city AS city, person.email AS email, person.phonenumber AS phonenumber, person.phonenumber2 AS phonenumber2, person.image_rights AS image_rights, creation_date, COUNT(DISTINCT fiscal_year_id) AS year_count, COUNT(membership.id) AS membership_count";
        $sql .= " FROM person LEFT JOIN membership ON person.id=person_id";
        $sql .= " GROUP BY person.id";
        $sql .= " ORDER BY lastname, firstname";
        return $this->fetchAll($sql, $listPersons);
    }

    //////////////////////
    // Around fiscal year
    //////////////////////

    public function getFiscalYearCurrent(&$fiscalyear)
    {
        $sql = "SELECT id, title, start_date, end_date, is_current";
        $sql .= " FROM fiscal_year";
        $sql .= " WHERE is_current = 'true'";
        return $this->fetch($sql, $fiscalyear);
    }

    public function getFiscalYearById($fiscal_year_id, &$fiscalyear)
    {
        $sql = "SELECT id, title, start_date, end_date, is_current";
        $sql .= " FROM fiscal_year";
        $sql .= " WHERE id = ".$fiscal_year_id;
        return $this->fetch($sql, $fiscalyear);
    }

    public function getFiscalYearList(&$listFiscalYear, $filters = null)
    {
        $sql = "SELECT id, title, start_date, end_date, is_current";
        $sql .= " FROM fiscal_year";

        // filters
        if($filters != null){
            $szWhere = "";
            if(array_key_exists("id", $filters)){
                $szWhere = $this->addWhere($szWhere, "id=".$filters['id']);
            }
            $sql .= $szWhere;
        }

        $sql .= " ORDER BY start_date DESC";

        return $this->fetchAll($sql, $listFiscalYear);
    }

    public function getFiscalYearAccountingOperationResumeList(&$listAccountResume)
    {
        $sql =  "SELECT fiscalyear_id, SUM(amount_debit) as outcomings, SUM(amount_credit) as incomings";
        $sql .= " FROM accounting_operation, accounting_operation_category";
        $sql .= " WHERE accounting_operation.category = accounting_operation_category.id";
        $sql .= " AND is_internal_move = false";
        $sql .= " GROUP BY fiscalyear_id";
        return $this->fetchAll($sql, $listAccountResume);
    }

    //////////////////////
    // Around cotisations
    //////////////////////

    public function getCotisationList($bMembershipOnly, &$listCotisation)
    {
        $sql = "SELECT id, label, type, amount, start_date, end_date, fiscal_year_id";
        $sql .= " FROM cotisation";
	    if($bMembershipOnly){
		    $sql .= " WHERE type = 1";
	    }
        $sql .= " ORDER BY start_date DESC";
        return $this->fetchAll($sql, $listCotisation);
    }

    public function getCotisationListByFiscalYearId($iFiscalYearId, &$listCotisation)
    {
        $sql = "SELECT id, label, type, amount, start_date, end_date, fiscal_year_id";
        $sql .= " FROM cotisation ";
        $sql .= " WHERE fiscal_year_id=".$iFiscalYearId;
        $sql .= " ORDER BY type";
        return $this->fetchAll($sql, $listCotisation);
    }

    //////////////////////
    // Around membership
    //////////////////////

    public function getMembershipListByFiscalYearId($iFiscalYearId, &$listMemberships)
    {
        $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, person_id";
        $sql .= " FROM membership";
        $sql .= " WHERE fiscal_year_id=".$iFiscalYearId;
        $sql .= " ORDER BY lastname, firstname";
        return $this->fetchAll($sql, $listMemberships);
    }

    public function getMembershipListByCotisationId($iCotisationId, &$listMemberships)
    {
        $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, phonenumber2, image_rights, membership_date, membership_type, person_id";
        $sql .= " , amount AS total_amount, payment_method";
        $sql .= " FROM membership, membership_cotisation";
        $sql .= " WHERE membership.id=membership_id";
        $sql .= " AND cotisation_id=".$iCotisationId;
        $sql .= " ORDER BY lastname, firstname";
        return $this->fetchAll($sql, $listMemberships);
    }

    public function getMembershipCountPerFiscalYear(&$listMembershipCountPerFiscalYear)
    {
        $sql = 'SELECT fiscal_year_id, count(DISTINCT id) AS membership_count';
        $sql .= ' FROM membership';
        $sql .= ' GROUP BY fiscal_year_id';
        return $this->fetchAll($sql, $listMembershipCountPerFiscalYear);
    }

    /////////////////////////////////
    // Around membership cotisations
    /////////////////////////////////

    public function getMembershipCotisationListByFiscalYearId($iFiscalYearId, &$listMembershipCotisations)
    {
        $sql = "SELECT membership_id, cotisation_id, date, membership_cotisation.amount AS amount, payment_method";
        $sql .= " FROM membership_cotisation, cotisation";
        $sql .= " WHERE membership_cotisation.cotisation_id=cotisation.id";
        $sql .= " AND fiscal_year_id=".$iFiscalYearId;
        $sql .= " ORDER BY membership_id, cotisation_id";
        return $this->fetchAll($sql, $listMembershipCotisations);
    }

    public function getMembershipCotisationAmountCountPerFiscalYear(&$listAmountPerFiscalYear)
    {
        $sql = "SELECT fiscal_year_id, sum(membership_cotisation.amount) AS total_amount";
        $sql .= " FROM membership, membership_cotisation";
        $sql .= " WHERE membership.id=membership_id";
        $sql .= " GROUP BY fiscal_year_id";
        return $this->fetchAll($sql, $listAmountPerFiscalYear);
    }

    public function getMembershipSummaryPerCotisation(&$listMembershipSummaryPerCotisation)
    {
        $sql = "SELECT cotisation_id, COUNT(membership_id) AS membership_count, SUM(amount) AS totalamount";
        $sql .= " FROM membership_cotisation";
	    $sql .= " GROUP BY cotisation_id";
        return $this->fetchAll($sql, $listMembershipSummaryPerCotisation);
    }

    //////////////////////
    // Around accounting
    //////////////////////

    public function getAccountingAccountList(&$listAccount)
    {
        $sql = "SELECT id, label, type ";
        $sql .= " FROM accounting_account";
        $sql .= " ORDER BY type DESC, id";
        return $this->fetchAll($sql, $listAccount);
    }

    public function getAccountingAccountResumeList(&$listAccountResume)
    {
        $sql =  "SELECT account_id, SUM(amount_debit) as outcomings, SUM(amount_credit) as incomings";
        $sql .= " FROM accounting_operation, accounting_operation_category";
        $sql .= " WHERE accounting_operation.category = accounting_operation_category.id";
        //$sql .= " AND is_internal_move = false";
        $sql .= " GROUP BY account_id";
        return $this->fetchAll($sql, $listAccountResume);
    }

    public function getAccountingOperationCategoryList(&$listCategory)
    {
        $sql = "SELECT id, label, account_number, account_name, account_type ";
        $sql .= " FROM accounting_operation_category";
        $sql .= " ORDER BY account_type, label";
        return $this->fetchAll($sql, $listCategory);
    }

    public function getAccountingOperationList(&$listOperation, $filters = null, $order = null)
    {
        $sql =  'SELECT id, label, category, date_value, op_method, op_method_number, amount_debit, amount_credit, fiscalyear_id, account_id, date_effective, label_bank';
        $sql .= ' FROM accounting_operation';

        // filters
        if($filters != null){
            $szWhere = "";
            if(array_key_exists("id", $filters)){
                $szWhere = $this->addWhere($szWhere, "id=".$filters['id']);
            }
            if(array_key_exists("category_id", $filters)){
                $szWhere = $this->addWhere($szWhere, "category=".$filters['category_id']);
            }
            if(array_key_exists("fiscal_year_id", $filters)){
                $szWhere = $this->addWhere($szWhere, "fiscalyear_id=".$filters['fiscal_year_id']);
            }
            if(array_key_exists("account_id", $filters)){
                $szWhere = $this->addWhere($szWhere, "account_id=".$filters['account_id']);
                $szWhere = $this->addWhere($szWhere, "date_effective IS NOT NULL");
            }
            $sql .= $szWhere;
        }
        
        if($order != null){
            if($order == "sort_by_account_date"){
                $sql .= ' ORDER BY date_effective IS NULL DESC, date_effective, id';
            }else{
                $sql .= ' ORDER BY fiscalyear_id DESC, date_value DESC, id DESC';
            }
        }else{
            $sql .= ' ORDER BY fiscalyear_id DESC, date_value DESC, id DESC';
        }

        //$sql .= ' ORDER BY id DESC';
        return $this->fetchAll($sql, $listOperation);
    }

    public function getAccountingOperationById($id, &$operation)
    {
        $listOperation = null;
        $filters = array("id" => $id);
        $bRes = $this->getAccountingOperationList($listOperation, $filters);
        if($bRes){
            $operation = $listOperation[0];
        }
        return $bRes;
    }

    public function saveAccountingOperation(&$operation)
    {
        $res = true;

        $id = $operation['id'];

        // Check data
        if($operation['label'] == ""){
            $this->_errors[] = "Label cannot be empty";
            $res = false;
        }

        // Check data
        if($operation['amount_credit'] == "" && $operation['amount_debit'] == ""){
            $this->_errors[] = "Amount credit and debit cannot be empty";
            $res = false;
        }

        // Prepare the query
        $stmt = null;
        if($res){
            if($id==0){
            	$sql = 'INSERT INTO accounting_operation (label, category, date_value, op_method, op_method_number, amount_debit, amount_credit, fiscalyear_id, account_id, date_effective, label_bank, checked) VALUES (:label, :category, :date_value, :op_method, :op_method_number, :amount_debit, :amount_credit, :fiscalyear_id, :account_id, :date_effective, :label_bank, :checked)';
            }else{
            	$sql = 'UPDATE accounting_operation SET label=:label, category=:category, date_value=:date_value, op_method=:op_method, op_method_number=:op_method_number, amount_debit=:amount_debit, amount_credit=:amount_credit, fiscalyear_id=:fiscalyear_id, account_id=:account_id, date_effective=:date_effective, label_bank=:label_bank, checked=:checked WHERE id=:id';
            }

            $stmt = $this->_conn->prepare($sql);
            if(!$stmt){
		        $res = false;
	            $this->_errors[] = TSHelper::pdoErrorText($this->_conn->errorInfo());
            }

        }

        $valueNull = NULL;

        // Execute the query
        if($res){
            if($id!=0){
	            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }else{
	            //$stmt->bindParam(':creation_date', $id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':label', $operation['label'], PDO::PARAM_STR, 50);
            $stmt->bindParam(':category', $operation['category'], PDO::PARAM_INT);
            if($operation['date_value'] != ""){
                $stmt->bindParam(':date_value', $operation['date_value'], PDO::PARAM_STR, 10);
            }else{
                $stmt->bindParam(':date_value', $valueNull, PDO::PARAM_NULL);
            }
            $stmt->bindParam(':op_method', $operation['op_method'], PDO::PARAM_INT);
            $stmt->bindParam(':op_method_number', $operation['op_method_number'], PDO::PARAM_STR, 50);
            if($operation['amount_debit'] != ""){
                $stmt->bindParam(':amount_debit', $operation['amount_debit'], PDO::PARAM_STR);
            }else{
                $stmt->bindParam(':amount_debit', $valueNull, PDO::PARAM_NULL);
            }
            if($operation['amount_credit'] != ""){
                $stmt->bindParam(':amount_credit', $operation['amount_credit'], PDO::PARAM_STR);
            }else{
                $stmt->bindParam(':amount_credit', $valueNull, PDO::PARAM_NULL);
            }
            $stmt->bindParam(':fiscalyear_id', $operation['fiscalyear_id'], PDO::PARAM_INT);
            $stmt->bindParam(':account_id', $operation['account_id'], PDO::PARAM_INT);
            if($operation['date_effective'] != ""){
                $stmt->bindParam(':date_effective', $operation['date_effective'], PDO::PARAM_STR, 10);
            }else{
                $stmt->bindParam(':date_effective', $valueNull, PDO::PARAM_NULL);
            }
            $stmt->bindParam(':label_bank', $operation['label_bank'], PDO::PARAM_STR, 100);
            $stmt->bindParam(':checked', $operation['checked'], PDO::PARAM_BOOL);

            $res = $stmt->execute();
            if($res){
                if($id==0){
	                $operation["id"] = $this->_conn->lastInsertId();
                }
            }else{
                $this->_errors[] = TSHelper::pdoErrorText($stmt->errorInfo());
            }
        }

        return $res;
    }


    public function getAccountingOperationCountPerFiscalYear(&$listOperationCountPerFiscalYear)
    {
        $sql = 'SELECT fiscalyear_id, count(DISTINCT id) AS operation_count';
        $sql .= ' FROM accounting_operation';
        $sql .= ' GROUP BY fiscalyear_id';
        return $this->fetchAll($sql, $listOperationCountPerFiscalYear);
    }


    public function getAccountingOperationCountPerAccount(&$listOperationCountPerAccount)
    {
        $sql = 'SELECT account_id, count(DISTINCT id) AS operation_count';
        $sql .= ' FROM accounting_operation';
        $sql .= ' GROUP BY account_id';
        return $this->fetchAll($sql, $listOperationCountPerAccount);
    }

}

?>
