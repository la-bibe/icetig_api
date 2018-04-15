<?php

namespace Icetig\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Group
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Group
     */
    protected $parent;

    /**
     * @var User[]|ArrayCollection
     */
    protected $users;

    /**
     * @var GroupPermission[]|ArrayCollection
     */
    protected $permissions;

    /**
     * @var GroupPermission[]|ArrayCollection
     */
    protected $subjectedPermissions;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Group|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Group|null $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection|User[] $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return ArrayCollection|GroupPermission[]
     */
    public function getPermissions()
    {
        $permissions = $this->permissions;

        if (null !== $this->parent) {
            $parentPermission = $this->parent->getPermissions();
            if ($parentPermission)
                $permissions = array_merge($permissions, $parentPermission);
        }

        return $permissions;
    }

    /**
     * @return array
     */
    public function getPermissionArray()
    {
        $permissions = $this->permissions ? $this->permissions->toArray() : [];
        if (null !== $this->parent) {
            $parentPermission = $this->parent->getPermissions();
            if ($parentPermission)
                $permissions = array_merge($permissions, $parentPermission->toArray());
        }

        $permissionsArray = [];

        foreach ($permissions as $permission) {
            if ($permission instanceof GroupPermission) {
                $name = $permission->getPermission();
                $id = $permission->getId();
                if (!isset($permissionsArray[$id])) {
                    $subject = $permission->getSubjectGroup();
                    $permissionsArray[$id] = [
                        'name' => $name,
                        'subject' => $subject ? $subject->getId() : null,
                        'acl' => [],
                    ];
                }
                foreach (GroupPermission::ACL_TYPES as $acl => $value) {
                    if (!isset($permissionsArray[$id]['acl'][$acl])) {
                        $permissionsArray[$id]['acl'][$acl] = false;
                    }
                    $permissionsArray[$id]['acl'][$acl] |= $permission->getSpecificAcl($acl);
                }
            }
        }

        return $permissionsArray;
    }

    /**
     * @param ArrayCollection|GroupPermission[] $permissions
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];

        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['parent'] = null !== $this->parent ? $this->parent->getData() : null;

        return $data;
    }

    /**
     * @return ArrayCollection|GroupPermission[]
     */
    public function getSubjectedPermissions()
    {
        return $this->subjectedPermissions;
    }

    /**
     * @param ArrayCollection|GroupPermission[] $subjectedPermissions
     */
    public function setSubjectedPermissions($subjectedPermissions)
    {
        $this->subjectedPermissions = $subjectedPermissions;
    }
}