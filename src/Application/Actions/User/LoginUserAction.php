<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Settings\SettingsInterface;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();
        $email = $parsedBody['email'];
        $password = $parsedBody['password'];

        $data = $this->userRepository->getEmail($email);

        if (sha1($password) != $data[0]['password']) {
            return $this->respondWithData($data)->withHeader('Content-Type', 'application/json')->withStatus(401);
        } else {
            $settings = $this->container->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwt');
            $token = JWT::encode(['id' => $data[0]['id'], 'email' => $data[0]['email']], $jwtSettings['secret'], "HS256");

            return $this->respondWithData(['token' => $token])->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
}
