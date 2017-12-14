<?php

namespace Icetig\Bundle\UserBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var DateTime
     */
    protected $dateOfBirth;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var Group[]|ArrayCollection
     */
    protected $groups;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

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
    public function setEmail(string $email)
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
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return DateTime
     */
    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param DateTime $dateOfBirth
     */
    public function setDateOfBirth(DateTime $dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return ArrayCollection|Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param ArrayCollection|Group[] $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        $permissionsArray = [];

        if (null !== $this->groups) {
            foreach ($this->groups as $group) {
                foreach ($group->getPermissionArray() as $name => $permission) {
                    if (!isset($permissionsArray[$name])) {
                        $permissionsArray[$name] = [];
                    }
                    foreach (GroupPermission::ACL_TYPES as $acl => $value) {
                        if (!isset($permissionsArray[$name][$acl])) {
                            $permissionsArray[$name][$acl] = false;
                        }
                        $permissionsArray[$name][$acl] |= $permission[$acl];
                    }
                }
            }
        }

        return $permissionsArray;
    }

    public function getData()
    {
        $data = [];
        $data['id'] = $this->id;
        $data['email'] = $this->email;
        $data['firstName'] = $this->firstName;
        $data['lastName'] = $this->lastName;
        $data['dateOfBirth'] = $this->dateOfBirth;
        $data['phone'] = $this->dateOfBirth;
        $data['groups'] = [];

        if (null !== $this->groups) {
            foreach ($this->groups as $group) {
                $data['groups'][] = $group->getData();
            }
        }

        $data['permissions'] = $this->getPermissions();

        return $data;
    }
}
