<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('constituencies', function (Blueprint $table) {
            $table->longText('geojson')->nullable()->after('center_lon');
        });
    }
};
