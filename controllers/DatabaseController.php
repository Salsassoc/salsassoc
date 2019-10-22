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

    //////////////////////
    // Around fiscal year
    //////////////////////     

    public function getFiscalYearList(&$listFiscalYear)
    {
        $sql = "SELECT id, title, start_date, end_date, is_current";
        $sql .= " FROM fiscal_year";
        $sql .= " ORDER BY start_date DESC";
        return $this->fetchAll($sql, $listFiscalYear);
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
        $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, image_rights, membership_date, membership_type, person_id";
        $sql .= " FROM membership";
        $sql .= " WHERE fiscal_year_id=".$iFiscalYearId;
        $sql .= " ORDER BY membership_date DESC";
        return $this->fetchAll($sql, $listMemberships);
    }

    public function getMembershipListByCotisationId($iCotisationId, &$listMemberships)
    {
        $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, image_rights, membership_date, membership_type, person_id";
        $sql .= " FROM membership, membership_cotisation";
        $sql .= " WHERE membership.id=membership_id";
        $sql .= " AND cotisation_id=".$iCotisationId;
        $sql .= " ORDER BY membership_date DESC";
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

}

?>
