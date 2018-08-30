<?php

namespace Icetig\Bundle\UserBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Icetig\Bundle\ApiBundle\Entity\AbstractApiEntity;
use Icetig\Bundle\ApiBundle\Exception\IncorrectPropertyException;
use Icetig\Bundle\PedagoBundle\Entity\Sanction;
use Symfony\Component\Validator\Constraints as Assert;

class User extends AbstractApiEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     *
     * TODO Assert good Epitech address / valid
     */
    protected $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
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
     * @var Sanction[]|ArrayCollection
     */
    protected $sanctions;

    /**
     * @var Sanction[]|ArrayCollection
     */
    protected $issued_sanctions;

    /**
     * User constructor.
     *
     * @param array $parameters
     *
     * @throws IncorrectPropertyException
     */
    public function __construct(array $parameters = [])
    {
        $this->update($parameters);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): ?int
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
     * @throws \Exception
     */
    public function setPassword(string $password)
    {
        $this->setSalt();
        $this->password = hash('sha512', "{$password}{$this->getSalt()}");
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @throws \Exception
     */
    public function setSalt()
    {
        $this->salt = hash('sha512', bin2hex(random_bytes(random_int(50, 200))));
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(?string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return DateTime
     */
    public function getDateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param DateTime $dateOfBirth
     */
    public function setDateOfBirth(?DateTime $dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(?string $phone)
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
        $fullPermissionsArray = [];

        if (null !== $this->groups) {
            foreach ($this->groups as $group)
                $fullPermissionsArray = array_merge($fullPermissionsArray, $group->getPermissionArray());
        }

        $permissionsArray = [];

        foreach ($fullPermissionsArray as $permission) {
            $name = $permission['name'];
            $subject = $permission['subject'] ?? '*';
            if (!isset($permissionsArray[$name]))
                $permissionsArray[$name] = [];
            if (!isset($permissionsArray[$name][$subject]))
                $permissionsArray[$name][$subject] = [];
            foreach (GroupPermission::ACL_TYPES as $acl => $value) {
                if (!isset($permissionsArray[$name][$subject][$acl])) {
                    $permissionsArray[$name][$subject][$acl] = false;
                }
                $permissionsArray[$name][$subject][$acl] |= $permission['acl'][$acl];
            }
        }

        return $permissionsArray;
    }

    /**
     * // TODO handle throw everywhere
     * @return array
     * @throws IncorrectPropertyException
     */
    public function getData()
    {
        return $this->getPropertiesData([
            'id',
            'email',
            'firstName',
            'lastName',
        ]);
    }

    public function getGroupsData()
    {
        $data = [];

        if (null !== $this->groups) {
            foreach ($this->groups as $group) {
                $data[] = $group->getData();
            }
        }

        return $data;
    }

    public function getSanctionsData()
    {
        $data = [];

        foreach ($this->getSanctions() as $sanction)
            $data[] = $sanction->getShortData();

        return $data;
    }

    /**
     * @return ArrayCollection|Sanction[]
     */
    public function getSanctions()
    {
        return $this->sanctions;
    }

    /**
     * @param ArrayCollection|Sanction[] $sanctions
     */
    public function setSanctions($sanctions)
    {
        $this->sanctions = $sanctions;
    }

    /**
     * @return ArrayCollection|Sanction[]
     */
    public function getIssuedSanctions()
    {
        return $this->issued_sanctions;
    }

    /**
     * @param ArrayCollection|Sanction[] $issued_sanctions
     */
    public function setIssuedSanctions($issued_sanctions)
    {
        $this->issued_sanctions = $issued_sanctions;
    }
}
