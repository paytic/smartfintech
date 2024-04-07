<?php

namespace Paytic\Smartfintech\Client;

use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\AddPathPlugin;
use Http\Discovery\Psr18ClientDiscovery;
use Paytic\Smartfintech\HttpClient\ClientBuilder;
use Paytic\Smartfintech\HttpClient\HasClientBuilder;
use Psr\Http\Client\ClientInterface;

trait HasHttpClientTrait
{
    use HasClientBuilder;

    /**
     * Instantiate a new Gitlab client.
     *
     * @param ClientBuilder|null $httpClientBuilder
     *
     * @return void
     */
    public function __construct(ClientBuilder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new ClientBuilder();
//        $this->responseHistory = new History();

//        $builder->addPlugin(new ExceptionThrower());
//        $builder->addPlugin(new HistoryPlugin($this->responseHistory));
//        $builder->addPlugin(new HeaderDefaultsPlugin([
//            'User-Agent' => self::USER_AGENT,
//        ]));
//        $builder->addPlugin(new RedirectPlugin());

        $this->initBaseUrl();
    }


    /**
     * @param string $url
     *
     * @return void
     */
    public function setBaseUrl(string $url): void
    {
        $builder = $this->getHttpClientBuilder();
        $uri = $builder->getUriFactory()->createUri($url);

        $builder->removePlugin(AddHostPlugin::class);
        $builder->addPlugin(new AddHostPlugin($uri));
    }

    protected function initBaseUrl()
    {
        $this->setBaseUrl($this->generateBaseUri());
        return $this;
    }

    protected function generateBaseUri(): string
    {
        return $this->isSandbox() ? self::SANDBOX_URL : self::LIVE_URL;
    }
}