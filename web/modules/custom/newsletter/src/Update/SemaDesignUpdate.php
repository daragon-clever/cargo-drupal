<?php

namespace Drupal\newsletter\Update;

class SemaDesignUpdate extends BaseUpdate
{
    public function setUpdate($version)
    {
        parent::setUpdate($version);

        switch ($version) {
            case '8105':
                $this->setUpdate8105();
                break;
        }
    }
}