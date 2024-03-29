<?php

/*
 * This file is part of the SymfonyCasts ResetPasswordBundle package.
 * Copyright (c) SymfonyCasts <https://symfonycasts.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymfonyCasts\Bundle\ResetPassword\Exception;

/**
 * @author Ryan Weaver <ryan@symfonycasts.com>
 */
final class InvalidResetPasswordTokenException extends \Exception implements ResetPasswordExceptionInterface
{
    public function getReason(): string
    {
        return 'Le lien de réinitialisation du mot de passe est invalide. Veuillez essayer de réinitialiser votre mot de passe à nouveau.';
    }
}
