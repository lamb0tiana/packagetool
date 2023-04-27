<?php


namespace App\Controller\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/connect")]
class FacebookController extends AbstractController
{

    #[Route("/facebook", name: "connect_facebook_start")]
    public function connectAction(ClientRegistry $clientRegistry)
    {

        return $clientRegistry
            ->getClient('facebook')
            ->redirect([
                'public_profile', 'email'
            ]);


    }

    #[Route("/facebook/check", name:"connect_facebook_check")]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {

        /** @var FacebookClient $client */
        $client = $clientRegistry->getClient('facebook');

        try {
            /** @var FacebookUser $user */
            $user = $client->fetchUser();
            $content = $user->toArray();
            // ...
        } catch (IdentityProviderException $e) {
            $content = ['error' => $e->getMessage()];
        }
        return$this->json($content);
    }
}