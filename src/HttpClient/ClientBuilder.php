<?php

namespace Paytic\Smartfintech\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\CachePlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\HttpClient\Psr18Client;

class ClientBuilder
{
    /**
     * The object that sends HTTP messages.
     *
     * @var ClientInterface
     */
    protected ClientInterface $httpClient;

    /**
     * The HTTP request factory.
     *
     * @var RequestFactoryInterface
     */
    protected RequestFactoryInterface $requestFactory;

    /**
     * The HTTP stream factory.
     *
     * @var StreamFactoryInterface
     */
    protected StreamFactoryInterface $streamFactory;

    /**
     * The URI factory.
     *
     * @var UriFactoryInterface
     */
    protected UriFactoryInterface $uriFactory;

    /**
     * The currently registered plugins.
     *
     * @var Plugin[]
     */
    protected array $plugins = [];

    /**
     * The cache plugin to use.
     *
     * This plugin is specially treated because it has to be the very last plugin.
     *
     * @var CachePlugin|null
     */
    protected ?CachePlugin $cachePlugin;

    /**
     * A HTTP client with all our plugins.
     *
     * @var HttpMethodsClientInterface|null
     */
    protected ?HttpMethodsClientInterface $pluginClient;

    /**
     * Create a new http client builder instance.
     *
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     * @param UriFactoryInterface|null $uriFactory
     *
     * @return void
     */
    public function __construct(
        ClientInterface         $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface  $streamFactory = null,
        UriFactoryInterface     $uriFactory = null
    )
    {
        $this->httpClient = new Psr18Client($httpClient);
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUriFactory();
    }


    /**
     * @return HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        if (null === $this->pluginClient) {
            $plugins = $this->plugins;
//            if (null !== $this->cachePlugin) {
//                $plugins[] = $this->cachePlugin;
//            }

            $this->pluginClient = new HttpMethodsClient(
                (new PluginClientFactory())->createClient($this->httpClient, $plugins),
                $this->requestFactory,
                $this->streamFactory
            );
        }

        return $this->pluginClient;
    }

    /**
     * Get the request factory.
     *
     * @return RequestFactoryInterface
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    /**
     * Get the stream factory.
     *
     * @return StreamFactoryInterface
     */
    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    /**
     * Get the URI factory.
     *
     * @return UriFactoryInterface
     */
    public function getUriFactory(): UriFactoryInterface
    {
        return $this->uriFactory;
    }

    /**
     * Add a new plugin to the end of the plugin chain.
     *
     * @param Plugin $plugin
     *
     * @return void
     */
    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
        $this->pluginClient = null;
    }

    /**
     * Remove a plugin by its fully qualified class name (FQCN).
     *
     * @param string $fqcn
     *
     * @return void
     */
    public function removePlugin(string $fqcn): void
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);
                $this->pluginClient = null;
            }
        }
    }

    public function withOptions(array $options): void
    {
        $this->httpClient = $this->httpClient->withOptions($options);
        $this->pluginClient = null;
    }
}