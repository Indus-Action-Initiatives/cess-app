<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class RegistrationPayment extends Entity
{
    protected array $_accessible = [
        'labour_cess_project_id' => true,
        'payment_mode' => true,
        'payment_method' => true,
        'document_reference_no' => true,
        'bank_name_branch' => true,
        'date_of_payment' => true,
        'amount_paid' => true,
        'attachment_description' => true,
        'attachment_file_path' => true,
        'created_at' => true,
        'updated_at' => true,
    ];
}
