<?php

/**
 * Laravel Requirement Checker
 *
 * This standalone script will check if your server meets the requirements for running the
 * Laravel web application framework.
 *
 * @author Gastón Heim
 * @author Emerson Carvalho
 * @author EgoistDeveloper
 * @version 1.0.0
 */

/**
 * Get user selected version input
 */
$getQueryVersion = (string) $_GET['v'] ?? null;

$laravel42Obs = 'As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via apt-get install php5-json.';
$laravel50Obs = 'PHP version should be < 7. As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via apt-get install php5-json';

/**
 * Laravel versions and requirements
 */
$versionRequirementList = [
    '4.2' => [
        'php' => '5.4',
        'mcrypt' => true,
        'pdo' => false,
        'openssl' => false,
        'mbstring' => false,
        'tokenizer' => false,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => $laravel42Obs
    ],
    '5.0' => [
        'php' => '5.4',
        'mcrypt' => true,
        'openssl' => true,
        'pdo' => false,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => $laravel50Obs
    ],
    '5.1' => [
        'php' => '5.5.9',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => ''
    ],
    '5.2' => [
        'php' => [
            '>=' => '5.5.9',
            '<' => '7.2.0',
        ],
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => '',
        'bolt' => true
    ],
    '5.3' => [
        'php' => [
            '>=' => '5.6.4',
            '<' => '7.2.0',
        ],
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => false,
        'json' => false,
        'obs' => '',
        'bolt' => true
    ],
    '5.4' => [
        'php' => '5.6.4',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => false,
        'json' => false,
        'obs' => '',
        'bolt' => true
    ],
    '5.5' => [
        'php' => '7.0.0',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => false,
        'json' => false,
        'obs' => '',
        'bolt' => true
    ],
    '5.6' => [
        'php' => '7.1.3',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
        'bolt' => true
    ],
    '5.7' => [
        'php' => '7.1.3',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
        'bolt' => true
    ],
    '5.8' => [
        'php' => '7.1.3',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
        'bolt' => true
    ],
    '6.0' => [
        'php' => '7.2.0',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'bcmath' => true,
        'obs' => '',
        'bolt' => true
    ],
    '7.0' => [
        'php' => '7.2.5',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'bcmath' => true,
        'obs' => '',
        'bolt' => true
    ],
    '8.0' => [
        'php' => '7.3.0',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'bcmath' => true,
        'obs' => '',
        'bolt' => true
    ],
    '9.0' => [
        'php' => '8.0.2',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'bcmath' => true,
        'obs' => '',
        'bolt' => true
    ],
];

/**
 * Only version list
 */
$laravelVersions = array_keys($versionRequirementList);

/**
 * Make sure the version is in the list
 */
$selectedVersion = $getQueryVersion && in_array($getQueryVersion, $laravelVersions)
    ? $getQueryVersion
    : end($laravelVersions);

$strOk = '<i class="fa fa-check"></i>';
$strFail = '<i style="color: red" class="fa fa-times"></i>';
$strUnknown = '<i class="fa fa-question"></i>';

$requirements = [
    // OpenSSL PHP Extension
    'openssl_enabled' => extension_loaded("openssl"),
    // PDO PHP Extension
    'pdo_enabled' => extension_loaded("pdo") && defined('PDO::ATTR_DRIVER_NAME'),
    // Mbstring PHP Extension
    'mbstring_enabled' => extension_loaded("mbstring"),
    // Tokenizer PHP Extension
    'tokenizer_enabled' => extension_loaded("tokenizer"),
    // XML PHP Extension
    'xml_enabled' => extension_loaded("xml"),
    // CTYPE PHP Extension
    'ctype_enabled' => extension_loaded("ctype"),
    // JSON PHP Extension
    'json_enabled' => extension_loaded("json"),
    // Mcrypt
    'mcrypt_enabled' => extension_loaded("mcrypt_encrypt"),
    // BCMath
    'bcmath_enabled' => extension_loaded("bcmath"),
    // PHP Bolt
    'bolt_enabled' => extension_loaded("bolt"),
    // mod_rewrite
    'mod_rewrite_enabled' => function_exists('apache_get_modules') ? in_array('mod_rewrite', apache_get_modules()) : false,
];

// PHP Version
if (is_array($versionRequirementList[$selectedVersion]['php'])) {
    $requirements['php_version'] = true;

    foreach ($versionRequirementList[$selectedVersion]['php'] as $operator => $version) {
        if (!version_compare(PHP_VERSION, $version, $operator)) {
            $requirements['php_version'] = false;

            break;
        }
    }
} else {
    $requirements['php_version'] = version_compare(PHP_VERSION, $versionRequirementList[$selectedVersion]['php'], ">=");
}

