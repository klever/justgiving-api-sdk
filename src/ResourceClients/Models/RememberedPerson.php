<?php

namespace Klever\JustGivingApiSdk\ResourceClients\Models;

class RememberedPerson extends Model
{
    /**
     * ID of existing person that has been created on the system previously; 0 if new person.
     *
     * @var int
     */
    public $id = 0;

    /**
     * Supported values: HusbandWife, Partner, BrotherSister, Parent, SonDaughter, Grandparent, Grandchild,
     * OtherFamilyMember, Friend, WorkColleague, Other
     *
     * @var string
     */
    public $relationship;
    public $rememberedPerson;
    public $firstName;
    public $lastName;

    /**
     * Supported values: Male, Female.
     *
     * @var string
     */
    public $gender;
    public $town;
    public $dateOfBirth;
    public $dateOfDeath;
}
