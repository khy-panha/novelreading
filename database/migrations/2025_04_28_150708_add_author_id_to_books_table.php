<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('books', function (Blueprint $table) {
        $table->bigInteger('author_id')->nullable()->after('author');
    });
    
}

public function down()
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn('author_id');
    });
}
};
