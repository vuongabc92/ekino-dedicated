<?php
/**
 * File for class Pr_sso_model_webserviceStructAuthenticateResult
 * @package Pr_sso_model_webservice
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
/**
 * This class stands for Pr_sso_model_webserviceStructAuthenticateResult originally named AuthenticateResult
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.pernod-ricard.com/sfdc/authentication.asmx?WSDL}
 * @package Pr_sso_model_webservice
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
class Pr_sso_model_webserviceStructAuthenticateResult extends Pr_sso_model_webserviceWsdlClass
{
    /**
     * The Authenticated
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var boolean
     */
    public $Authenticated;
    /**
     * Constructor method for AuthenticateResult
     * @see parent::__construct()
     * @param boolean $_authenticated
     * @return Pr_sso_model_webserviceStructAuthenticateResult
     */
    public function __construct($_authenticated)
    {
        parent::__construct(array('Authenticated'=>$_authenticated),false);
    }
    /**
     * Get Authenticated value
     * @return boolean
     */
    public function getAuthenticated()
    {
        return $this->Authenticated;
    }
    /**
     * Set Authenticated value
     * @param boolean $_authenticated the Authenticated
     * @return boolean
     */
    public function setAuthenticated($_authenticated)
    {
        return ($this->Authenticated = $_authenticated);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Pr_sso_model_webserviceWsdlClass::__set_state()
     * @uses Pr_sso_model_webserviceWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Pr_sso_model_webserviceStructAuthenticateResult
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
