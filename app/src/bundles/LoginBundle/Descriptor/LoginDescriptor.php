<?php

namespace app\bundles\LoginBundle\Descriptor;

/**
 * Class LoginDescriptor
 * @package app\bundles\LoginBundle\Descriptor
 */
class LoginDescriptor
{
    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var bool
     */
    protected bool $suceeded;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isSuceeded(): bool
    {
        return $this->suceeded;
    }

    /**
     * @param bool $suceeded
     */
    public function setSuceeded(bool $suceeded): void
    {
        $this->suceeded = $suceeded;
    }


}
