<?php

        namespace App\Models;

        use Illuminate\Contracts\Auth\Authenticatable;
        use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

        class ArrayUser implements Authenticatable
        {
            use AuthenticatableTrait;

            protected $attributes;

            public function __construct(array $attributes)
            {
                $this->attributes = $attributes;
            }

            public function getAuthIdentifier()
            {
                return $this->attributes['id'];
            }

            public function getAuthIdentifierName()
            {
                return 'id';
            }

            public function getAuthPassword()
            {
                return $this->attributes['password'];
            }

            public function getAuthPasswordName()
            {
                return 'password';
            }

            public function getRememberToken()
            {
                return null;
            }

            public function setRememberToken($value)
            {
                // no-op
            }

            public function getRememberTokenName()
            {
                return '';
            }

            public function __get($key)
            {
                return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
            }

            public function toArray()
            {
                return $this->attributes;
            }
        }
