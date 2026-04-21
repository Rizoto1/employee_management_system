<?php

namespace Framework\Auth;

use App\Models\User;
use Framework\Core\App;
use Framework\Core\IIdentity;
use http\Exception\RuntimeException;

/**
 * Class DummyAuthenticator
 * A basic implementation of user authentication using hardcoded credentials.
 *
 * @package App\Auth
 */
class DummyAuthenticator extends SessionAuthenticator
{
    // Hardcoded username for authentication
    public const LOGIN = "admin";
    // Hash of the password "admin"
    public const PASSWORD_HASH = '$2y$10$GRA8D27bvZZw8b85CAwRee9NH5nj4CQA6PDFMc90pN9Wi4VAWq3yq';
    // Display name for the logged-in user
    public const USERNAME = "Admin";
    // Application instance

    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $users = User::getAll('username = ?', [$username], null, 1);
        $user = $users[0] ?? null;

        if ($user instanceof User && password_verify($password, $user->getPassword())) {
            return $user;
        }

        if ($username === self::LOGIN && password_verify($password, self::PASSWORD_HASH)) {
            return new User(self::USERNAME);
        }

        return null;
    }
}
