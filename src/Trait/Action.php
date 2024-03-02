<?php

namespace App\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Config\Action as ActionEnum;

trait Action
{
    #[ORM\Column(
        name: "action",
        type: Types::STRING,
        length: 255,
        nullable: false,
        enumType: ActionEnum::class,
        options: ["default" => ActionEnum::HOLD]
    )]
    private ActionEnum $action = ActionEnum::HOLD;

    public function setAction(ActionEnum $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): ActionEnum
    {
        return $this->action;
    }
}