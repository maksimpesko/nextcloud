<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitTwoFactorBackupCodes
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OCA\\TwoFactorBackupCodes\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OCA\\TwoFactorBackupCodes\\' => 
        array (
            0 => __DIR__ . '/..' . '/../lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'OCA\\TwoFactorBackupCodes\\Activity\\Provider' => __DIR__ . '/..' . '/../lib/Activity/Provider.php',
        'OCA\\TwoFactorBackupCodes\\AppInfo\\Application' => __DIR__ . '/..' . '/../lib/AppInfo/Application.php',
        'OCA\\TwoFactorBackupCodes\\BackgroundJob\\CheckBackupCodes' => __DIR__ . '/..' . '/../lib/BackgroundJob/CheckBackupCodes.php',
        'OCA\\TwoFactorBackupCodes\\BackgroundJob\\RememberBackupCodesJob' => __DIR__ . '/..' . '/../lib/BackgroundJob/RememberBackupCodesJob.php',
        'OCA\\TwoFactorBackupCodes\\Controller\\SettingsController' => __DIR__ . '/..' . '/../lib/Controller/SettingsController.php',
        'OCA\\TwoFactorBackupCodes\\Db\\BackupCode' => __DIR__ . '/..' . '/../lib/Db/BackupCode.php',
        'OCA\\TwoFactorBackupCodes\\Db\\BackupCodeMapper' => __DIR__ . '/..' . '/../lib/Db/BackupCodeMapper.php',
        'OCA\\TwoFactorBackupCodes\\Event\\CodesGenerated' => __DIR__ . '/..' . '/../lib/Event/CodesGenerated.php',
        'OCA\\TwoFactorBackupCodes\\Listener\\ActivityPublisher' => __DIR__ . '/..' . '/../lib/Listener/ActivityPublisher.php',
        'OCA\\TwoFactorBackupCodes\\Listener\\ClearNotifications' => __DIR__ . '/..' . '/../lib/Listener/ClearNotifications.php',
        'OCA\\TwoFactorBackupCodes\\Listener\\ProviderDisabled' => __DIR__ . '/..' . '/../lib/Listener/ProviderDisabled.php',
        'OCA\\TwoFactorBackupCodes\\Listener\\ProviderEnabled' => __DIR__ . '/..' . '/../lib/Listener/ProviderEnabled.php',
        'OCA\\TwoFactorBackupCodes\\Listener\\RegistryUpdater' => __DIR__ . '/..' . '/../lib/Listener/RegistryUpdater.php',
        'OCA\\TwoFactorBackupCodes\\Migration\\CheckBackupCodes' => __DIR__ . '/..' . '/../lib/Migration/CheckBackupCodes.php',
        'OCA\\TwoFactorBackupCodes\\Migration\\Version1002Date20170607104347' => __DIR__ . '/..' . '/../lib/Migration/Version1002Date20170607104347.php',
        'OCA\\TwoFactorBackupCodes\\Migration\\Version1002Date20170607113030' => __DIR__ . '/..' . '/../lib/Migration/Version1002Date20170607113030.php',
        'OCA\\TwoFactorBackupCodes\\Migration\\Version1002Date20170919123342' => __DIR__ . '/..' . '/../lib/Migration/Version1002Date20170919123342.php',
        'OCA\\TwoFactorBackupCodes\\Migration\\Version1002Date20170926101419' => __DIR__ . '/..' . '/../lib/Migration/Version1002Date20170926101419.php',
        'OCA\\TwoFactorBackupCodes\\Migration\\Version1002Date20180821043638' => __DIR__ . '/..' . '/../lib/Migration/Version1002Date20180821043638.php',
        'OCA\\TwoFactorBackupCodes\\Notifications\\Notifier' => __DIR__ . '/..' . '/../lib/Notifications/Notifier.php',
        'OCA\\TwoFactorBackupCodes\\Provider\\BackupCodesProvider' => __DIR__ . '/..' . '/../lib/Provider/BackupCodesProvider.php',
        'OCA\\TwoFactorBackupCodes\\Service\\BackupCodeStorage' => __DIR__ . '/..' . '/../lib/Service/BackupCodeStorage.php',
        'OCA\\TwoFactorBackupCodes\\Settings\\Personal' => __DIR__ . '/..' . '/../lib/Settings/Personal.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitTwoFactorBackupCodes::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitTwoFactorBackupCodes::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitTwoFactorBackupCodes::$classMap;

        }, null, ClassLoader::class);
    }
}