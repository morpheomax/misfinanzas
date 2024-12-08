<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Desactivar usuarios con suscripciones vencidas';

    public function handle()
    {
        $users = User::where('is_premium', true)
            ->where('subscription_end_date', '<', now())
            ->get();

        foreach ($users as $user) {
            $user->update(['is_premium' => false]);
        }

        $this->info('Usuarios con suscripciones vencidas desactivados.');
    }
}
