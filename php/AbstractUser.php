<?

namespace R794021;

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
}
