<?php

namespace Paytic\Smartfintech\Api\Authentication;

use Paytic\Smartfintech\Api\AbstractBase\AbstractRequest;
use Paytic\Smartfintech\Api\AbstractBase\Behaviours\RequestHasClientId;
use Paytic\Smartfintech\HttpClient\RequestManager;

class AuthenticationRequest extends AbstractRequest
{
    use RequestHasClientId;

    public const PATH = '/authenticate/rest/api/token';

    public const METHOD = 'POST';

    public string $certificate;

    public string $private_key;

    public ?bool $isLink2Pay = null;

    public ?bool $flexibleURL = null;

    public ?bool $isHeadless = null;

    /**
     * @param string $client_id
     */
    public function __construct(string $certificate, string $client_id)
    {
        $this->certificate = $certificate;
        $this->client_id = $client_id;
    }

    protected static function createParseConstructorParams(array &$params = []): array
    {
        $constructorParams = parent::createParseConstructorParams($params);

        $client_id = $params['client_id'] ?? null;
        if (empty($client_id)) {
            throw new \Exception("Missing client_id");
        }
        unset($params['client_id']);
        $constructorParams['client_id'] = $client_id;

        $certificate = $params['certificate'] ?? null;
        if (empty($certificate)) {
            throw new \Exception("Missing certificate");
        }
        unset($params['certificate']);
        $constructorParams['certificate'] = $certificate;

        return $constructorParams;
    }

    public function send(RequestManager $manager)
    {
        $manager->getHttpClientBuilder()->withOptions([
            'local_cert' => $this->generateSslFile($this->certificate),
            'local_pk' => $this->generateSslFile($this->private_key),
        ]);
        return $manager->post(
            self::PATH,
            [
                'client_id' => $this->client_id,
                'isLink2Pay' => $this->isLink2Pay,
                'flexibleURL' => $this->flexibleURL,
                'isHeadless' => $this->isHeadless
            ]);
    }

    protected function generateResponseClass(): string
    {
        return AuthenticationResponse::class;
    }

    protected function generateSslFile($file)
    {
        if (file_exists($file)) {
            return $file;
        }

        $tmpfile = tempnam(sys_get_temp_dir(),'');
        file_put_contents($tmpfile, $file);
//        register_shutdown_function('unlink',$tmpfile);
        return $tmpfile;
    }
}

