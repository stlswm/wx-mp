<?php

/*
|--------------------------------------------------------------------------
| Constants for Cloud
|--------------------------------------------------------------------------
|
| The constants used by SDK are defined here.
| This file will be automatically loaded.
|
*/

/**
 * Global Client Name
 */
defined('WECHAT_CLOUD_GLOBAL_CLIENT') || define('WECHAT_CLOUD_GLOBAL_CLIENT', 'global');
/**
 * Global Region Name
 */
defined('WECHAT_CLOUD_GLOBAL_REGION') || define('WECHAT_CLOUD_GLOBAL_REGION', 'global');
/**
 * Request Timeout
 */
defined('WECHAT_CLOUD_TIMEOUT') || define('WECHAT_CLOUD_TIMEOUT', 15);
/**
 * Request Connect Timeout
 */
defined('WECHAT_CLOUD_CONNECT_TIMEOUT') || define('WECHAT_CLOUD_CONNECT_TIMEOUT', 3);
/**
 * For STS
 */
defined('WECHAT_CLOUD_STS_EXPIRE') || define('WECHAT_CLOUD_STS_EXPIRE', 3600);
/**
 * For STS cache
 */
defined('WECHAT_CLOUD_EXPIRATION_INTERVAL') || define('WECHAT_CLOUD_EXPIRATION_INTERVAL', 5);