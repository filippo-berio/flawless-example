<?php

namespace Flawless\Container;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ClassFinder
{
    private const SEARCH_FOR = [
        T_CLASS,
        T_INTERFACE,
        T_TRAIT,
    ];

    private array $exclude = [];

    public function __construct(
        private array $folders = []
    ) {
    }

    public function exclude(string $class)
    {
        $this->exclude[] = $class;
    }

    public function findClasses(): array
    {
        $classes = [];
        foreach ($this->folders as $folder) {
            $classes = [
                ...$classes,
                ...$this->findClassesIn($folder)
            ];
        }
        return $classes;
    }

    private function findClassesIn(string $folder): array
    {
        $classes = [];
        $directory = new RecursiveDirectoryIterator($folder);
        $iterator = new RecursiveIteratorIterator($directory);
        foreach ($iterator as $info) {
            if ($info->getExtension() === 'php') {
                $class = $this->getClassName($info->getPathname());
                if (!in_array($class, $this->exclude)) {
                    $classes[] = $this->getClassName($info->getPathname());
                }
            }
        }

        return $classes;
    }

    private function getClassName(string $file): string
    {
        $fp = fopen($file, 'r');
        $buffer = '';
        $namespace = '';
        $i = 0;

        while (true) {
            if (feof($fp)) {
                throw new Exception("Could not find any tokens in $file");
            }

            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (!str_contains($buffer, '{')) {
                continue;
            }

            for (; $i < count($tokens); $i++) {
                $token = $tokens[$i][0];
                if ($token === T_NAMESPACE) {
                    $namespace = $tokens[$i + 2][1];
                }
                if (in_array($token, self::SEARCH_FOR)) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $className = $tokens[$i + 2][1];
                            return "$namespace\\$className";
                        }
                    }
                }
            }
        }
    }
}
