<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => (ENV === 'dev'),
            ]
        );
        $this->twig->addGlobal('user', $this->getUser());
        $this->twig->addExtension(new DebugExtension());
    }

    public function getUser(): ?array
    {
        if (!empty($_SESSION['user'])) {
            $userManager = new UserManager();
            return $userManager->selectOneById($_SESSION['user']);
        }
        return null;
    }
}
