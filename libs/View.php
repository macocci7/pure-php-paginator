<?php

namespace Libs;

class View
{
    public static string $templateRoot;

    public function __construct(
        public string $templatePath,
        public array $params = [],
    ) {
    }

    /**
     * @param	string					$_KEY_
     * @param	array<string, mixed>	$_PARAMS_
     */
    public static function make(string $key, array $params): static
    {
        $path = static::getTemplatePath($key);
        if (! is_readable($path)) {
            throw new \Exception("Template [{$path}] is not readable.");
        }

        return new static($path, $params);
    }

    protected static function setTemplateRoot(): void
    {
        static::$templateRoot = realpath(__DIR__ . "/../app/Views");
    }

    protected static function getTemplatePath(string $key): string
    {
        if (! isset(static::$templateRoot)) {
            static::setTemplateRoot();
        }
        $keys = explode('.', $key);
        $file = array_pop($keys);
        return sprintf(
            "%s/%s/%s.view.php",
            static::$templateRoot,
            implode('/', $keys),
            $file
        );
    }

    public function render(): void
    {
        if (! is_readable($this->templatePath)) {
            throw new \Exception("Template [{$this->templatePath}] is not readable.");
        }

        // テンプレート変数との衝突を極力避ける為の変数名： $_K_ / $_V_
        foreach ($this->params as $_K_ => $_V_) {
            ${$_K_} = $_V_;
        }

        require $this->templatePath;
    }
}
