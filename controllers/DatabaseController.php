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
     // Around cotisations
     //////////////////////

     public function getCotisationsByFiscalYearId($iFiscalYearId, &$listCotisations)
     {
       $sql = "SELECT id, label, type";
       $sql .= " FROM cotisation ";
       $sql .= " WHERE fiscal_year_id=".$iFiscalYearId;
       $sql .= " ORDER BY type";
       return $this->fetchAll($sql, $listCotisations);
     }

     //////////////////////
     // Around membership
     //////////////////////

     function getMembershipListByFiscalYearId($iFiscalYearId, &$listMemberships)
     {
       $sql = "SELECT id, firstname, lastname, birthdate, address, zipcode, city, email, phonenumber, image_rights, membership_date, membership_type, person_id";
       $sql .= " FROM membership";
       $sql .= " WHERE fiscal_year_id=".$iFiscalYearId;
       $sql .= " ORDER BY membership_date DESC";
       return $this->fetchAll($sql, $listMemberships);
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

  }

?>
