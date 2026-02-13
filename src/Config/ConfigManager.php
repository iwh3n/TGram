<?php

namespace Iwh3n\Tgram\Config;

use Symfony\Component\Yaml\Yaml;

class ConfigManager
{
    private string $cacheDir;

    public function __construct()
    {
        $this->cacheDir = $this->getUserHomeDir() . '/.tgram/cache';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function createConfigFile(): string
    {
        $yaml = Yaml::dump(require config_path('yaml.php'), 4, 2);
        $path = getcwd() . '/tgram.yaml';

        file_put_contents($path, $yaml);

        $projectHash = md5(getcwd());
        $cacheFile = $this->cacheDir . '/' . $projectHash . '.path';
        file_put_contents($cacheFile, $path);

        return $path;
    }

    public function getConfigFile(): mixed
    {
        $path = $this->getConfigPath();
        if ($path && file_exists($path)) {
            return Yaml::parseFile($path);
        }
        return null;
    }

    public function isConfigFile(): bool
    {
        $path = $this->getConfigPath();
        return $path && file_exists($path);
    }

    public function getConfigPath(): string
    {
        $dir = getcwd();
        while ($dir !== dirname($dir)) {
            $cacheFile = $this->cacheDir . '/' . md5($dir) . '.path';

            if (file_exists($cacheFile)) {
                $path = file_get_contents($cacheFile);
                if (file_exists($path)) {
                    return $path;
                }
            }

            $candidate = $dir . '/tgram.yaml';
            if (file_exists($candidate)) {
                file_put_contents($cacheFile, $candidate);
                return $candidate;
            }

            $dir = dirname($dir);
        }

        return '';
    }

    public function getUserHomeDir(): string
    {
        if ($home = getenv('HOME')) {
            return $home;
        }

        if ($userProfile = getenv('USERPROFILE')) {
            return $userProfile;
        }

        $homeDrive = getenv('HOMEDRIVE');
        $homePath = getenv('HOMEPATH');
        if ($homeDrive && $homePath) {
            return $homeDrive . $homePath;
        }

        throw new \RuntimeException("Cannot determine user home directory.");
    }
}
