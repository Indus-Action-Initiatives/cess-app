<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('users');

        $this->hasOne('Drawing', [
            'foreignKey' => 'off_empcode',
            'bindingKey' => 'off_empcode', // Ensure both tables use this key for association
        ]);

        $this->hasOne('Dopt', [
            'foreignKey' => 'off_empcode',
            'bindingKey' => 'off_empcode', // Ensure both tables use this key for association
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        // Validate 'off_empcode' uniqueness (case-insensitive)
        $validator
            ->notEmptyString('off_empcode', 'Employee code is required')
            ->add('off_empcode', 'unique', [
                'rule' => function ($value, $context) {
                    $value = strtolower($value);
                    $query = $this->find()
                        ->where(['LOWER(off_empcode)' => $value]);

                    // Exclude current record on update
                    if (!empty($context['data']['id'])) {
                        $query->where(['id !=' => $context['data']['id']]);
                    }

                    return $query->count() === 0;
                },
                'provider' => 'table',
                'message' => 'Employee code must be unique',
            ]);

        // Validate 'username' uniqueness (case-insensitive)
        $validator
            ->notEmptyString('username', 'Username is required')
            ->add('username', 'unique', [
                'rule' => function ($value, $context) {
                    $value = strtolower($value);
                    $query = $this->find()
                        ->where(['LOWER(username)' => $value]);

                    // Exclude current record on update
                    if (!empty($context['data']['id'])) {
                        $query->where(['id !=' => $context['data']['id']]);
                    }

                    return $query->count() === 0;
                },
                'provider' => 'table',
                'message' => 'Username must be unique',
            ]);

        return $validator;
    }

}


