<?
namespace R794021\Actions;
use \R794021\Users;


abstract class AbstractAction
{
    private $internalCodename;
    private $name;


    abstract public function __construct();

    public function getName()
    {
        return $this->name;
    }

    public function getInternalCodename()
    {
        return $this->internalCodename;
    }

    abstract public function isValid(Customer $customer, Contractor $contractor, AbstractUser $id);
}

