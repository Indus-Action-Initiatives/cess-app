<?php

// namespace App\Model\Table;

// use Cake\ORM\Table;

// class RegistersTable extends Table
// {
//     public function initialize(array $config): void
//     {
//         parent::initialize($config);
//         $this->setTable('registers'); // matches database
//         $this->setPrimaryKey('registration_id');
//     }
// }


// src/Model/Table/RegistersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\EventInterface;
use ArrayObject;

class RegistersTable extends Table
{
    public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
    {
        if ($entity->isDirty('password')) {
            $entity->password = (new DefaultPasswordHasher())->hash($entity->password);
        }
    }
}
