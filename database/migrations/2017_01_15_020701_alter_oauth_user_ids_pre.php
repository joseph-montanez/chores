<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOauthUserIdsPre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->integer('user_id')->index()->nullable();
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->integer('user_id')->index()->nullable();
        });
    }
}
