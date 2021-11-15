<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

interface HomepageFactoryInterface
{
    public function create(?UserInterface $user): Response;
}