<?php

declare(strict_types=1);

namespace App\Common\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FileManifestExtension extends AbstractExtension
{
    private array|null $manifest = null;

    public function __construct(private string $manifestPath) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset_hash', $this->getAssetPath(...)),
        ];
    }

    public function getAssetPath(string $path): string
    {
        if (is_null($this->manifest)) {
            $this->manifest = file_exists($this->manifestPath)
                ? json_decode(file_get_contents($this->manifestPath), true)
                : [];
        }

        return $this->manifest[$path] ?? $path;
    }
}
