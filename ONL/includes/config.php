<?php
$BASE_URL = getenv('BASE_URL') ?: 'https://oproepjesnederland.nl';
$api_url = getenv('BASE_API_URL') ?: 'https://16hl07csd16.nl';

return [
    'BASE_URL' => $BASE_URL,
    'BASE_API_URL' => $api_url,
    // When APP_DEBUG is set to 'true', development error reporting is enabled
    'DEBUG' => getenv('APP_DEBUG') === 'true',
    'BANNER_ENDPOINT' => $api_url . '/profile/banner2/120',
    'PROFILE_ENDPOINT' => $api_url . '/profile/get0/2/',
    'PROVINCE_ENDPOINT' => $api_url . '/profile/province/nl',
];
?>
