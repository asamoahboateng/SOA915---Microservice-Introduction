<?php

    namespace App\Providers;

    use App\Models\ArrayUser;
    use Illuminate\Contracts\Auth\UserProvider;
    use Illuminate\Contracts\Auth\Authenticatable;
    use Illuminate\Support\Facades\Hash;

    class ArrayUserProvider implements UserProvider
    {
        private $users = [
            [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'name' => 'Administrator'
            ]
        ];

        public function retrieveById($identifier)
        {
            $user = collect($this->users)->first(function ($user) use ($identifier) {
                return $user['id'] == $identifier;
            });

            return $user ? new ArrayUser($user) : null;
        }

        public function retrieveByToken($identifier, $token)
        {
            return null;
        }

        public function updateRememberToken(Authenticatable $user, $token)
        {
            // Not implemented
        }

        public function retrieveByCredentials(array $credentials)
        {
            if (!isset($credentials['username'])) {
                return null;
            }

            $user = collect($this->users)->first(function ($user) use ($credentials) {
                return $user['username'] === $credentials['username'];
            });

            return $user ? new ArrayUser($user) : null;
        }

        public function validateCredentials(Authenticatable $user, array $credentials)
        {
            return isset($credentials['password']) &&
                   Hash::check($credentials['password'], $user->getAuthPassword());
        }

    public function rehashPasswordIfRequired(Authenticatable $user, $credentials, $force = false)
    {
        // Password rehashing is not required for array-based users
        return false;
    }
}
