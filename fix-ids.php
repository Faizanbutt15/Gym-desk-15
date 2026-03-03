<?php

use App\Models\Member;

$members = Member::all();
$i = 1;

foreach ($members as $member) {
    if (empty($member->member_id)) {
        $member->update([
            'member_id' => str_pad($i, 4, '0', STR_PAD_LEFT)
        ]);
        $i++;
    }
}

echo "Fixed member IDs." . PHP_EOL;
