<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('shinbun:sync-all-feeds')->everyMinute();
