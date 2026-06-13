<?php

namespace Tgram\Config;

use Symfony\Component\Config\Definition\Processor;
use Tgram\Config\YamlDefaultConfig;
use Symfony\Component\Yaml\Yaml;

use function is_array, sprintf;

class YamlConfigurationManager
{
    private string $cacheDir;

    public function __construct(
        private YamlDefaultConfig $yamlConfig
    ) {
        $this->cacheDir = $this->getUserHomeDir() . '/.tgram/cache';

        if (!is_dir($this->cacheDir)) {
            if (!@mkdir($this->cacheDir, 0755, true)) {
                throw new \RuntimeException(
                    sprintf(
                        'Failed to create cache directory: %s',
                        $this->cacheDir
                    )
                );
            }
        }

        if (!is_writable($this->cacheDir)) {
            throw new \RuntimeException(
                sprintf(
                    'Cache directory is not writable: %s',
                    $this->cacheDir
                )
            );
        }
    }

    public function createConfigFile(): string
    {
        $path = getcwd() . '/tgram.yaml';
        $yaml = $this->yamlConfig->getYaml();
        file_put_contents($path, $yaml);

        $projectHash = md5(getcwd());
        $cacheFile = "{$this->cacheDir}/{$projectHash}.path";
        file_put_contents($cacheFile, $path);

        return $path;
    }

    public function getConfigFile(): array
    {
        try {

            $path = $this->getConfigPath();

            if (!$path || !file_exists($path)) {
                throw new \RuntimeException('Configuration file not found.');
            }

            $rawConfig = Yaml::parseFile($path);

            if (!is_array($rawConfig)) {
                throw new \RuntimeException('Configuration file is empty or invalid.');
            }

            $processor = new Processor();
            $configuration = new YamlConfiguration();

            return $processor->processConfiguration(
                $configuration,
                $rawConfig
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to load configuration: ' . $e->getMessage(), 0, $e);
        }
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
            $cacheFile = "{$this->cacheDir}/" . md5($dir) . '.path';

            if (file_exists($cacheFile)) {
                $path = file_get_contents($cacheFile);
                if (file_exists($path)) {
                    return $path;
                }
            }

            $candidate = "{$dir}/tgram.yaml";
            if (file_exists($candidate)) {
                file_put_contents($cacheFile, $candidate);
                return $candidate;
            }

            $dir = dirname($dir);
        }

        return '';
    }

    private function getUserHomeDir(): string
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
            return "{$homeDrive}{$homePath}";
        }

        throw new \RuntimeException("Cannot determine user home directory.");
    }
}