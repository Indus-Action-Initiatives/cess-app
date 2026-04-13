<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OfficesTable extends Table
{
	public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('offices');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('ParentOffices', [
            'className' => 'Offices',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildOffices', [
            'className' => 'Offices',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('States', ['foreignKey' => 'state_id']);
        $this->belongsTo('Districts', ['foreignKey' => 'district_id']);
        $this->belongsToMany('WorkingDistricts', [
            'className' => 'Districts',
            'joinTable' => 'office_districts',
            'foreignKey' => 'office_id',
            'targetForeignKey' => 'district_id',
            'propertyName' => 'working_districts'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('name', 'Office name is required')
            ->notEmptyString('address', 'Office address is required')
            ->notEmptyString('phone', 'Office phone(mobile) is required')
            ->notEmptyString('officer_name', 'Officer name is required')
            ->notEmptyString('state_id', 'State is required')
            ->notEmptyString('district_id', 'District is required')
            ->notEmptyString('pincode', 'Pincode is required')
            ->email('email', false, 'Please enter a valid email address')
            ->notEmptyString('email', 'Email is required')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'This email address is already used by another office.'
            ]);

        return $validator;
    }
}
