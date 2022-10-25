<?php

/*
 * This file is part of Okazanta.
 *
 * (c) Okazanta <hello@okazanta.com>
 *
 * Some code may be inherited from Cachet
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Handlers\Commands\Invite;

use CachetHQ\Cachet\Bus\Commands\Invite\ClaimInviteCommand;
use CachetHQ\Cachet\Bus\Events\Invite\InviteWasClaimedEvent;
use Carbon\Carbon;

class ClaimInviteCommandHandler
{
    /**
     * Handle the claim invite command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\User\ClaimInviteCommand $command
     *
     * @return void
     */
    public function handle(ClaimInviteCommand $command)
    {
        $invite = $command->invite;

        $invite->claimed_at = Carbon::now();
        $invite->save();

        event(new InviteWasClaimedEvent($invite));
    }
}
