<?php
declare(strict_types=1);

namespace Foo\Core;

use \Dotenv as Dotenv;

class Request
{
    private string $url;
    private string $method;
    private array $postData;
    private array $env;

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->postData = $_POST ? filter_input_array(INPUT_POST, $_POST) : [];

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../..');
        $dotenv->load();

        $this->env = $_ENV;
    }

    /**
     * Get called url
     *
     * @return string
     */
    public function getUrl(): string
    {
	   return $this->url;
    }

    /**
     * Get HTTP call method
     *
     * @return string
     */
    public function getMethod(): string
    {
	   return $this->method;
    }

    /**
     * Retrieve env parameter by name
     *
     * @param null|string $envName
     *
     * @return array|string
     */
    public function getEnv(string $envName = null)
    {
        if (is_null($envName) || !getenv($envName)) {
            return $this->env;   
        }

        return getenv($envName);
    }

    public function getPostData(): array
    {
        return $this->postData;
    }

    /**
     * Return request as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return ["request" => $this];
    }
}
