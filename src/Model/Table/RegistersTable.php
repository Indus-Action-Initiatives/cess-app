<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Event\EventInterface;
use ArrayObject;
use Authentication\PasswordHasher\DefaultPasswordHasher; // ✅ Plugin Namespace

use Cake\Validation\Validator;

class RegistersTable extends Table
{
    public function initialize(array $config): void{
        $this->setTable('registers');
        $this->belongsTo('States', ['foreignKey' => 'state_id', 'joinType' => 'LEFT']);
        $this->belongsTo('Districts', ['foreignKey' => 'district_id', 'joinType' => 'LEFT']);
    }

    // public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
    // {
    //     if ($entity->isDirty('password')) {
    //         $entity->password = (new DefaultPasswordHasher())->hash($entity->password);
    //     }
    // }




    // public function validationDefault(Validator $validator): Validator
    // {
    //     $validator
    //         ->scalar('phone')
    //         ->maxLength('phone', 13, 'Phone number cannot be longer than 13 digits.')
    //         ->requirePresence('phone', 'create')
    //         ->notEmptyString('phone', 'Phone number is required.')
    //         ->add('phone', 'numeric', [
    //             'rule' => ['custom', '/^[0-9]+$/'],
    //             'message' => 'Phone number must contain digits only (0–9).'
    //         ]);

    //     return $validator;
    // }
}
