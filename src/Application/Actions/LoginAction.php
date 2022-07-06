<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Settings\SettingsInterface;
use Firebase\JWT\JWT;
use PDO;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginAction extends Action
{
    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
        parent::__construct($logger, $container);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(Request $request): Response
    {
        $parsedBody = $request->getParsedBody();
        $email = $parsedBody['email'];
        $password = $parsedBody['password'];

        $db = $this->container->get(PDO::class);
        $query = $db->prepare("SELECT * FROM users WHERE email = '$email'");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

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
