<?php

require_once(OP_MOD . 'email/ProviderInterface.php');
require_once(OP_MOD . 'email/provider/OfficeAutopilot.php');
require_once(OP_LIB . 'vendor/officeautopilot/OAPAPI.php');

/**
 * Ontraport email integration provider
 * @author Luka Peharda <luka.peharda@gmail.com>
 */
class OptimizePress_Modules_Email_Provider_Ontraport extends OptimizePress_Modules_Email_Provider_OfficeAutopilot implements OptimizePress_Modules_Email_ProviderInterface
{
    const OPTION_NAME_APP_ID    = 'ontraport_app_id';
    const OPTION_NAME_API_KEY   = 'ontraport_api_key';

    protected $host             = 'https://api.ontraport.com/';

    public function __construct()
    {
        $this->appId    = op_get_option(self::OPTION_NAME_APP_ID);
        $this->apiKey   = op_get_option(self::OPTION_NAME_API_KEY);
    }

    public function getClient()
    {
        if (null === $this->client) {
            $this->client = new OP_OAPAPI(array('AppID' =>  $this->appId, 'Key' => $this->apiKey, 'Host' => $this->host));
        }

        return $this->client;
    }
}