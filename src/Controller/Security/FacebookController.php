<?php


namespace App\Controller\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{

    #[Route("/connect/facebook", name: "connect_facebook_start")]
    public function connectAction(ClientRegistry $clientRegistry)
    {

        return $clientRegistry
            ->getClient('facebook')
            ->redirect([
                'public_profile', 'email'
            ]);


    }

    #[Route("/connect/facebook/check", name:"connect_facebook_check")]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {

        /** @var FacebookClient $client */
        $client = $clientRegistry->getClient('facebook');

        try {
            /** @var FacebookUser $user */
            $user = $client->fetchUser();

            var_dump($user); die;
            // ...
        } catch (IdentityProviderException $e) {

            var_dump($e->getMessage()); die;
        }
    }
}