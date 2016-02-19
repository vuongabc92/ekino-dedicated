<?php

/**
 * Class SocialFeed
 *
 * @property int sfid
 * @property string identifier
 * @property string type
 * @property string name
 * @property string alias
 * @property bool status
 * @property int uid
 * @property int since_id
 * @property int created
 * @property int changed
 */
abstract class SocialFeed
{
    const TYPE_FACEBOOK = 'facebook';
    const TYPE_TWITTER = 'twitter';
    const TYPE_INSTAGRAM = 'instagram';

    const CHANNEL_OFFICIAL = 'official';
    const CHANNEL_HASHTAG = 'hashtag';

    protected $_sfid;
    protected $_identifier;
    protected $_type;
    protected $_channel;
    protected $_name;
    protected $_alias;
    protected $_status;

    protected $_uid;
    protected $_sinceId;
    protected $_created;
    protected $_changed;

    function __construct($type, $identifier, $name, $alias = null)
    {
        $this->setType($type);

        $this->setIdentifier($identifier);
        $this->setName($name);
        $this->setAlias($alias);


        $this->_status = false;
        $this->_sinceId = 0;
        $this->created = 0;
        $this->_changed = 0;
    }

    public function getFeedId()
    {
        return $this->_sfid;
    }

    private function setType($type)
    {
        $type = strtolower($type);
        if (!in_array($type, static::getSupportedTypes())) {
            throw new InvalidArgumentException(
                sprintf('Feed type is not supported: %s. Expected one of following: "%s".',
                    $type, implode('", "', static::getSupportedTypes())));
        }

        $this->_type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
        return $this;
    }

    public function getIdentifier()
    {
        return $this->_identifier;
    }

    public function setChannel($channel)
    {
        $this->_channel = $channel;
        return $this;
    }

    public function getChannel($guess = false)
    {
        if (!empty($this->_channel)) {
            return $this->_channel;
        }

        if (!$guess) {
            return null;
        }

        if ($this->isHashtag()) {
            return self::CHANNEL_HASHTAG;
        }

        return self::CHANNEL_OFFICIAL;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setAlias($alias)
    {
        $this->_alias = $alias;
        return $this;
    }

    public function getAlias()
    {
        if (empty($this->_alias)) {
            return $this->getName();
        }

        return $this->_alias;
    }

    public function setStatus($status)
    {
        $this->_status = (bool) $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function needsValidation()
    {
        if ($this->isNew()) {
            // New feeds are not validated yet.
            return true;
        }

        if (false === $this->getStatus()) {
            // Something went wrong last time.
            // We need to re-validate this feed.
            return true;
        }

        // Already validated.
        return false;
    }

    public function markValid($valid = true)
    {
        $this->setStatus($valid);
    }

    public function isValid()
    {
        return $this->getStatus();
    }

    public function setData($data)
    {
        foreach ($data as $prop => $value) {
            $this->$prop = $value;
        }

        return $this;
    }

    public function getData($toObject = false)
    {
        $data = array(
            'sfid' => $this->_sfid,
            'type' => $this->_type,
            'channel' => $this->getChannel(true),

            'identifier' => $this->_identifier,
            'name' => $this->_name,

            'uid' => $this->_uid,
            'created' => $this->_created,
            'changed' => $this->_changed,
            'status' => $this->_status,
            'since_id' => $this->_sinceId,
        );

        return $toObject
            ? (object) $data
            : $data;
    }

    public function isHashtag()
    {
        $identifier = $this->getIdentifier();

        $isHashtag = 0 === strpos($identifier, '#');
        return $isHashtag;
    }

    public function supportsHashtags()
    {
        return true;
    }

    public function isNew()
    {
        $exists = $this->_created > 0;

        return false === $exists;
    }

    public function hasSince()
    {
        $since = $this->getSince();

        return $since > 0;
    }

    public function getSince()
    {
        if (isset($this->_sinceId)) {
            return $this->_sinceId;
        }

        return $this->_changed;
    }

    static public function getSupportedTypes()
    {
        $supported_types = array(
            self::TYPE_FACEBOOK,
            self::TYPE_TWITTER,
            self::TYPE_INSTAGRAM,
        );

        return array_combine($supported_types, $supported_types);
    }

    /**
     * @param $data
     * @return SocialFeed
     */
    final static public function createFromData($data)
    {
        $data = (array) $data;

        if (isset($data['type'])) {
            $identifier = $data['identifier'];
            $name = $data['name'];

            $feed = null;

            switch (strtolower($data['type'])) {
                case self::TYPE_FACEBOOK:
                    $feed = new SocialFeedFacebook($identifier, $name);
                    $feed->setData($data);
                    return $feed;

                case self::TYPE_TWITTER:
                    $feed = new SocialFeedTwitter($identifier, $name);
                    $feed->setData($data);
                    return $feed;

                case self::TYPE_INSTAGRAM:
                    $feed = new SocialFeedInstagram($identifier, $name);
                    $feed->setData($data);
                    return $feed;
            }
        }

        return null;
    }

    public function __get($prop)
    {
        $prop = strtolower($prop);

        switch ($prop) {
            case 'sfid':
            case 'type':
            case 'identifier':
            case 'channel':
            case 'uid':
            case 'created':
            case 'changed':
                $field = '_' . $prop;
                return $this->$field;

            case 'sinceid':
            case 'since_id':
                return $this->_sinceId;

            case 'name':
            case 'alias':
                return $this->getAlias();

            case 'status':
                return $this->getStatus();
        }

        return null;
        //throw new RuntimeException('Tried to get unexisting property: ' . $prop);
    }

    public function __set($prop, $value)
    {
        switch ($prop) {
            case 'sfid':
            case 'uid':
            case 'created':
            case 'changed':
                $field = '_' . $prop;
                $this->$field = $value;
                break;

            case 'since_id':
            case 'sinceid':
                $this->_sinceId = $value;
                break;

            case 'type':
                $this->setType($value);
                break;

            case 'identifier':
                $this->setIdentifier($value);
                break;

            case 'channel':
                $this->setChannel($value);
                break;

            case 'name':
                $this->setName($value);
                break;

            case 'alias':
                $this->setAlias($value);
                break;

            case 'status':
                $this->setStatus($value);
                break;
        }
    }
}

class SocialFeedFacebook extends SocialFeed
{
    private $_accessToken;

    function __construct($identifier, $name, $alias = null)
    {
        parent::__construct(self::TYPE_FACEBOOK, $identifier, $name, $alias);
    }

    public function supportsHashtags()
    {
        return false;
    }

    public function setAccessToken($accessToken = null)
    {
        $this->_accessToken = $accessToken;
        return $this;
    }

    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function hasAccessToken()
    {
        return null !== $this->getAccessToken();
    }
}

class SocialFeedTwitter extends SocialFeed
{
    function __construct($identifier, $name, $alias = null)
    {
        parent::__construct(self::TYPE_TWITTER, $identifier, $name, $alias);
    }

    public function getSince()
    {
        return $this->_sinceId;
    }
}

class SocialFeedInstagram extends SocialFeed
{
    function __construct($identifier, $name, $alias = null)
    {
        parent::__construct(self::TYPE_INSTAGRAM, $identifier, $name, $alias);
    }
}
