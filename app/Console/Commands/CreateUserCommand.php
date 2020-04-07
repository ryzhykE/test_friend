<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Class CreateUserCommand
 * @package App\Console\Commands
 */
class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Create user');

        $name = $this->ask('Please specify name', 'User');

        $email = $this->ask('Please specify user email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->error('Email is incorrect!');

            return false;
        }
        $presentUser = User::where('email', $email)->exists();
        if ($presentUser) {
            $this->error('Email already exists in database.');

            return false;
        }

        $password = $this->secret('Please specify password for: '.$email);
        if (!$password) {
            $this->error('Password can`t be empty.');

            return false;
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);

        if ($user->save()) {
            $this->info('User successfully created!');
        } else {
            $this->warn('Error creating a user');
        }
    }
}
