<?php
namespace App\Service;

class TodoProviderFactory
{
    public function createProvider(string $providerName): TodoProviderInterface
    {
        switch ($providerName) {
            case 'api1':
                return new Provider1('https://run.mocky.io/v3/15dd27ed-3321-4e04-8420-14761a5f6a52');
            case 'api2':
                return new Provider2('https://run.mocky.io/v3/2ca10628-9093-4194-a583-da95e0f4f9ce');
            default:
                throw new \InvalidArgumentException("invalid provider: $providerName");
        }
    }
}
