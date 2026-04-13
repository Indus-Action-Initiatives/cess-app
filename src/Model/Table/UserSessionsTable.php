<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserSessionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Define table name
        $this->setTable('user_sessions');  // Make sure the table name is correct

        // Set primary key if needed
        $this->setPrimaryKey('id');

        // Add associations (if any)
    }

    // Define validation rules if needed
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id')
            ->requirePresence('session_token', 'create')
            ->notEmptyString('session_token')
            ->requirePresence('user_agent', 'create')
            ->notEmptyString('user_agent');

        return $validator;
    }
}

