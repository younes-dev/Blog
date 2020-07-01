<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields  = {"email"},
 *     message = "the email already used try a valid email."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 4,max = 20, allowEmptyString = false,
     *      minMessage = "Your login must be at least {{ limit }} characters long",
     *      maxMessage = "Your login cannot be longer than {{ limit }} characters",
     * )     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 4,minMessage = "Le mot de passe doit faire {{ limit }} characters minimum")
     * @Assert\EqualTo(propertyPath="confirm_password",message="le mot de passe n'est pas addequant")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="le mot de passe n'est pas addequant")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        // not needed when using the "auto" algorithm in security.yaml

    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
