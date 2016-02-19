<?php
/**
 * File for class Pr_sso_model_webserviceStructAuthenticate
 * @package Pr_sso_model_webservice
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
/**
 * This class stands for Pr_sso_model_webserviceStructAuthenticate originally named Authenticate
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.pernod-ricard.com/sfdc/authentication.asmx?WSDL}
 * @package Pr_sso_model_webservice
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20140325-01
 * @date 2015-01-30
 */
class Pr_sso_model_webserviceStructAuthenticate extends Pr_sso_model_webserviceWsdlClass
{
    /**
     * The username
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 0
     * @var string
     */
    public $username;
    /**
     * The password
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 0
     * @var string
     */
    public $password;
    /**
     * The sourceIp
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 0
     * @var string
     */
    public $sourceIp;
    /**
     * The any
     * @var DOMDocument
     */
    public $any;
    /**
     * Constructor method for Authenticate
     * @see parent::__construct()
     * @param string $_username
     * @param string $_password
     * @param string $_sourceIp
     * @param DOMDocument $_any
     * @return Pr_sso_model_webserviceStructAuthenticate
     */
    public function __construct($_username = NULL,$_password = NULL,$_sourceIp = NULL,$_any = NULL)
    {
        parent::__construct(array('username'=>$_username,'password'=>$_password,'sourceIp'=>$_sourceIp,'any'=>$_any),false);
    }
    /**
     * Get username value
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Set username value
     * @param string $_username the username
     * @return string
     */
    public function setUsername($_username)
    {
        return ($this->username = $_username);
    }
    /**
     * Get password value
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password value
     * @param string $_password the password
     * @return string
     */
    public function setPassword($_password)
    {
        return ($this->password = $_password);
    }
    /**
     * Get sourceIp value
     * @return string|null
     */
    public function getSourceIp()
    {
        return $this->sourceIp;
    }
    /**
     * Set sourceIp value
     * @param string $_sourceIp the sourceIp
     * @return string
     */
    public function setSourceIp($_sourceIp)
    {
        return ($this->sourceIp = $_sourceIp);
    }
    /**
     * Get any value
     * @uses DOMDocument::loadXML()
     * @uses DOMDocument::hasChildNodes()
     * @uses DOMDocument::saveXML()
     * @uses DOMNode::item()
     * @uses Pr_sso_model_webserviceStructAuthenticate::setAny()
     * @param bool true or false whether to return XML value as string or as DOMDocument
     * @return DOMDocument|null
     */
    public function getAny($_asString = true)
    {
        if(!empty($this->any) && !($this->any instanceof DOMDocument))
        {
            $dom = new DOMDocument('1.0','UTF-8');
            $dom->formatOutput = true;
            if($dom->loadXML($this->any))
            {
                $this->setAny($dom);
            }
            unset($dom);
        }
        return ($_asString && ($this->any instanceof DOMDocument) && $this->any->hasChildNodes())?$this->any->saveXML($this->any->childNodes->item(0)):$this->any;
    }
    /**
     * Set any value
     * @param DOMDocument $_any the any
     * @return DOMDocument
     */
    public function setAny($_any)
    {
        return ($this->any = $_any);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Pr_sso_model_webserviceWsdlClass::__set_state()
     * @uses Pr_sso_model_webserviceWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Pr_sso_model_webserviceStructAuthenticate
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
