<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration {

	public function up()
	{
		Schema::create('admins', function(Blueprint $table) {
            $table->id();
			$table->string('user_name', 191);
			$table->string('email', 191)->unique();
			$table->string('password', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('slug', 191)->nullable();
            $table->rememberToken();
            $table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('admins');
	}
}
