<?php

use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
        });

        $defaultGenders = collect(config('nyx.default_genders'))->map(function ($name) {
            return new Gender(compact('name'));
        });

        User::all()->each(function (User $user) use ($defaultGenders) {
            $user->genders()->saveMany($defaultGenders);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}
