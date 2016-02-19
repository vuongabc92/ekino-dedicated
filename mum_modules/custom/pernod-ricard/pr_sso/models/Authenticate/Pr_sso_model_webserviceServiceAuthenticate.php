<?php
/**
 * File for class Pr_sso_model_webserviceServiceAuthenticate
 * @package Pr_sso_model_webservice
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
/**
 * This class stands for Pr_sso_model_webserviceServiceAuthenticate originally named Authenticate
 * @package Pr_sso_model_webservice
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
class Pr_sso_model_webserviceServiceAuthenticate extends Pr_sso_model_webserviceWsdlClass
{
    /**
     * Method to call the operation originally named Authenticate
     * @uses Pr_sso_model_webserviceWsdlClass::getSoapClient()
     * @uses Pr_sso_model_webserviceWsdlClass::setResult()
     * @uses Pr_sso_model_webserviceWsdlClass::saveLastError()
     * @param Pr_sso_model_webserviceStructAuthenticate $_pr_sso_model_webserviceStructAuthenticate
     * @return Pr_sso_model_webserviceStructAuthenticateResult
     */
    public function Authenticate(Pr_sso_model_webserviceStructAuthenticate $_pr_sso_model_webserviceStructAuthenticate)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->Authenticate($_pr_sso_model_webserviceStructAuthenticate));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see Pr_sso_model_webserviceWsdlClass::getResult()
     * @return Pr_sso_model_webserviceStructAuthenticateResult
     */
    public function getResult()
    {
        return parent::getResult();
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
