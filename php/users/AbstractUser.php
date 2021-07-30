<?

namespace R794021\Users;

abstract class AbstractUser
{
    protected $id;
    protected $fullname;

    public function getId()
    {
        return $this->id;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    abstract function isContractor();

    abstract function isCustomer();
}
