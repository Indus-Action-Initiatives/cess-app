<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\I18n\FrozenTime;

class CheckObjectionsCommand extends Command {

    public function execute(Arguments $args, ConsoleIo $io){
        $this->loadModel('Objections');
        $this->loadModel('ObjectionComments');
        $this->loadModel('ShowCauseLogs');

        $tenDaysAgo = FrozenTime::now()->subDays(10);

        $objections = $this->Objections->find()
            ->where([
                'status' => 0,                // open
                'notice_sent' => false,
                'created <=' => $tenDaysAgo
            ])
            ->contain(['Projects'])
            ->all();

        foreach ($objections as $objection) {

            // Check if project owner replied after objection creation
            $replyExists = $this->ObjectionComments->find()
                ->where([
                    'objection_id' => $objection->id,
                    'user_id' => $objection->project->user_id,
                    'created >=' => $objection->created
                ])
                ->count();

            if ($replyExists === 0) {

                // 1️⃣ Send notice (email / notification)
                $this->sendShowCauseNotice($objection);

                // 2️⃣ Save log
                $log = $this->ShowCauseLogs->newEmptyEntity();
                $log->objection_id = $objection->id;
                $log->user_id = $objection->project->user_id;
                $log->notice_date = FrozenTime::now();
                $log->message = 'Show cause notice issued due to no reply within 10 days.';

                $this->ShowCauseLogs->save($log);

                // 3️⃣ Update objection
                $objection->notice_sent = true;
                $this->Objections->save($objection);

                $io->out("Notice sent for Objection ID: {$objection->id}");
            }
        }

        $io->success('Daily objection check completed.');
    }

    private function sendShowCauseNotice($objection)
    {
        // You can later replace this with Email / SMS / Notification
        // Example placeholder
        return true;
    }
}