// select option html
$selectOptionsHtml = implode('', array_map(function ($version) use ($selectedVersion) {
    return "<option value=\"{$version}\"" . ($version == $selectedVersion ? ' selected' : '') . ">Laravel {$version}</option>";
}, array_reverse($laravelVersions)));

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Server Requirements &dash; Laravel PHP Framework</title>
    <link rel="icon" href="https://fav.farm/✨" />

    <link href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        @import url(//fonts.googleapis.com/css?family=Lato:300,400,700);

        body {
            margin: 0;
            font-size: 16px;
            font-family: 'Lato', sans-serif;
            text-align: center;
            color: #999;
        }

        select {
            padding: 10px 50px;
            font-weight: 700;
        }

        .wrapper {
            width: 300px;
            margin: 50px auto;
        }

        .logo {
            display: block;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .logo img {
            margin-right: 1.25em;
        }

        p {
            margin: 0 0 5px;
        }

        p small {
            font-size: 13px;
            display: block;
            margin-bottom: 1em;
        }

        p.obs {
            margin-top: 20px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
        }

        .icon-ok {
            color: #27ae60;
        }

        .icon-remove {
            color: #c0392b;
        }

        @media (prefers-color-scheme: dark) {
            body {
                margin: 0;
                font-size: 16px;
                font-family: 'Lato', sans-serif;
                text-align: center;
                color: #999;
                background-color: #171923;
            }

            select {
                background-color: #ababab;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <a href="https://laravel.com" title="Laravel PHP Framework" class="logo">
            <img class="mark" src="https://laravel.com/img/logomark.min.svg" alt="Laravel"><img class="type" src="https://laravel.com/img/logotype.min.svg" alt="Laravel">
        </a>

        <form action="?" method="get">
            <select name="v" onchange="this.form.submit()">
                <?php echo $selectOptionsHtml ?>
            </select>
        </form>

        <h1>Server Requirements.</h1>

        <p>
            PHP <?php
                if (is_array($versionRequirementList[$selectedVersion]['php'])) {
                    $phpVersions = [];
                    foreach ($versionRequirementList[$selectedVersion]['php'] as $operator => $version) {
                        $phpVersions[] = "{$operator} {$version}";
                    }
                    echo implode(" && ", $phpVersions);
                } else {
                    echo ">= " . $versionRequirementList[$selectedVersion]['php'];
                }

                echo " " . ($requirements['php_version'] ? $strOk : $strFail); ?>
            (<?php echo PHP_VERSION; ?>)
        </p>


        <?php if ($versionRequirementList[$selectedVersion]['openssl']) : ?>
            <p>OpenSSL PHP Extension <?php echo $requirements['openssl_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif; ?>

        <?php if ($versionRequirementList[$selectedVersion]['pdo']) : ?>
            <p>PDO PHP Extension <?php echo $requirements['pdo_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($versionRequirementList[$selectedVersion]['mbstring']) : ?>
            <p>Mbstring PHP Extension <?php echo $requirements['mbstring_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($versionRequirementList[$selectedVersion]['tokenizer']) : ?>
            <p>Tokenizer PHP Extension <?php echo $requirements['tokenizer_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($versionRequirementList[$selectedVersion]['xml']) : ?>
            <p>XML PHP Extension <?php echo $requirements['xml_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($versionRequirementList[$selectedVersion]['ctype']) : ?>
            <p>CTYPE PHP Extension <?php echo $requirements['ctype_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($versionRequirementList[$selectedVersion]['json']) : ?>
            <p>JSON PHP Extension <?php echo $requirements['json_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($versionRequirementList[$selectedVersion]['mcrypt']) : ?>
            <p>Mcrypt PHP Extension <?php echo $requirements['mcrypt_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if (isset($versionRequirementList[$selectedVersion]['bcmath']) && $versionRequirementList[$selectedVersion]['bcmath']) : ?>
            <p>BCmath PHP Extension <?php echo $requirements['bcmath_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if (!empty($versionRequirementList[$selectedVersion]['obs'])) : ?>
            <p class="obs"><?php echo $versionRequirementList[$selectedVersion]['obs'] ?></p>
        <?php endif; ?>

        <?php if (isset($versionRequirementList[$selectedVersion]['bolt']) && $versionRequirementList[$selectedVersion]['bolt']) : ?>
            <p>PHP Bolt Extension <?php echo $requirements['bolt_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <p>magic_quotes_gpc: <?php echo !ini_get('magic_quotes_gpc') ? $strOk : $strFail; ?> (value: <?php echo ini_get('magic_quotes_gpc') ?>)</p>
        <p>register_globals: <?php echo !ini_get('register_globals') ? $strOk : $strFail; ?> (value: <?php echo ini_get('register_globals') ?>)</p>
        <p>session.auto_start: <?php echo !ini_get('session.auto_start') ? $strOk : $strFail; ?> (value: <?php echo ini_get('session.auto_start') ?>)</p>
        <p>mbstring.func_overload: <?php echo !ini_get('mbstring.func_overload') ? $strOk : $strFail; ?> (value: <?php echo ini_get('mbstring.func_overload') ?>)</p>

    </div>
</body>

</html>