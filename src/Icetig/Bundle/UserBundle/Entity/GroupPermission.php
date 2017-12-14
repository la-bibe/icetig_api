<?php

namespace Icetig\Bundle\UserBundle\Entity;

class GroupPermission
{
    const ACL_TYPES = [
        'create' => 1,
        'read' => 2,
        'update' => 4,
        'delete' => 8,
    ];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $permission;

    /**
     * @var int
     */
    protected $acl;

    /**
     * @var Group
     */
    protected $group;

    public function __construct($permission, Group $group, int $acl = null)
    {
        $this->permission = $permission;
        $this->group = $group;
        $this->acl = $acl ?? 0;
    }

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
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return int
     */
    public function getAcl(): int
    {
        return $this->acl;
    }

    /**
     * @param int $acl
     */
    public function setAcl(int $acl)
    {
        $this->acl = $acl;
    }

    /**
     * @param string $acl
     *
     * @return bool
     */
    public function getSpecificAcl($acl): bool
    {
        return ($this->acl & self::ACL_TYPES[$acl]) != 0;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;
    }
}