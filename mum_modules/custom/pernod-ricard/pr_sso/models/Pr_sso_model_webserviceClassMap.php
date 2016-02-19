<?php
/**
 * File for the class which returns the class map definition
 * @package Pr_sso_model_webservice
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
/**
 * Class which returns the class map definition by the static method Pr_sso_model_webserviceClassMap::classMap()
 * @package Pr_sso_model_webservice
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
class Pr_sso_model_webserviceClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
        return array (
  'Authenticate' => 'Pr_sso_model_webserviceStructAuthenticate',
  'AuthenticateResult' => 'Pr_sso_model_webserviceStructAuthenticateResult',
);
    }
}
